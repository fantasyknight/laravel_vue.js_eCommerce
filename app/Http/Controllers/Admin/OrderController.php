<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderCoupon;
use App\Models\OrderItem;
use App\Models\OrderNote;
use App\Models\Product;
use App\Models\TaxRate;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Helper;
use Arr;
use Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $request->flashOnly(['date', 'search-term']);

        $dates = Order::selectRaw("DATE_FORMAT(created_at, '%M %Y') as month")->groupBy('month')->get('month');
        $period = $request->input('date', '*');
        $customer = $request->input('customer');
        $search_term = '%' . $request->input('search-term') . '%';

        $orders = Order::where('id', 'LIKE', $search_term);
        if ($user->role_id == 4) {
            $orders = $orders->where('author_id', $user->id);
        } else {
            $orders = $orders->where('parent', 0);
        }

        if ($period !== '*') {
            $orders = $orders->whereRaw("DATE_FORMAT(created_at, '%M %Y') = '" . $period . "'");
        }

        if ($customer) {
            $orders = $orders->where('customer_email', $customer);
        }

        $orders = $orders->sortable('id')->paginate(24);
        return view('admin.ecommerce.orders.list', ['orders' => $orders, 'dates' => $dates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ecommerce.orders.create', [
            'customers' => User::where('role_id', 2)->get(),
            'products' => Product::where('type', 'simple')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $items = $request->items;
        $payment_method = $request->input('payment_method');
        $applied_coupons_code = $request->coupons ?: array();
        $emails = $request->emails;
        $cart_rate = $request->cart_rate;
        $notes = $request->input('notes', []);

        $products = Product::with(['categories', 'taxType.taxRates'])
                                    ->whereIn('id', Arr::pluck($items, 'id'))
                                    ->get();
                                    
        // Apply coupons
        $coupons = Coupon::whereIn('code', $applied_coupons_code)->get();
        $coupons_to_apply = collect([]);

        foreach ($applied_coupons_code as $code) {
            $coupon = $coupons->where('code', $code)->first();
            $coupons_to_apply->push($coupon);
        }

        $discounted_result = $this->applyCoupons($items, $products, $cart_rate, $coupons_to_apply, null, $emails);
        $items = $discounted_result['items'];
        $discounted_coupons = $discounted_result['coupons'];
        $errors = $discounted_result['errors'];

        $cart_coupons_tax = 0;
        $cart_coupons_amount = 0;

        foreach ($discounted_coupons as $coupon) {
            $cart_coupons_tax += $coupon['tax'];
            $cart_coupons_amount += $coupon['amount'];
        }

        if (count($errors)) {
            abort(500, json_encode($errors));
        }

        $order_tax = array_sum(Arr::pluck($items, 'tax_amount')) + $request->input('shipping_tax') - $cart_coupons_tax;
        if (config('setting.tax_round_at_subtotal')) {
            $order_tax = round($order_tax, config('setting.number_of_decimal'));
        }

        $order_total_price = array_sum(Arr::pluck($items, 'sum')) + $request->input('shipping_cost') + $order_tax - $cart_coupons_amount;
        
        $order = new Order();
        $order->fill($request->all());
        $order->order_total_qty = array_sum(Arr::pluck($items, 'qty'));
        $order->order_tax = $order_tax;
        $order->order_total_price = $order_total_price;
        $order->shipping_cost = $request->input('shipping_cost');
        $order->shipping_tax = $request->input('shipping_tax');

        $group_items = collect($items)->groupBy('author_id');

        if ($group_items->count() == 1) {
            $order->author_id = $group_items->keys()[0];
            $order->vendor_net = Helper::calcVendorNetsale($payment_method, $order->order_total_price);
        }
        $order->save();
        
        foreach ($items as $item) {
            $product = $products->where('id', $item['id'])->first();
            $shipping_amount = 0;
            if ($product->manage_stock) {
                $product_record = Product::findOrFail($product->id);
                $product_record->stock_quantity -= $item['qty'];
                $product_record->save();
            }
            if (Arr::has($item, 'shipping_amount')) {
                $shipping_amount += $item['shipping_amount'] + $item['shipping_tax_amount'];
            }
            $tax_amount = $item['tax_amount'] * ($item['sum'] - $item['coupon_amount']) / $item['sum'];
            $order_item = new OrderItem([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'parent_id' => $product->parent,
                'name' => $product->name,
                'qty' => $item['qty'],
                'net_revenue' => $item['sum'] - $item['coupon_amount'],
                'gross_revenue' => $item['sum'] - $item['coupon_amount'] + $tax_amount + $shipping_amount,
                'coupon_amount' => $item['coupon_amount'],
                'tax_amount' => $tax_amount,
                'shipping_amount' => Arr::has($item, 'shipping_amount') ? $item['shipping_amount'] : 0,
                'shipping_tax_amount' => Arr::has($item, 'shipping_tax_amount') ? $item['shipping_tax_amount'] : 0
            ]);
            $order_item->save();
        }
        
        if ($group_items->count() > 1) {
            $group_items->each(function ($group, $group_key) use($order, $payment_method, $request) {
                $temp_total_price = $group->sum(function ($temp) {
                    return $temp['sum'] - $temp['coupon_amount'] + $temp['tax_amount'] * ($temp['sum'] - $temp['coupon_amount']) / $temp['sum'];
                });

                $sub_order = new Order();
                $sub_order->fill($request->all());
                $sub_order->shipping_cost = 0;
                $sub_order->shipping_tax = 0;
                $sub_order->order_tax = $group->sum(function ($temp) {
                    return $temp['tax_amount'] * ($temp['sum'] - $temp['coupon_amount']) / $temp['sum'];
                });
                $sub_order->order_total_price = $temp_total_price;
                $sub_order->order_total_qty = $group->sum('qty');
                $sub_order->author_id = $group_key;
                $sub_order->order_type = 'suborder';
                $sub_order->parent = $order->id;
                $sub_order->vendor_net = Helper::calcVendorNetsale($payment_method, $temp_total_price);
                $sub_order->save();

                $group->each(function ($temp) use ($sub_order) {
                    $tax_amount = $temp['tax_amount'] * ($temp['sum'] - $temp['coupon_amount']) / $temp['sum'];
                    $shipping_amount = Arr::has($temp, 'shipping_amount') ? $temp['shipping_amount'] : 0;
                    $shipping_tax_amount = Arr::has($temp, 'shipping_tax_amount') ? $temp['shipping_tax_amount'] : 0;

                    OrderItem::create([
                        'order_id' => $sub_order->id,
                        'product_id' => $temp['id'],
                        'parent_id' => $temp['parent_id'],
                        'name' => $temp['name'],
                        'qty' => $temp['qty'],
                        'net_revenue' => $temp['sum'] - $temp['coupon_amount'],
                        'gross_revenue' => $temp['sum'] - $temp['coupon_amount'] + $tax_amount + $shipping_amount,
                        'coupon_amount' => $temp['coupon_amount'],
                        'tax_amount' => $tax_amount,
                        'shipping_amount' => $shipping_amount,
                        'shipping_tax_amount' => $shipping_tax_amount
                    ]);
                });
            });
        }

        foreach ($discounted_coupons as $coupon) {
            $coupon_id = $coupons->where('code', $coupon['code'])->first()->id;
            $order_coupon = new OrderCoupon([
                'order_id' => $order->id,
                'coupon_id' => $coupon_id,
                'coupon_code' => $coupon['code'],
                'coupon_amount' => $coupon['amount'],
                'coupon_tax_amount' => $coupon['tax']
            ]);
            $order_coupon->save();
        }

        foreach ($notes as $note) {
            $new_note = new OrderNote([
                'order_id' => $order->id,
                'author_id' => $request->user()->id,
                'content' => $note['content'],
                'notify_customer' => $note['notify_customer']
            ]);
            $new_note->save();
        }
        
        return response($order->id, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $order = Order::with(['items', 'notes', 'coupons', 'notes.author'])->where('order_type', '<>', 'refund')->findOrFail($id);

        if($user->role_id == 4) {
            if ($order->author_id != $user->id) abort(403);
        }

        $sub_orders = Order::where('parent', $id)
                            ->where('order_type', 'suborder')
                            ->with('author:id,first_name,last_name,role_id')
                            ->get();
        if ($order->order_type == 'suborder') {
            $refunded = Order::where('parent', $order->parent)
                                ->where('order_type', 'refund')
                                ->with(['items' => function ($query) use ($order) {
                                    $query->with('product')
                                            ->whereHas('product', function ($query2) use ($order) { 
                                                $query2->where('author_id', $order->author_id ); 
                                            });
                                }, 'author'])
                                ->get();

        } else {
            $refunded = Order::where('parent', $id)
                                ->where('order_type', 'refund')
                                ->with(['items', 'author'])
                                ->get();
        }
        return view('admin.ecommerce.orders.edit', ['order' => $order, 'refunded' => $refunded, 'sub_orders' => $sub_orders]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $author_id = $request->user()->id;
        $response_data = [];
        if ($order->status == $request->input('status')) {
            return response(null, Response::HTTP_OK);
        }

        $refunded_ids = Order::where('order_type', 'refund')
                                ->where('parent', $id)
                                ->get()
                                ->pluck('id');
        $refunded_items = OrderItem::whereIn('order_id', $refunded_ids)
                                    ->with('product:id,author_id')
                                    ->get();

        $prev_status = $order->status;
        if ($request->user()->role_id != 4 || config('setting.vendor_allow_order_status') == '1') {
            $sub_orders = Order::where('parent', $id)
                                ->where('order_type', 'suborder')
                                ->get();
            
            if ($request->input('status') == 'completed') {
                foreach ($sub_orders as $sub_order) {
                    if ($sub_order->status != 'completed') {
                        $vendor = Vendor::where('user_id', $sub_order->author_id)->first();

                        if ($vendor) {
                            $refund_subtotal = 0;
                            foreach ($refunded_items as $refunded_item) {
                                if ($refunded_item->product->author_id == $sub_order->author_id) {
                                    $refund_subtotal = $refund_subtotal + $refunded_item->gross_revenue;
                                }
                            }

                            $vendor->balance = $vendor->balance + Helper::calcVendorNetsale(Str::slug($sub_order->payment_method, '_'), $sub_order->order_total_price + $refund_subtotal);
                            $vendor->save();
                        }
                    }

                    $sub_order->status = 'completed';
                    $sub_order->save();
                }

                $vendor = Vendor::where('user_id', $order->author_id)->first();
                if ($vendor) {
                    $refund_subtotal = Order::where('parent', $order->id)
                                        ->where('order_type', 'refund')
                                        ->sum('order_total_price');
                    
                    $vendor->balance = $vendor->balance + Helper::calcVendorNetsale(Str::slug($order->payment_method, '_'), $order->order_total_price + $refund_subtotal);
                    $vendor->save();
                }
            } else {
                foreach ($sub_orders as $sub_order) {
                    if ($sub_order->status == 'completed') {
                        $vendor = Vendor::where('user_id', $sub_order->author_id)->first();
                        if ($vendor) {
                            $refund_subtotal = 0;
                            foreach ($refunded_items as $refunded_item) {
                                if ($refunded_item->product->author_id == $sub_order->author_id) {
                                    $refund_subtotal = $refund_subtotal + $refunded_item->gross_revenue;
                                }
                            }

                            $vendor->balance = $vendor->balance - Helper::calcVendorNetsale(Str::slug($sub_order->payment_method, '_'), $sub_order->order_total_price + $refund_subtotal);

                            $vendor->save();
                        }
                    }

                    $sub_order->status = $request->input('status');
                    $sub_order->save();
                }

                if ($prev_status == 'completed') {
                    $vendor = Vendor::where('user_id', $order->author_id)->first();

                    if ($vendor) {
                        $refund_subtotal = Order::where('parent', $order->id)
                                        ->where('order_type', 'refund')
                                        ->sum('order_total_price');
                        $vendor->balance = $vendor->balance - Helper::calcVendorNetsale(Str::slug($order->payment_method, '_'), $order->order_total_price + $refund_subtotal);
                        $vendor->save();
                    }
                }
                
                if ($request->input('status') == 'refunded') {
                    $refunded_orders = Order::where('parent', $order->id)->where('order_type', 'refund')->get();
                    $refund_price = $order->order_total_price + $order->order_refunded_price;
                    $refund_order = new Order();
                    $refund_order->fill($order->toArray());
                    $refund_order->parent = $order->id;
                    $refund_order->author_id = $request->user()->id;
                    $refund_order->order_total_price = - $refund_price;
                    $refund_order->order_tax = 0;
                    $refund_order->order_total_qty = 0;
                    $refund_order->shipping_cost = 0;
                    $refund_order->shipping_tax = 0;
            
                    $refund_order->status = "completed";
                    $refund_order->order_type = "refund";
                    $refund_order->save();

                    $response_data = Arr::add($response_data, 'refund', Order::with(['items', 'author'])->find($refund_order->id));

                    $order->order_refunded_price += -$refund_price;
                }
            }
            
            $order->status = $request->input('status');
        }
        
        $order->save();

        $note_content = 'Status changed from ' . config('constant.payment_status')[$prev_status] . ' to ' . config('constant.payment_status')[$order->status] . '.';

        $note = new OrderNote([
            'order_id' => $id,
            'author_id' => $author_id,
            'content' => $note_content
        ]);
        $note->save();

        $response_data = Arr::add($response_data, 'note', OrderNote::with('author')->find($note->id));
        
        return response($response_data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::destroy($id);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        Order::destroy($request->input('data'));
    }

    /**
     * Refund items for specific order.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addRefund(Request $request)
    {
        $order = Order::with('items:order_id,qty,product_id,net_revenue,tax_amount')->findOrFail($request->input('order_id'));
        $shipping_cost = $request->input('shipping_cost');
        $shipping_tax = $request->input('shipping_tax');
        $items = $request->input('items');
        if (! $this->checkRefundable($order, $items, $shipping_cost, $shipping_tax)) {
            abort(500, "Invalid refund amount");
        }
        $tax_amount = array_sum(Arr::pluck($items, 'tax_amount')) + $shipping_tax;
        $total_price = array_sum(Arr::pluck($items, 'net_revenue')) + $tax_amount + $shipping_cost;
        $refunded_qty = array_sum(Arr::pluck($items, 'qty'));

        $refund = new Order();
        $refund->fill($order->toArray());
        $refund->parent = $order->id;
        $refund->author_id = $request->user()->id;
        $refund->order_total_price = $total_price;
        $refund->order_tax = $tax_amount;
        $refund->order_total_qty = $refunded_qty;
        $refund->shipping_cost = $shipping_cost;
        $refund->shipping_tax = $shipping_tax;
 
        $refund->status = "completed";
        $refund->order_type = "refund";
        $refund->save();

        foreach ($items as $item) {
            $order_item = new OrderItem($item);
            $refund->items()->save($order_item);
        }
        
        $order->order_refunded_price += $refund->order_total_price;

        $response_data = [];
        if ($order->order_refunded_price + $order->order_total_price == 0) {
            $order->status = 'refunded';
            $response_data = Arr::add($response_data, 'status', 'refunded');
        }
        $order->save();
        $response_data = Arr::add($response_data, 'refund', Order::with(['items', 'author'])->find($refund->id));

        return response($response_data, Response::HTTP_CREATED);
    }

    /**
     * Delete refund
     *
     * @param int $refund_id
     * @return \Illuminate\Http\Response
     */
    public function deleteRefund($refund_id)
    {
        $refund = Order::findOrFail($refund_id);
        $order = Order::findOrFail($refund->parent);
        $order->order_refunded_price -= $refund->order_total_price;
        $order->save();
        $refund->delete();
        return response(null, Response::HTTP_OK);
    }

    /**
     * Check if items could be refunded.
     */
    private function checkRefundable($order, $items, $shipping_cost, $shipping_tax) {
        $order_id = $order->id;
        $refunded_order_items = OrderItem::select(['id', 'qty', 'product_id', 'net_revenue', 'tax_amount'])->whereHas('order', function ($query) use ($order_id) {
            $query->where('parent', $order_id)->where('order_type', 'refund');
        })->get();
        $refunded_orders = Order::select('shipping_cost', 'shipping_tax')->where('parent', $order_id)->where('order_type', 'refund');
        if ( -($shipping_cost + $refunded_orders->sum('shipping_cost')) > $order->shipping_cost 
            || -($shipping_tax + $refunded_orders->sum('shipping_tax')) > $order->shipping_tax ) {
            return false;
        }
        foreach ($items as $item) {
            $refunded = $refunded_order_items->where('product_id', $item['product_id']);
            $order_item = $order->items->firstWhere('product_id', $item['product_id']);
            $expect_qty = - ($refunded->sum('qty') + $item['qty']);
            $expect_net_revenue = - ($refunded->sum('net_revenue') + $item['net_revenue']);
            $expect_tax_amount = - ($refunded->sum('tax_amount') + $item['tax_amount']);
            if ( $expect_qty > $order_item->qty || $expect_net_revenue > $order_item->net_revenue || $expect_tax_amount > $order_item->tax_amount) {
                return false;
            }
        }
        return true;
    }

    /**
     * Add note to specific order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addNote(Request $request) 
    {
        $note = new OrderNote([
            'order_id' => $request->input('order_id'),
            'author_id' => $request->user()->id,
            'content' => $request->content,
            'notify_customer' => $request->notify_customer
        ]);
        $note->save();
        return response(
            OrderNote::with('author')->find($note->id)->toJson(),
            Response::HTTP_CREATED
        );
    }

    /**
     * Delete note
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteNote($order_id)
    {
        OrderNote::destroy($order_id);

        return response(null, Response::HTTP_CREATED);
    }

    /**
     * Retrieve on-hold orders for notification
     * 
     * @return \Illuminate\Http\Response
     */
    public function getHoldingOrders() {
        $on_hold_orders = Order::where('status', 'on-hold');
        $user = Auth::user();

        if ($user->role_id == 4) {
            $on_hold_orders = $on_hold_orders->where('author_id', $user->id);
        }

        $hold_orders_count = $on_hold_orders->count();
        $on_hold_orders = $on_hold_orders->with('customer:id')
                                            ->take(3)
                                            ->get(['id', 'created_at', 'customer_name']);
        return response([
            'count' => $hold_orders_count,
            'orders' => $on_hold_orders->toJson()
        ], Response::HTTP_OK);
    }

    /**
     * Retrieve after appling coupons and tax for items
     * 
     * @return Array
     */
    public function calculateCoupons(Request $request) {
        $items = $request->items;
        $applied_coupons_code = $request->coupons ?: array();
        $new_coupon = $request->new_coupon;
        $emails = $request->emails ?: [];
        $cart_rate = $request->cart_rate;

        $products = Product::with(['categories', 'taxType.taxRates'])
                                    ->whereIn('id', Arr::pluck($items, 'id'))
                                    ->get();
                                    
        // Apply coupons
        $coupons = Coupon::whereIn('code', $applied_coupons_code)->get();
        $coupons_to_apply = collect([]);


        foreach ($applied_coupons_code as $code) {
            $coupon = $coupons->where('code', $code)->first();
            $coupons_to_apply->push($coupon);
        }

        if ($new_coupon) {
            $new_coupon = Coupon::where('code', $new_coupon)->first();

            if ($new_coupon) {
                if ($new_coupon->individual_use) {
                    $coupons_to_apply = array($new_coupon);
                } else {
                    $individual_coupon = $coupons_to_apply->firstWhere('individual_use', true);
                    if ($individual_coupon) {
                        abort(500, 'Sorry coupon "' . $individual_coupon->code . '" has already been applied and cannot be used in conjunction with other coupons.');
                    } else {
                        $coupons_to_apply->push($new_coupon);
                    }
                }
            } else {
                abort(500, 'Sorry, your coupon ' . $new_coupon . ' is incorrect.');
            }
        }

        $discounted_result = $this->applyCoupons($items, $products, $cart_rate, $coupons_to_apply, $new_coupon, $emails);

        return response([
            'items' => ($discounted_result['items']),
            'coupons' => $discounted_result['coupons'],
            'errors' => json_encode($discounted_result['errors'])
        ], 200);
    }

    

    /**
     * Apply coupons and return discounted cart items
     * 
     * @param array $items
     * @param array<App\Models\Coupon> $coupons
     * @param string $email
     * @return array
     */
    private function applyCoupons($items, $products, $cart_rate, $coupons, $new_coupon, $email ) {
        $coupon_discount = collect([]);
        $total_spend = 0;
        $errors = [];

        foreach ($items as &$item) {
            $product = $products->where('id', $item['id'])->first();
            $item['sum'] = $product->min_max_price[0] * $item['qty'];
            $total_spend += $item['sum'];
            $item['coupon_amount'] = 0;
            $item['tax_amount'] = $product->min_max_price[0] * $item['qty'] * $item['tax_rate'] / 100;
            $item['author_id'] = $product->author_id;
            $item['name'] = $product->name;
            
            if ($product->parent == 0) {
                $item['parent_id'] = $product->id;
            } else {
                $item['parent_id'] = $product->parent;
            }
        }
        
        foreach ($coupons as $coupon) {
            $validate = Helper::validateCoupon($coupon, $total_spend, $email);
            if ($validate) {
                if ($coupon->code !== $this->new_coupon) {
                    $validate .= ' - has been removed from your order';
                }
                array_push($this->error_msg, $validate . '.');
                continue;
            }
            $applied = 0;
            $discount_amount = 0;
            $tax_amount = 0;

            foreach ($items as &$item) {
                $product = $products->where('id', $item['id'])->first();
                $discount = Helper::calcCouponAmount($product, $coupon);

                if ($discount) {
                    if ($coupon->discount_type === 'cart') {
                        $applied ++;
                        break;
                    } else {
                        $qty = $item['qty'];
                        if ($coupon->limit_x_items) {
                            $qty = min($coupon->limit_x_items - $applied, $item['qty']);
                        }

                        $applied += $qty;
                        $item['coupon_amount'] += round($discount * $qty, 2);
                        $discount_amount += $discount * $qty;

                        if (Arr::has($item, 'tax_amount')) {
                            $tax_amount += $item['tax_amount'] * $discount * $qty / ( $product->min_max_price[0] * $item['qty'] );
                        }
                        if ($coupon->limit_x_items && $coupon->limit_x_items === $applied) 
                            break;
                    }
                }
            }

            if ($applied && $coupon->discount_type === 'cart') {
                $total_qty = array_sum(Arr::pluck($items, 'qty'));
                foreach ($items as &$item) {
                    $product = $products->where('id', $item['id'])->first();
                    $discount = $coupon->amount * $item['qty'] / $total_qty;
                    $discount_amount += $discount;
                    $item['coupon_amount'] += round($discount, 2);

                    if (Arr::has($item, 'tax_amount')) {
                        $tax_amount += $item['tax_amount'] * $discount / ( $product->min_max_price[0] * $item['qty'] );
                    }
                }
            }

            if ($applied && $discount_amount > 0 || ($discount_amount + $coupon->amount === 0)) {
                if (config('setting.tax_round_at_subtotal') === '0') {
                    $tax_amount = round($tax_amount, config('setting.number_of_decimal'));
                }

                $coupon_discount->push([
                    'code' => $coupon->code,
                    'amount' => round($discount_amount, 2),
                    'tax' => $tax_amount,
                ]);
            } else {
                $msg = 'Sorry , coupon "' . $coupon->code . '" is not applicable to selected products';
                if ($coupon->code !== $new_coupon) {
                    $msg .= ' - has been removed from your order';
                }
                array_push($errors, $msg . '.');
            }
        }

        return array(
            "coupons" => $coupon_discount,
            "items" => $items,
            "errors" => $errors
        );
    }
}
