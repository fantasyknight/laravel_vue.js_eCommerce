<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;

use App\Models\Setting;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodDetail;
use App\Models\TaxType;
use App\Models\TaxRate;
use App\Models\ShippingZone;
use App\Models\ShippingZoneMethod;

use App\Helpers\Helper;

use Str;

class SettingController extends Controller {

	/**
	 * Display ecommerce general page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceGeneral() {
		$index_array = array();
		for ( $i = 7; $i < 24; $i++ ) {
			array_push( $index_array, $i );
		}

		$settings = Setting::find( $index_array );
		$setts    = collect();

		foreach ( $settings as $setting ) {
			$setts->put( $setting->meta, $setting->value );
		}

		return view( 'admin.ecommerce.settings.general', $setts );
	}

	/**
	 * Display ecommerce product page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceProduct() {
		$index_array = array();
		for ( $i = 24; $i < 40; $i++ ) {
			array_push( $index_array, $i );
		}

		$settings = Setting::find( $index_array );
		$setts    = collect();

		foreach ( $settings as $setting ) {
			$setts->put( $setting->meta, $setting->value );
		}

		return view( 'admin.ecommerce.settings.products', $setts );
	}

	/**
	 * Display ecommerce payment page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ecommercePayment( Request $request ) {
		if ( $request->filled( 'search-term' ) ) {
			$payment_methods = PaymentMethod::where( 'name', 'LIKE', '%' . $request->input( 'search-term' ) . '%' )->get();
		} else {
			$payment_methods = PaymentMethod::all();
		}

		$request->flashOnly( 'search-term' );
		return view( 'admin.ecommerce.settings.payment.index', array( 'payment_methods' => $payment_methods ) );
	}

	/**
	 * Display ecommerce shipping page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceShipping( Request $request ) {
		$index_array = array();
		for ( $i = 48; $i <= 51; $i++ ) {
			array_push( $index_array, $i );
		}

		$settings = Setting::find( $index_array );
		$setts    = collect();

		foreach ( $settings as $setting ) {
			$setts->put( $setting->meta, $setting->value );
		}

		$request->flash();
		$search_term = '%' . $request->input( 'search-term' ) . '%';

		if ( $request->filled( 'filter-by' ) && $request->input( 'filter-by' ) != '*' ) {
			if ( $request->input( 'filter-by' ) == 'name' ) {
				$shipping_zones = ShippingZone::where( 'name', 'LIKE', $search_term )
												->sortable()
												->paginate( 10 );
			} elseif ( $request->input( 'filter-by' ) == 'regions' ) {
				$shipping_zones = ShippingZone::whereHas(
					'shippingLocations',
					function ( $query ) use ( $search_term ) {
													$query->where( 'name', 'LIKE', $search_term );
					}
				)
												->sortable()
												->paginate( 10 );
			} elseif ( $request->input( 'filter-by' ) == 'methods' ) {
				$shipping_zones = ShippingZone::whereHas(
					'shippingZoneMethods',
					function ( $query ) use ( $search_term ) {
													$query->where( 'name', 'LIKE', $search_term );
					}
				)
												->sortable()
												->paginate( 10 );
			}
		} else {
			$shipping_zones = ShippingZone::where( 'name', 'LIKE', $search_term )
								->orWhere( 'name', 'LIKE', $search_term )
								->orWhereHas(
									'shippingZoneMethods',
									function ( $query ) use ( $search_term ) {
										$query->where( 'name', 'LIKE', $search_term );
									}
								)
								->orWhereHas(
									'shippingLocations',
									function ( $query ) use ( $search_term ) {
										$query->where( 'name', 'LIKE', $search_term );
									}
								)
								->sortable()
								->paginate( 10 );
		}

		return view( 'admin.ecommerce.settings.shipping.list', $setts, array( 'shipping_zones' => $shipping_zones ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceShippingCreate() {
		return view( 'admin.ecommerce.settings.shipping.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceShippingStore( Request $request ) {
		$shipping_zone = ShippingZone::create(
			array(
				'name'    => $request->input( 'name' ),
				'enabled' => true,
			)
		);
		$codes_array   = array();

		if ( $request->filled( 'code' ) ) {
			foreach ( $request->input( 'code' ) as $code ) {
				$class = explode( ':', $code );
				if ( $class[0] == 'continent' ) {
					$name = config( 'constant.continents' )[ $class[1] ]['name'];
					$type = 'continent';
				} elseif ( $class[0] == 'country' ) {
					$name = config( 'constant.countries' )[ $class[1] ];
					$type = 'country';
				} elseif ( $class[0] == 'state' ) {
					$name = config( 'constant.states' )[ $class[1] ][ $class[2] ];
					$type = 'state';
				}

				array_push(
					$codes_array,
					array(
						'code' => $code,
						'name' => $name,
						'type' => $type,
					)
				);
			}

			$shipping_zone->shippingLocations()->createMany( $codes_array );
		}

		return redirect( '/admin/ecommerce/settings/shipping/' . $shipping_zone->id . '/edit' );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceShippingEdit( Request $request, $id ) {
		$shipping_zone = ShippingZone::findOrFail( $id );

		return view( 'admin.ecommerce.settings.shipping.edit', array( 'shipping_zone' => $shipping_zone ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceShippingUpdate( Request $request, $id ) {
		$shipping_zone       = ShippingZone::findOrFail( $id );
		$shipping_zone->name = $request->name;

		$codes_array = array();
		if ( $request->filled( 'code' ) ) {
			foreach ( $request->input( 'code' ) as $code ) {
				$class = explode( ':', $code );
				if ( $class[0] == 'continent' ) {
					$name = config( 'constant.continents' )[ $class[1] ]['name'];
					$type = 'continent';
				} elseif ( $class[0] == 'country' ) {
					$name = config( 'constant.countries' )[ $class[1] ];
					$type = 'country';
				} elseif ( $class[0] == 'state' ) {
					$name = config( 'constant.states' )[ $class[1] ][ $class[2] ];
					$type = 'state';
				}

				array_push(
					$codes_array,
					array(
						'code' => $code,
						'name' => $name,
						'type' => $type,
					)
				);
			}
			$shipping_zone->shippingLocations()->delete();
			$shipping_zone->shippingLocations()->createMany( $codes_array );
		}
		$shipping_zone->save();
		return back()->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceShippingBulkDestroy( Request $request ) {
		ShippingZone::destroy( $request->data );
	}

	/**
	 * Get the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceShippingMethod( Request $request, $id ) {
		$method = ShippingZoneMethod::findOrFail( $id );
		return $method;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceShippingMethodStore( Request $request ) {
		ShippingZoneMethod::create(
			array(
				'shipping_zone_id' => $request->shipping_zone_id,
				'name'             => $request->name,
				'description'      => $request->description,
				'type'             => $request->type,
			)
		);
	}

	/**
	 * change status of shipping method.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceShippingMethodStatus( Request $request ) {
		$method          = ShippingZoneMethod::findOrFail( $request->id );
		$method->enabled = $request->enabled;
		$method->save();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceShippingMethodUpdate( Request $request, $id ) {
		$method       = ShippingZoneMethod::findOrFail( $id );
		$method->name = $request->name;

		if ( $request->filled( 'cost' ) ) {
			$method->cost = intval( $request->cost );
		}

		if ( $request->filled( 'tax_status' ) ) {
			$method->tax_status = $request->tax_status;
		}

		if ( $request->filled( 'minimum_order_amount' ) ) {
			$method->minimum_order_amount = $request->minimum_order_amount;
		}

		$method->free_shipping_requirement = $request->free_shipping_requirement;
		$method->save();
		return $method;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceShippingMethodDestroy( $id ) {
		ShippingZoneMethod::destroy( $id );
	}

	/**
	 * Display ecommerce tax page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceTax( Request $request ) {
		$index_array = array();
		for ( $i = 40; $i < 48; $i++ ) {
			array_push( $index_array, $i );
		}

		$settings = Setting::find( $index_array );
		$setts    = collect();

		foreach ( $settings as $setting ) {
			$setts->put( $setting->meta, $setting->value );
		}

		$setts->put( 'tax_types', TaxType::all() );

		$request->flash();
		$search_term = '%' . $request->input( 'search-term' ) . '%';

		if ( $request->filled( 'filter-by' ) && $request->input( 'filter-by' ) != '*' ) {
			$tax_types = TaxType::where( $request->input( 'filter-by' ), 'LIKE', $search_term )
								->sortable()
								->paginate( 10 );
		} else {
			$tax_types = TaxType::where( 'name', 'LIKE', $search_term )
								->orWhere( 'description', 'LIKE', $search_term )
								->sortable()
								->paginate( 10 );
		}
		return view( 'admin.ecommerce.settings.tax.list', $setts, array( 'tax_classes' => $tax_types ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceTaxCreate() {
		return view( 'admin.ecommerce.settings.tax.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceTaxStore( Request $request ) {
		$slug = Str::slug( $request->input( 'name' ), '-' );

		if ( TaxType::where( 'slug', $slug )->count() > 0 ) {
			return back()->withInput();
		}

		$tax_type = TaxType::create(
			array(
				'name'        => $request->input( 'name' ),
				'slug'        => $slug,
				'description' => $request->input( 'description' ),
			)
		);

		return redirect( '/admin/ecommerce/settings/tax/' . $tax_type->id . '/edit' );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceTaxEdit( Request $request, $id ) {
		$tax_rates = TaxRate::where(
			function ( $query ) {
				$query->where( 'state', 'CA' )->orWhere( 'state', '*' );
			}
		)->get();

		$tax_type = TaxType::findOrFail( $id );
		$request->flashOnly( 'search-term', 'filter-by' );
		$search_term = '%' . $request->input( 'search-term' ) . '%';

		if ( $request->filled( 'filter-by' ) && $request->input( 'filter-by' ) != '*' ) {
			$tax_rates = TaxRate::where( 'tax_type_id', $id )
								->where( $request->input( 'filter-by' ), 'LIKE', $search_term )
								->sortable()
								->paginate( 10 );
		} else {
			$tax_rates = TaxRate::where( 'tax_type_id', $id )
								->where(
									function ( $query ) use ( $search_term ) {
										$query->where( 'name', 'LIKE', $search_term )
											->orWhere( 'country', 'LIKE', $search_term )
											->orWhere( 'state', 'LIKE', $search_term )
											->orWhere( 'city', 'LIKE', $search_term )
											->orWhere( 'postcode', 'LIKE', $search_term );
									}
								)
								->sortable()
								->paginate( 10 );
		}

		return view(
			'admin.ecommerce.settings.tax.edit',
			array(
				'tax_type'  => $tax_type,
				'tax_rates' => $tax_rates,
			)
		);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceTaxUpdate( Request $request, $id ) {
		$tax_type       = TaxType::findOrFail( $id );
		$tax_type->name = $request->input( 'name' );

		$slug = Str::slug( $request->input( 'name' ), '-' );

		if ( TaxType::where( 'slug', $slug )->count() > 0 ) {
			return back()->withInput();
		}

		$tax_type->slug        = $slug;
		$tax_type->description = $request->input( 'description' );
		$tax_type->save();

		return back()->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceTaxBulkDestroy( Request $request ) {
		TaxType::destroy( $request->data );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceTaxRateStore( Request $request ) {
		TaxRate::create(
			array(
				'name'        => $request->name,
				'country'     => $request->country ? $request->country : '',
				'state'       => $request->state ? $request->state : '',
				'city'        => $request->city ? $request->city : '',
				'postcode'    => $request->postcode ? $request->postcode : '',
				'rate'        => $request->rate,
				'is_shipping' => $request->is_shipping == 'true' ? true : false,
				'tax_type_id' => $request->tax_type_id,
			)
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceTaxRateUpdate( Request $request, $id ) {
		$tax_rate              = TaxRate::findOrFail( $id );
		$tax_rate->name        = $request->name;
		$tax_rate->country     = $request->country ? $request->country : '';
		$tax_rate->state       = $request->state ? $request->state : '';
		$tax_rate->city        = $request->city ? $request->city : '';
		$tax_rate->postcode    = $request->postcode ? $request->postcode : '';
		$tax_rate->rate        = $request->rate;
		$tax_rate->is_shipping = $request->is_shipping == 'true' ? true : false;
		$tax_rate->save();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceTaxRateBulkDestroy( Request $request ) {
		TaxRate::destroy( $request->data );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function paymentMethodEdit( $id ) {
		$payment_method         = PaymentMethod::findOrFail( $id );
		$slug                   = $payment_method->slug;
		$data                   = collect();
		$payment_method_details = PaymentMethodDetail::where( 'payment_method_id', $id )->get();
		foreach ( $payment_method_details as $detail ) {
			$data->put( $detail->meta, $detail->value );
		}

		return view( 'admin.ecommerce.settings.payment.' . $slug, $data );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ecommerceVendor() {
		$index_array = array();
		for ( $i = 51; $i < 62; $i++ ) {
			array_push( $index_array, $i );
		}

		$settings = Setting::find( $index_array );
		$setts    = collect();

		foreach ( $settings as $setting ) {
			$setts->put( $setting->meta, $setting->value );
		}

		return view( 'admin.multivendor.setting', $setts );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request ) {
		foreach ( $request->all() as $meta => $value ) {
			Setting::where( 'meta', $meta )->update( array( 'value' => $value ) );
		}

		return back()->withInput();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function paymentUpdate( Request $request, $id ) {
		foreach ( $request->all() as $meta => $value ) {
			if ( $meta == '_method' || $meta == '_token' ) {
				continue;
			} else {
				PaymentMethodDetail::updateOrCreate(
					array(
						'payment_method_id' => $id,
						'meta'              => $meta,
					),
					array(
						'payment_method_id' => $id,
						'meta'              => $meta,
						'value'             => $value,
					)
				);
			}
		}

		return back()->withInput();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function changePaymentMethodStatus( Request $request, $id ) {
		$payment_method          = PaymentMethod::findOrFail( $id );
		$payment_method->enabled = $request->enabled;
		$payment_method->save();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		//
	}

	/**
	 * Update theme settings
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function themeSettingsUpdate( Request $request ) {
		$theme_settings = $request->except( '_token' );

		foreach ( $theme_settings as $meta => $value ) {
			$theme_setting = Setting::where( 'meta', $meta )->first();
			if ( $theme_setting ) {
				$theme_setting->value = ( $value === true || $value == 'on' ) ? '1' : ( $value === false ? '0' : $value );

				$theme_setting->save();
			}
		}

		return back();
	}
}
