<?php

namespace App\Http\Controllers\Client;

use Illuminate\Support\Facades\Lang;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderNote;
use App\Models\OrderCoupon;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodDetail;
use App\Models\Product;
use App\Models\ShippingZone;
use App\Models\ShippingZoneMethod;
use App\Models\TaxRate;
use App\Models\TaxType;
use App\Models\User;
use App\Mail\PaymentSuccess;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Arr;
use Mail;

class CheckoutController extends Controller {
	private $products;
	private $items;
	private $free_shipping_coupon;
	private $error_msg;
	private $new_coupon;

	public function __construct() {
		$this->products             = array();
		$this->items                = array();
		$this->free_shipping_coupon = false;
		$this->error_msg            = array();
		$this->new_coupon           = '';
	}

	/**
	 * Get shipping info with requested shipping address
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function getCalculatedItems( Request $request ) {
		$items                = $request->input( 'items' );
		$applied_coupons_code = $request->input( 'applied_coupons' );
		$new_coupon_code      = $request->input( 'new_coupon' );
		$customer_email       = $request->input( 'customer', '' );
		$shipping_address     = $request->input( 'shipping' );
		$billing_address      = $request->input( 'billing' );
		$emails               = array();

		$country = $shipping_address['country'];
		$state   = $shipping_address['state'];
		$zip     = $shipping_address['zip'];
		$city    = $shipping_address['city'];

		// Emails (billing, customer)
		if ( $customer_email ) {
			array_push( $emails, $customer_email );
		}

		if ( $billing_address['email'] ) {
			array_push( $emails, $billing_address['email'] );
		}

		$this->products = Product::with( array( 'categories', 'taxType.taxRates' ) )
								->whereIn( 'id', Arr::pluck( $items, 'id' ) )
								->get();

		$this->checkCartItems( $items );
		if ( count( $this->error_msg ) ) {
			abort( 500, implode( '/Product-Error/', $this->error_msg ) );
		}

		$items = $this->initialize( $items );

		if ( config( 'setting.enable_tax' ) === '1' ) {
			// Determine address to be used in tax calculations
			if ( config( 'setting.calculate_tax_based_on' ) === 'shipping' ) {
				$tax_country = $country;
				$tax_state   = $state;
				$tax_zip     = $zip;
				$tax_city    = $city;
			} elseif ( config( 'setting.calculate_tax_based_on' ) === 'billing' ) {
				$tax_country = $billing_address['country'];
				$tax_state   = $billing_address['state'];
				$tax_zip     = $billing_address['zip'];
				$tax_city    = $billing_address['city'];
			} else {
				$shop_address = preg_split( '/(^state:|^country:|:)/', config( 'setting.store_country' ) );
				$tax_country  = $shop_address[1];
				$tax_state    = count( $shop_address ) > 2 ? $shop_address[2] : null;
				$tax_zip      = config( 'setting.store_postcode' );
				$tax_city     = config( 'setting.store_city' );
			}
			// Calculate tax
			$items = $this->calcTax( $items, $tax_country, $tax_state, $tax_city, $tax_zip );
		}

		// Apply coupons
		$coupons          = Coupon::whereIn( 'code', $applied_coupons_code )->get();
		$coupons_to_apply = collect( array() );

		foreach ( $applied_coupons_code as $code ) {
			$coupon = $coupons->where( 'code', $code )->first();

			if ( $coupon ) {
				$coupons_to_apply->push( $coupon );
			}
		}

		if ( $new_coupon_code ) {
			$new_coupon = Coupon::where( 'code', $new_coupon_code )->first();

			if ( $new_coupon ) {
				if ( $new_coupon->individual_use ) {
					$coupons_to_apply = array( $new_coupon );
				} else {
					$individual_coupon = $coupons_to_apply->firstWhere( 'individual_use', true );
					if ( $individual_coupon ) {
						abort( 500, json_encode( 'Sorry coupon "' . $individual_coupon->code . '" has already been applied and cannot be used in conjunction with other coupons.' ) );
					} else {
						$coupons_to_apply->push( $new_coupon );
					}
				}
			} else {
				abort( 500, json_encode( 'Sorry, your coupon ' . $new_coupon_code . ' is incorrect.' ) );
			}

			$this->new_coupon = $new_coupon_code;
		}

		$discounted_result  = $this->applyCoupons( $items, $coupons_to_apply, $emails );
		$discounted_coupons = $discounted_result['coupons'];
		$items              = $discounted_result['items'];

		// Apply shipping
		if ( $this->products->where( 'virtual', 0 )->count() ) {
			$shipping_cost = collect( array() );
			if ( $country ) {
				$shipping_address_code = array( 'country:' . $country );
				foreach ( config( 'constant.continents' ) as $code => $continent ) {
					if ( in_array( $country, $continent['countries'] ) ) {
						array_push( $shipping_address_code, 'continent:' . $code );
						break;
					}
				}
				if ( Arr::has( config( 'constant.states' ), $country ) && count( config( 'constant.states' )[ $country ] ) && $state ) {
					array_push( $shipping_address_code, implode( ':', array( 'state', $country, $state ) ) );
				}
				$shipping_zone = ShippingZone::with( array( 'shippingZoneMethods' ) )
											->whereHas(
												'shippingLocations',
												function ( $query ) use ( $shipping_address_code ) {
													$query->whereIn( 'code', $shipping_address_code );
												}
											)->first();

				if ( $shipping_zone ) {
					foreach ( $shipping_zone->shippingZoneMethods as $shipping_method ) {
						if ( $shipping_method->type === 'free' && $this->checkFreeShippingAvailable( $items, $shipping_method ) ) {
							$shipping_cost->push(
								array(
									'id'   => $shipping_method['id'],
									'name' => $shipping_method->name,
									'cost' => 0,
									'tax'  => 0,
								)
							);
						} elseif ( $shipping_method->type === 'flat' ) {
							$shipping_cost->push(
								array(
									'id'   => $shipping_method['id'],
									'name' => $shipping_method->name,
									'cost' => $shipping_method->cost,
									'tax'  => config( 'setting.enable_tax' ) === '1' ? $this->calcShippingTax( $shipping_method, $tax_country, $tax_state, $tax_city, $tax_zip ) : 0,
								)
							);
						} elseif ( $shipping_method->type === 'local' ) {
							$shipping_cost->push(
								array(
									'id'   => $shipping_method['id'],
									'name' => $shipping_method->name,
									'cost' => $shipping_method->cost,
									'tax'  => 0,
								)
							);
						}
					}
				}
			}
		} else {
			$shipping_cost = null;
		}

		// Available Payment methods
		$pay_methods = Helper::getAvailablePaymentMethods();

		return response(
			array(
				'items'            => Arr::except( $items, array( 'tax_rate' ) ),
				'coupons'          => $discounted_coupons,
				'shipping_methods' => $shipping_cost,
				'pay_tms'          => $pay_methods,
				'error_msg'        => json_encode( $this->error_msg ),
			),
			200
		);
	}

	/**
	 * Create an order
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function placeOrder( Request $request ) {
		$items                = $request->input( 'items' );
		$applied_coupons_code = $request->input( 'applied_coupons' );
		$billing_info         = $request->input( 'billing' );
		$shipping_info        = $request->input( 'shipping' );
		$customer_email       = $request->input( 'customer', '' );

		$country = $shipping_info['country'];
		$state   = $shipping_info['state'];
		$zip     = $shipping_info['zip'];
		$city    = $shipping_info['city'];
		$emails  = array( $billing_info['email'] );
		// Emails (billing, customer)
		if ( $customer_email ) {
			array_push( $emails, $customer_email );
		}

		if ( ! Helper::validatePhoneNumber( $billing_info['phone'] ) ) {
			array_push( $this->error_msg, 'Billing phone number is invalid.' );
		}
		if ( ! Helper::validatePostalCode( $billing_info['zip'], $billing_info['country'] ) ) {
			array_push( $this->error_msg, 'Billing Postcode / Zip is invalid.' );
		}
		if ( ! Helper::validatePostalCode( $shipping_info['zip'], $shipping_info['country'] ) ) {
			array_push( $this->error_msg, 'Shipping Postcode / Zip is invalid.' );
		}

		$this->products = Product::with( array( 'categories', 'taxType.taxRates' ) )
								->whereIn( 'id', Arr::pluck( $items, 'id' ) )
								->get();

		$this->checkCartItems( $items );
		if ( count( $this->error_msg ) ) {
			abort( 500, implode( '/Product-Error/', $this->error_msg ) );
		}

		$items = $this->initialize( $items );

		if ( config( 'setting.enable_tax' ) === '1' ) {
			// Determine address to be used in tax calculations
			if ( config( 'setting.calculate_tax_based_on' ) === 'shipping' ) {
				$tax_country = $country;
				$tax_state   = $state;
				$tax_zip     = $zip;
				$tax_city    = $city;
			} elseif ( config( 'setting.calculate_tax_based_on' ) === 'billing' ) {
				$tax_country = $billing_info['country'];
				$tax_state   = $billing_info['state'];
				$tax_zip     = $billing_info['zip'];
				$tax_city    = $billing_info['city'];
			} else {
				$shop_address = preg_split( '/(^state:|^country:|:)/', config( 'setting.store_country' ) );
				$tax_country  = $shop_address[1];
				$tax_state    = count( $shop_address ) > 2 ? $shop_address[2] : null;
				$tax_zip      = config( 'setting.store_postcode' );
				$tax_city     = config( 'setting.store_city' );
			}

			// Calculate tax
			$items = $this->calcTax( $items, $tax_country, $tax_state, $tax_city, $tax_zip );
		}

		// Apply coupons
		$coupons          = Coupon::whereIn( 'code', $applied_coupons_code )->get();
		$coupons_to_apply = collect( array() );

		foreach ( $applied_coupons_code as $code ) {
			$coupon = $coupons->where( 'code', $code )->first();
			$coupons_to_apply->push( $coupon );
		}

		$discounted_result  = $this->applyCoupons( $items, $coupons_to_apply, $emails );
		$discounted_coupons = $discounted_result['coupons'];
		$items              = $discounted_result['items'];

		if ( count( $this->error_msg ) ) {
			return abort( 500, json_encode( $this->error_msg ) );
		}

		// Calculate shipping cost
		$shipping_cost      = 0;
		$shipping_tax       = 0;
		$shipping_name      = '';
		$shipping_method_id = $request->input( 'shipping_method' );

		if ( $shipping_method_id ) {
			$shipping_method = ShippingZoneMethod::findOrFail( $shipping_method_id );
			$shipping_name   = $shipping_method->name;
			$shipping_cost   = $shipping_method->cost;
			if ( $shipping_method->type === 'flat' && config( 'setting.enable_tax' ) === '1' ) {
				$shipping_tax = $this->calcShippingTax( $shipping_method, $tax_country, $tax_state, $tax_city, $tax_zip );
			}
		} elseif ( $this->products->where( 'virtual', 0 )->count() > 0 ) {
			return abort( 500, json_encode( array( 'There is no shipping method.' ) ) );
		}

		if ( ! $customer_email ) {
			$guest = User::where( 'email', $billing_info['email'] )->first();
			if ( ! $guest ) {
				$guest = User::create(
					array(
						'first_name' => $billing_info['firstName'],
						'last_name'  => $billing_info['lastName'],
						'email'      => $billing_info['email'],
					)
				);
				$guest->save();
			}
			$customer_email = $billing_info['email'];
			$customer_name  = $guest->first_name . ' ' . $guest->last_name;
		} else {
			$customer                      = User::where( 'email', $customer_email )->first();
			$customer_name                 = $customer->first_name . ' ' . $customer->last_name;
			$customer->billing_first_name  = $billing_info['firstName'];
			$customer->billing_last_name   = $billing_info['lastName'];
			$customer->billing_company     = $billing_info['company'];
			$customer->billing_address_1   = $billing_info['streetAddress1'];
			$customer->billing_address_2   = $billing_info['streetAddress2'];
			$customer->billing_city        = $billing_info['city'];
			$customer->billing_state       = $billing_info['state'];
			$customer->billing_postcode    = $billing_info['zip'];
			$customer->billing_country     = $billing_info['country'];
			$customer->billing_phone       = $billing_info['phone'];
			$customer->billing_email       = $billing_info['email'];
			$customer->shipping_first_name = $shipping_info['firstName'];
			$customer->shipping_last_name  = $shipping_info['lastName'];
			$customer->shipping_company    = $shipping_info['company'];
			$customer->shipping_address_1  = $shipping_info['streetAddress1'];
			$customer->shipping_address_2  = $shipping_info['streetAddress2'];
			$customer->shipping_city       = $shipping_info['city'];
			$customer->shipping_state      = $shipping_info['state'];
			$customer->shipping_postcode   = $shipping_info['zip'];
			$customer->shipping_country    = $shipping_info['country'];
			$customer->save();
		}

		// apply coupon
		$cart_coupons_tax    = 0;
		$cart_coupons_amount = 0;
		foreach ( $discounted_coupons as $coupon ) {
			$cart_coupons_amount += $coupon['amount'];
			$cart_coupons_tax    += $coupon['tax'];
		}

		$order_tax = array_sum( Arr::pluck( $items, 'tax_amount' ) )
					+ $shipping_tax
					- $cart_coupons_tax;
		if ( config( 'setting.tax_round_at_subtotal' ) ) {
			$order_tax = round( $order_tax, config( 'setting.number_of_decimal' ) );
		}

		$order_total_price = array_sum( Arr::pluck( $items, 'sum' ) ) + $shipping_cost + $order_tax - $cart_coupons_amount;

		// handle payment
		$payment_method = $request->input( 'payment_method' );
		$order_info     = '';
		$payment_status = 'failed';

		$next_order_id = Order::latest()->first()->id + 1;

		if ( $payment_method['slug'] === 'cash_on_delivery' ) {
			$order_status   = 'processing';
			$payment_status = 'success';
		} elseif ( $payment_method['slug'] == 'stripe' ) {
			$secret_key = PaymentMethodDetail::where( 'payment_method_id', $payment_method['id'] )
											->where( 'meta', 'secret_key' )
											->first()
											->value;

			//  require file
			require 'vendor/autoload.php';

			\Stripe\Stripe::setApiKey( $secret_key );

			$amount = $order_total_price;
			if ( config( 'setting.currency' ) == 'USD' ) {
				$amount = 100 * $order_total_price;
			}

			$session = \Stripe\Checkout\Session::create(
				array(
					'payment_method_types' => array( 'card' ),
					'customer_email'       => $billing_info['email'],
					'line_items'           => array(
						array(
							'price_data' => array(
								'currency'     => strtolower( config( 'setting.currency' ) ),
								'product_data' => array(
									'name' => 'Pay for your order',
								),
								'unit_amount'  => $amount,
							),
							'quantity'   => 1,
						),
					),
					'mode'                 => 'payment',
					'success_url'          => env( 'APP_URL' ) . '/pages/order/' . $next_order_id,
					'cancel_url'           => env( 'APP_URL' ) . '/pages/checkout',
				)
			);

			if ( $session->payment_status == 'unpaid' ) {
				$order_status = 'pending';
				$order_info   = array(
					'session_id'           => $session->id,
					'payment_intent'       => $session->payment_intent,
					'session_amount_total' => $session->amount_total,
				);

				$payment_status = 'success';
			}
		} elseif ( $payment_method['slug'] == 'paypal' ) {   // paypal
			$payment_status = 'success';
			$order_status   = 'pending';
			$paypal_info    = 'https://www.paypal.com/cgi-bin/webscr?';

			if ( $payment_method['environment'] == 'sandbox' ) {
				$paypal_info = 'https://www.sandbox.paypal.com/cgi-bin/webscr?';
			}

			if ( ! isset( $payment_method['paypal_email'] ) ) {
				abort( 500 );
			}

			$paypal_info .= 'cmd=_cart&business=' . $payment_method['paypal_email'] .
						'&no_note=1' .
						'&upload=1' .
						'&currency_code=' . config( 'setting.currency' ) .
						'&charset=utf-8' .
						'&return=' . env( 'APP_URL' ) . '/pages/order/' . $next_order_id .
						'&cancel_return=' . env( 'APP_URL' ) . '/pages/checkout' .
						'&paymentaction=sale' .
						'&custom={"order_id":' . $next_order_id . '}' .
						'&notify_url=' . env( 'APP_URL' ) . '/paypal/hook' .
						'&first_name=' . $billing_info['firstName'] .
						'&last_name=' . $billing_info['lastName'] .
						'&address1=' . $billing_info['streetAddress1'] .
						'&address2=' . $billing_info['streetAddress2'] .
						'&city=' . $billing_info['city'] .
						'&state=' . $billing_info['state'] .
						'&country=' . $billing_info['country'] .
						'&zip=' . $billing_info['zip'] .
						'&email=' . $billing_info['email'] .
						'&no_shipping=0' .
						'&tax_cart=' . $order_tax .
						'&discount_amount_cart=' . $cart_coupons_amount .
						'&shipping_1=' . $shipping_cost;

			foreach ( $items as $key => $item ) {
				$paypal_info .= '&item_name_' . ( $key + 1 ) . '=' . $item['name'] .
							'&quantity_' . ( $key + 1 ) . '=' . $item['qty'] .
							'&amount_' . ( $key + 1 ) . '=' . round( $item['sum'] / $item['qty'], 2 );
			}
		}

		if ( $payment_status == 'failed' ) {
			return abort( 500, json_encode( array( Lang::get( 'custom.payment_failure' ) ) ) );
		}

		$order = new Order(
			array(
				'customer_name'       => $customer_name,
				'customer_email'      => $customer_email,
				'billing_first_name'  => $billing_info['firstName'],
				'billing_last_name'   => $billing_info['lastName'],
				'billing_company'     => $billing_info['company'],
				'billing_street_1'    => $billing_info['streetAddress1'],
				'billing_street_2'    => $billing_info['streetAddress2'],
				'billing_city'        => $billing_info['city'],
				'billing_state'       => $billing_info['state'],
				'billing_postcode'    => $billing_info['zip'],
				'billing_country'     => $billing_info['country'],
				'billing_phone'       => $billing_info['phone'],
				'billing_email'       => $billing_info['email'],
				'shipping_first_name' => $shipping_info['firstName'],
				'shipping_last_name'  => $shipping_info['lastName'],
				'shipping_company'    => $shipping_info['company'],
				'shipping_street_1'   => $shipping_info['streetAddress1'],
				'shipping_street_2'   => $shipping_info['streetAddress2'],
				'shipping_city'       => $shipping_info['city'],
				'shipping_state'      => $shipping_info['state'],
				'shipping_postcode'   => $shipping_info['zip'],
				'shipping_country'    => $shipping_info['country'],
				'payment_method'      => $payment_method['name'],
				'shipping_method'     => $shipping_name,
				'shipping_cost'       => $shipping_cost,
				'shipping_tax'        => $shipping_tax,
				'order_tax'           => $order_tax,
				'order_total_price'   => $order_total_price,
				'order_total_qty'     => array_sum( Arr::pluck( $items, 'qty' ) ),
				'status'              => $order_status,
				'order_info'          => json_encode( $order_info ),
			)
		);

		$groupItems = collect( $items )->groupBy( 'author_id' );

		if ( $groupItems->count() == 1 ) {
			$order->author_id  = $groupItems->keys()[0];
			$order->vendor_net = Helper::calcVendorNetsale( $payment_method['slug'], $order->order_total_price );
		}

		$order->save();

		foreach ( $items as $item ) {
			$product         = $this->products->where( 'id', $item['id'] )->first();
			$shipping_amount = 0;
			if ( $product->manage_stock ) {
				$product_record                  = Product::findOrFail( $product->id );
				$product_record->stock_quantity -= $item['qty'];
				$product_record->save();
			}
			if ( Arr::has( $item, 'shipping_amount' ) ) {
				$shipping_amount += $item['shipping_amount'] + $item['shipping_tax_amount'];
			}
			$tax_amount = $item['tax_amount'] * ( $item['sum'] - $item['coupon_amount'] ) / $item['sum'];
			$order_item = new OrderItem(
				array(
					'order_id'            => $order->id,
					'product_id'          => $item['id'],
					'parent_id'           => $item['parent_id'],
					'name'                => $item['name'],
					'qty'                 => $item['qty'],
					'net_revenue'         => $item['sum'] - $item['coupon_amount'],
					'gross_revenue'       => $item['sum'] - $item['coupon_amount'] + $tax_amount + $shipping_amount,
					'coupon_amount'       => $item['coupon_amount'],
					'tax_amount'          => $tax_amount,
					'shipping_amount'     => Arr::has( $item, 'shipping_amount' ) ? $item['shipping_amount'] : 0,
					'shipping_tax_amount' => Arr::has( $item, 'shipping_tax_amount' ) ? $item['shipping_tax_amount'] : 0,
				)
			);
			$order_item->save();
		}

		if ( $groupItems->count() > 1 ) {
			$groupItems->each(
				function ( $group, $group_key ) use ( $order, $payment_method ) {
					$temp_total_price = $group->sum(
						function ( $temp ) {
							return $temp['sum'] - $temp['coupon_amount'] + $temp['tax_amount'] * ( $temp['sum'] - $temp['coupon_amount'] ) / $temp['sum'];
						}
					);

					$sub_order = Order::create(
						array(
							'customer_name'       => $order->customer_name,
							'customer_email'      => $order->customer_email,
							'billing_first_name'  => $order->billing_first_name,
							'billing_last_name'   => $order->billing_last_name,
							'billing_company'     => $order->billing_company,
							'billing_street_1'    => $order->billing_street_1,
							'billing_street_2'    => $order->billing_street_2,
							'billing_city'        => $order->billing_city,
							'billing_state'       => $order->billing_state,
							'billing_postcode'    => $order->billing_postcode,
							'billing_country'     => $order->billing_country,
							'billing_phone'       => $order->billing_phone,
							'billing_email'       => $order->billing_email,
							'shipping_first_name' => $order->shipping_first_name,
							'shipping_last_name'  => $order->shipping_last_name,
							'shipping_company'    => $order->shipping_company,
							'shipping_street_1'   => $order->shipping_street_1,
							'shipping_street_2'   => $order->shipping_street_2,
							'shipping_city'       => $order->shipping_city,
							'shipping_state'      => $order->shipping_state,
							'shipping_postcode'   => $order->shipping_postcode,
							'shipping_country'    => $order->shipping_country,
							'payment_method'      => $order->payment_method,
							'shipping_method'     => $order->shipping_method,
							'shipping_cost'       => 0,
							'shipping_tax'        => 0,
							'order_tax'           => $group->sum(
								function ( $temp ) {
										return $temp['tax_amount'] * ( $temp['sum'] - $temp['coupon_amount'] ) / $temp['sum'];
								}
							),
							'order_total_price'   => $temp_total_price,
							'order_total_qty'     => $group->sum( 'qty' ),
							'status'              => $order->status,
							'order_info'          => json_encode( $order->order_info ),
							'author_id'           => $group_key,
							'order_type'          => 'suborder',
							'parent'              => $order->id,
							'vendor_net'          => Helper::calcVendorNetsale( $payment_method['slug'], $temp_total_price ),
						)
					);
					$group->each(
						function ( $temp ) use ( $sub_order ) {
							$tax_amount          = $temp['tax_amount'] * ( $temp['sum'] - $temp['coupon_amount'] ) / $temp['sum'];
							$shipping_amount     = Arr::has( $temp, 'shipping_amount' ) ? $temp['shipping_amount'] : 0;
							$shipping_tax_amount = Arr::has( $temp, 'shipping_tax_amount' ) ? $temp['shipping_tax_amount'] : 0;

							OrderItem::create(
								array(
									'order_id'            => $sub_order->id,
									'product_id'          => $temp['id'],
									'parent_id'           => $temp['parent_id'],
									'name'                => $temp['name'],
									'qty'                 => $temp['qty'],
									'net_revenue'         => $temp['sum'] - $temp['coupon_amount'],
									'gross_revenue'       => $temp['sum'] - $temp['coupon_amount'] + $tax_amount + $shipping_amount,
									'coupon_amount'       => $temp['coupon_amount'],
									'tax_amount'          => $tax_amount,
									'shipping_amount'     => $shipping_amount,
									'shipping_tax_amount' => $shipping_tax_amount,
								)
							);
						}
					);
				}
			);
		}

		foreach ( $discounted_coupons as $coupon ) {
			$coupon_id    = $coupons->where( 'code', $coupon['code'] )->first()->id;
			$order_coupon = new OrderCoupon(
				array(
					'order_id'          => $order->id,
					'coupon_id'         => $coupon_id,
					'coupon_code'       => $coupon['code'],
					'coupon_amount'     => $coupon['amount'],
					'coupon_tax_amount' => $coupon['tax'],
				)
			);
			$order_coupon->save();
		}

		if ( $payment_method['slug'] == 'stripe' ) {
			return array(
				'session_id' => $session->id,
				'order_id'   => $order->id,
				'user'       => $request->input( 'customer' ) ? $customer : null,
			);
		} elseif ( $payment_method['slug'] == 'paypal' ) {
			return array(
				'paypal_info' => $paypal_info,
				'user'        => $request->input( 'customer' ) ? $customer : null,
			);
		}

		return response(
			array(
				'order_id' => $order->id,
				'user'     => $request->input( 'customer' ) ? $customer : null,
			),
			200
		);
	}

	/**
	 * Get available payment methods and information
	 *
	 */
	public function getAvailablePaymentMethods() {
		return Helper::getAvailablePaymentMethods();
	}


	/**
	 * Change status using stripe webhook
	 */
	public function stripeHookHandler( Request $request ) {
		$order_info = json_encode(
			array(
				'session_id'           => $request->input( 'data' )->id,
				'payment_intent'       => $request->input( 'data' )->payment_intent,
				'session_amount_total' => $request->input( 'data' )->amount_total,
			)
		);

		$order = Order::where( 'order_info', 'LIKE', '%' . $order_info . '%' )->where( 'status', 'pending' )->first();

		if ( ! $order ) {
			abort( 500 );
		}

		$new_status = '';                                       // Order status will be changed to $new_status

		if ( $request->input( 'type' ) == 'payment_intent.succeeded' ) {
			$new_status = 'precessing';

			Mail::to( $order->customer_email )->send( new PaymentSuccess( $order ) );
		} elseif ( $request->input( 'type' ) == 'checkout.session.completed' ) {
			return;
		} else {
			$new_status = 'failed';
		}

		$author_id     = User::where( 'role_id', 7 )->first()->id;
		$response_data = array();

		if ( $order->status == $new_status ) {                    // if pre_status equals new_status
			return;
		}

		$prev_status = $order->status;

		$sub_orders = Order::where( 'parent', $order->id )
						->where( 'order_type', 'suborder' )
						->get();

		foreach ( $sub_orders as $sub_order ) {
			if ( $sub_order->status == 'completed' ) {
				$vendor = Vendor::where( 'user_id', $sub_order->author_id )->first();
				if ( $vendor ) {
					$vendor->balance = $vendor->balance - Helper::calcVendorNetsale( Str::slug( $sub_order->payment_method, '_' ), $sub_order->order_total_price );

					$vendor->save();
				}
			}

			$sub_order->status = $new_status;
			$sub_order->save();
		}

		if ( $prev_status == 'completed' ) {
			$vendor = Vendor::where( 'user_id', $order->author_id )->first();

			if ( $vendor ) {
				$vendor->balance = $vendor->balance - Helper::calcVendorNetsale( Str::slug( $order->payment_method, '_' ), $order->order_total_price );
				$vendor->save();
			}
		}

		$order->status = $new_status;                           // order status change

		$order->save();

		$note_content = 'Status changed from ' . config( 'constant.payment_status' )[ $prev_status ] . ' to ' . config( 'constant.payment_status' )[ $order->status ] . '.';

		$note = new OrderNote(
			array(
				'order_id'  => $order->id,
				'author_id' => $author_id,
				'content'   => $note_content,
			)
		);

		$note->save();
	}

	/**
	 * Change status using paypal webhook
	 */
	public function paypalHookHandler( Request $request ) {
		$environment = PaymentMethodDetail::where( 'payment_method_id', 2 )
											->where( 'meta', 'environment' )
											->first()
											->value;

		$url = $environment == 'sandbox' ? 'https://www.sandbox.paypal.com/cgi-bin/webscr?' : 'https://www.paypal.com/cgi-bin/webscr?';

		$req = 'cmd=_notify-validate';
		foreach ( $request->all() as $key => $value ) {
			$value = urlencode( $value );
			$req  .= '&' . $key . '=' . $value;
		}

		/************* validate ipn ***************/
		$ch = curl_init( $url );
		if ( $ch == false ) {
			return false;
		}
		curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $req );
		curl_setopt( $ch, CURLOPT_SSLVERSION, 6 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
		curl_setopt( $ch, CURLOPT_FORBID_REUSE, 1 );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 30 );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Connection: Close', 'User-Agent: company-name' ) );
		$res = curl_exec( $ch );

		/*
		* Inspect IPN validation result and act accordingly
		* Split response headers and payload, a better way for strcmp
		*/
		$tokens = explode( "\r\n\r\n", trim( $res ) );
		$res    = trim( end( $tokens ) );

		if ( strcmp( $res, 'VERIFIED' ) != 0 && strcasecmp( $res, 'VERIFIED' ) != 0 ) {
			return;
		}

		/************* check response ***************/
		if ( $request->input( 'custom' ) ) {
			$order_id = json_decode( $request->input( 'custom' ) )->order_id;

			$order = Order::findOrFail( $order_id );
		} else {
			return;
		}

		$new_status     = 'failed';
		$order_info     = $order->order_info;
		$payment_status = $request->input( 'payment_status' );
		if ( strcmp( $payment_status, 'failed' ) == 0 || strcmp( $payment_status, 'Failed' ) == 0 || strcmp( $payment_status, 'denied' ) == 0 || strcmp( $payment_status, 'Denied' ) == 0 || strcmp( $payment_status, 'expired' ) == 0 || strcmp( $payment_status, 'Expired' ) == 0 || strcmp( $payment_status, 'voided' ) == 0 || strcmp( $payment_status, 'Voided' ) == 0 ) {
			$new_status = 'failed';
		} elseif ( strcmp( $payment_status, 'completed' ) == 0 || strcmp( $payment_status, 'Completed' ) == 0 || $payment_status == 'Pending' || $payment_status == 'pending' ) {
			$order_info = array(
				'payment_type'    => $request->filled( 'payment_type' ) ? $request->input( 'payment_type' ) : '',
				'txn_id'          => $request->filled( 'txn_id' ) ? $request->input( 'txn_id' ) : '',
				'payment_status'  => $request->filled( 'payment_status' ) ? $request->input( 'payment_status' ) : '',
				'mc_gross'        => $request->filled( 'mc_gross' ) ? $request->input( 'mc_gross' ) : '',
				'transaction_fee' => $request->input( 'payment_status' ) == 'Completed' ? $request->input( 'mc_fee' ) : '',
			);

			if ( strcmp( $payment_status, 'completed' ) == 0 || strcasecmp( $payment_status, 'Completed' ) == 0 ) {
				$new_status = 'processing';
			} else {
				$new_status = 'on-hold';
			}
		}

		$author_id     = User::where( 'role_id', 7 )->first()->id;
		$response_data = array();

		if ( $order->status == $new_status ) {                    // if pre_status equals new_status
			return;
		}
		$prev_status = $order->status;

		$sub_orders = Order::where( 'parent', $order->id )
					->where( 'order_type', 'suborder' )
					->get();

		if ( $new_status == 'completed' ) {                       // if new_status is 'completed'
			foreach ( $sub_orders as $sub_order ) {
				if ( $sub_order->status != 'completed' ) {
					$vendor = Vendor::where( 'user_id', $sub_order->author_id )->first();

					if ( $vendor ) {
						$vendor->balance = $vendor->balance + Helper::calcVendorNetsale( Str::slug( $sub_order->payment_method, '_' ), $sub_order->order_total_price );
						$vendor->save();
					}
				}

				$sub_order->status = 'completed';
				$sub_order->save();
			}

			$vendor = Vendor::where( 'user_id', $order->author_id )->first();
			if ( $vendor ) {
				$vendor->balance = $vendor->balance + Helper::calcVendorNetsale( Str::slug( $order->payment_method, '_' ), $order->order_total_price );
				$vendor->save();
			}
		} else {
			foreach ( $sub_orders as $sub_order ) {
				if ( $sub_order->status == 'completed' ) {
					$vendor = Vendor::where( 'user_id', $sub_order->author_id )->first();
					if ( $vendor ) {
						$vendor->balance = $vendor->balance - Helper::calcVendorNetsale( Str::slug( $sub_order->payment_method, '_' ), $sub_order->order_total_price );

						$vendor->save();
					}
				}

				$sub_order->status = $new_status;
				$sub_order->save();
			}

			if ( $prev_status == 'completed' ) {
				$vendor = Vendor::where( 'user_id', $order->author_id )->first();

				if ( $vendor ) {
					$vendor->balance = $vendor->balance - Helper::calcVendorNetsale( Str::slug( $order->payment_method, '_' ), $order->order_total_price );
					$vendor->save();
				}
			}
		}

		$order->status     = $new_status;                           // order status change
		$order->order_info = $order_info;

		$order->save();

		$note_content = 'Status changed from ' . config( 'constant.payment_status' )[ $prev_status ] . ' to ' . config( 'constant.payment_status' )[ $order->status ] . '.';

		$note = new OrderNote(
			array(
				'order_id'  => $order->id,
				'author_id' => $author_id,
				'content'   => $note_content,
			)
		);
		$note->save();
	}
	/**
	 * Initialize cart items;
	 *
	 * @param array $items
	 */
	private function initialize( $items ) {
		foreach ( $items as &$item ) {
			$product               = $this->products->where( 'id', $item['id'] )->first();
			$item['sum']           = $product->min_max_price[0] * $item['qty'];
			$item['tax_amount']    = 0;
			$item['tax_rate']      = 0;
			$item['coupon_amount'] = 0;
			$item['author_id']     = $product->author_id;
		}

		return $items;
	}

	/**
	 * Check cart items' stock status
	 *
	 * @param array $items
	 */
	private function checkCartItems( $items ) {
		foreach ( $items as $item ) {
			$product = $this->products->where( 'id', $item['id'] )->first();
			$canSell = true;
			if ( ! $product ) {
				array_push( $this->error_msg, $item['name'] . ' no longer exist.' );
			}
			if ( ! $product->manage_stock ) {
				if ( $product->stock_status === 'out-of-stock' ) {
					$canSell = false;
				}
			} else {
				if ( $product->stock_quantity < $item['qty'] && $product->allow_backorder === 'no' ) {
					$canSell = false;
				} else {
					$this->products->transform(
						function ( $each ) use ( $product, $item ) {
							if ( $each->id === $product->id ) {
								$each->stock_quantity -= $item['qty'];
							}
							return $each;
						}
					);
				}
			}
			if ( ! $canSell ) {
				array_push( $this->error_msg, $item['name'] . ' is out of stock.' );
			}
		}
	}

	/**
	 * Apply coupons and return discounted cart items
	 *
	 * @param array $items
	 * @param array<App\Models\Coupon> $coupons
	 * @param string $email
	 * @return array
	 */
	private function applyCoupons( $items, $coupons, $email ) {
		$coupon_discount            = collect( array() );
		$this->free_shipping_coupon = false;

		$total_spend = 0;

		foreach ( $items as &$item ) {
			$product               = $this->products->where( 'id', $item['id'] )->first();
			$total_spend          += $product->min_max_price[0] * $item['qty'];
			$item['coupon_amount'] = 0;
		}

		foreach ( $coupons as $coupon ) {
			$validate = Helper::validateCoupon( $coupon, $total_spend, $email );
			if ( $validate ) {
				if ( $coupon->code !== $this->new_coupon ) {
					$validate .= ' - has been removed from your order';
				}
				array_push( $this->error_msg, $validate . '.' );
				continue;
			}
			$applied         = 0;
			$discount_amount = 0;
			$tax_amount      = 0;

			foreach ( $items as &$item ) {
				$product  = $this->products->where( 'id', $item['id'] )->first();
				$discount = Helper::calcCouponAmount( $product, $coupon );

				if ( $discount ) {
					if ( $coupon->discount_type === 'cart' ) {
						$applied ++;
						break;
					} else {
						$qty = $item['qty'];
						if ( $coupon->limit_x_items ) {
							$qty = min( $coupon->limit_x_items - $applied, $item['qty'] );
						}

						$applied               += $qty;
						$item['coupon_amount'] += round( $discount * $qty, 2 );
						$discount_amount       += $discount * $qty;

						if ( Arr::has( $item, 'tax_amount' ) ) {
							$tax_amount += $item['tax_amount'] * $discount * $qty / ( $product->min_max_price[0] * $item['qty'] );
						}
						if ( $coupon->limit_x_items && $coupon->limit_x_items === $applied ) {
							break;
						}
					}
				}
			}

			if ( $applied && $coupon->discount_type === 'cart' ) {
				$total_qty = array_sum( Arr::pluck( $items, 'qty' ) );
				foreach ( $items as &$item ) {
					$product                = $this->products->where( 'id', $item['id'] )->first();
					$discount               = $coupon->amount * $item['qty'] / $total_qty;
					$discount_amount       += $discount;
					$item['coupon_amount'] += round( $discount, 2 );

					if ( Arr::has( $item, 'tax_amount' ) ) {
						$tax_amount += $item['tax_amount'] * $discount / ( $product->min_max_price[0] * $item['qty'] );
					}
				}
			}

			if ( $applied && $discount_amount > 0 || ( $discount_amount + $coupon->amount === 0 ) ) {
				if ( config( 'setting.tax_round_at_subtotal' ) === '0' ) {
					$tax_amount = round( $tax_amount, config( 'setting.number_of_decimal' ) );
				}

				$coupon_discount->push(
					array(
						'code'   => $coupon->code,
						'amount' => round( $discount_amount, 2 ),
						'tax'    => $tax_amount,
					)
				);
				if ( $coupon->free_shipping ) {
					$this->free_shipping_coupon = true;
				}
			} else {
				$msg = 'Sorry , coupon "' . $coupon->code . '" is not applicable to selected products';
				if ( $coupon->code !== $this->new_coupon ) {
					$msg .= ' - has been removed from your order';
				}
				array_push( $this->error_msg, $msg . '.' );
			}
		}

		return array(
			'coupons' => $coupon_discount,
			'items'   => $items,
		);
	}

	/**
	 * Calc tax amount for products based on given address
	 *
	 * @param array $items
	 * @param string $country
	 * @param string $state
	 * @param string $city
	 * @param string $zip
	 * @return array
	 */
	private function calcTax( $items, $country, $state, $city, $zip ) {
		foreach ( $items as &$item ) {
			$product            = $this->products->where( 'id', $item['id'] )->first();
			$item['sum']        = $product->min_max_price[0] * $item['qty'];
			$item['tax_amount'] = 0;
			$item['tax_rate']   = 0;
			if ( $product->tax_status !== 'none' ) {
				$rate = $product->taxType->taxRates->whereIn( 'country', array( $country, '' ) )
													->whereIn( 'state', array( $state, '' ) )
													->whereIn( 'city', array( $city, '' ) )
													->whereIn( 'postcode', array( $zip, '' ) )
													->first();
				if ( $rate ) {
					$item['tax_rate']   = $rate->rate;
					$item['tax_amount'] = $item['sum'] * $rate->rate / 100;
					if ( ! config( 'setting.tax_round_at_subtotal' ) ) {
						$item['tax_amount'] = round( $item['tax_amount'], config( 'setting.number_of_decimal' ) );
					}
				}
			}
		}
		return $items;
	}

	/**
	 * Check free shipping available
	 *
	 * @param array $items
	 * @param App\Models\ShippingZoneMethod $shipping_method
	 * @return boolean
	 */
	private function checkFreeShippingAvailable( $items, $shipping_method ) {
		if ( $shipping_method->free_shipping_requirements === '' ) {
			return true;
		} elseif ( $shipping_method->free_shipping_requirements === 'coupon' && $this->free_shipping_coupon ) {
			return true;
		}

		$total_amount = 0;
		foreach ( $items as $item ) {
			$product       = $this->products->where( 'id', $item['id'] )->first();
			$total_amount += $item['sum'];
		}

		if ( $shipping_method->free_shipping_requirement === 'min_amount' ) {
			return $total_amount >= $shipping_method->minimum_order_amount;
		} elseif ( $shipping_method->free_shipping_requirement === 'either' ) {
			return $total_amount >= $shipping_method->minimum_order_amount || $this->free_shipping_coupon;
		}
		return $total_amount >= $shipping_method->minimum_order_amount && $this->free_shipping_coupon;
	}

	/**
	 * Calculate shipping tax amount
	 *
	 * @param App\Models\ShippingZoneMethod $shipping_method
	 * @return double
	 */
	private function calcShippingTax( $shipping_method, $country, $state, $city, $zip ) {
		$shipping_tax = config( 'setting.shipping_tax_class' );
		$tax_rate     = TaxRate::whereHas(
			'taxType',
			function ( $query ) use ( $shipping_tax ) {
								return $query->where( 'slug', $shipping_tax );
			}
		)->whereIn( 'country', array( $country, '' ) )
							->whereIn( 'state', array( $state, '' ) );
		if ( $zip ) {
			$tax_rate = $tax_rate->whereIn( 'postcode', array( $zip, '' ) );
		}
		if ( $city ) {
			$tax_rate = $tax_rate->whereIn( 'city', array( $city, '' ) );
		}
		$tax_rate = $tax_rate->latest()->first();
		if ( $shipping_method->tax_status === 'taxable' && $tax_rate && $tax_rate->is_shipping ) {
			$tax = $shipping_method->cost * $tax_rate->rate / 100;
			if ( ! config( 'setting.tax_round_at_subtotal' ) ) {
				return round( $tax, config( 'setting.number_of_decimal' ) );
			}
			return $tax;
		}

		return 0;
	}

	/**
	 * Calculate shipping amount by rate
	 *
	 * @param array $items
	 * @param App\Models\ShippingZoneMethod $shipping_method
	 * @return array
	 */
	private function calcShippingAmountIndividually( $items, $shipping_method ) {
		$shipping_cost = 0;
		$shipping_tax  = 0;
		foreach ( $items as &$item ) {
			$item['shipping_amount']     = ( $item['sum'] - $item['coupon_amount'] ) * $shipping_method->cost / 100;
			$item['shipping_tax_amount'] = 0;
			if ( $shipping_method->tax_status === 'taxable' ) {
				$item['shipping_tax_amount'] = $item['shipping_amount'] * $item['tax_rate'] / 100;
			}
			$shipping_tax += $item['shipping_tax_amount'];
		}

		return array(
			array(
				'items'         => $items,
				'shipping_cost' => $shipping_cost,
				'shipping_tax'  => $shipping_tax,
			),
		);
	}
}
