<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Arr;

class AccountController extends Controller
{
    /**
     * Get customer's orders
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getCustomerOrders($customer) {

        $orders = Order::with('items')->select(['id', 'status', 'order_total_price', 'order_refunded_price', 'order_total_qty', 'created_at' ])
                            ->where('customer_email', $customer)
                            ->where('parent', 0)
                            ->latest()
                            ->get();
        return response([
            'orders' => $orders,
        ], 200);
    }

    /**
     * Get order's detail
     * 
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function getOrderDetail($id, Request $request) {
        $customer_email = $request->input('customer');
        $order = Order::with(['items', 'items.product:id,slug', 'items.product.files', 'coupons', 'notes' => function ($query) {
                                $query->where('notify_customer', true);
                            }])
                            ->where('customer_email', $customer_email)
                            ->findOrFail($id);

        $refunded_items = OrderItem::whereHas('order', function ($query) use ($id) {
            $query->where('parent', $id)->where('order_type', 'refund');
        })->get();

        $sub_orders = Order::with(['items', 'items.product:id', 'items.product.files', 'coupons', 'notes' => function ($query) {
                                $query->where('notify_customer', true);
                            }])
                            ->where('customer_email', $customer_email)
                            ->where('parent', $id)
                            ->where('order_type', 'suborder')
                            ->get();

        $downloadable_items = collect();
        if ($order->status === 'completed' || $order->status === 'processing' || $order->status === 'on-hold') {
            foreach ($order->items as $item) {
                if ($item->qty + $refunded_items->where('product_id', $item->product_id)->sum('qty') > 0 && $item->product && $item->product->files->count() ) {
                    foreach ($item->product->files as $file) {
                        $downloadable_items->push([
                            'id' => $item->parent_id,
                            'name' => $item->name,
                            'fileName' => $file->name,
                            'link' => $file->copy_link,
                            'slug' => $item->product->slug
                        ]);
                    }
                }
            }
        }

        return response([
            'order' => $order,
            'subOrders' => $sub_orders,
            'refundedItems' => $refunded_items,
            'downloads' => $downloadable_items
        ], 200);
    }

    /**
     * Get downloadable products
     * 
     * @param integer $id
     */
    public function getDownloadableProducts($customer) {
        $items_group_by_order = OrderItem::with(['product:id,slug', 'product.files', 'order' => function ($query) {
                                $query->selectRaw('id, if(parent = 0, id, parent) as order_id,created_at');
                            }])
                            ->whereHas('order', function ($query) use ($customer) {
                                $query->where('customer_email', $customer)->whereIn('status', ['completed', 'processing', 'on-hold'])->where('parent', 0);
                            })
                            ->has('product.files')
                            ->latest()
                            ->get()
                            ->groupBy('order.order_id');

        $downloadable_items = collect();
        foreach ($items_group_by_order as $order_items) {
            $per_products = $order_items->groupBy('product_id');
            foreach ($per_products as $item) {
                if ($item->sum('qty')) {
                    foreach ($item[0]->product->files as $file) {
                        $downloadable_items->push([
                            'id' => $item[0]->parent_id,
                            'name' => $item[0]->name,
                            'fileName' => $file->name,
                            'link' => $file->copy_link,
                            'slug' => $item[0]->product->slug
                        ]);
                    }
                }
            }
        }
        return response($downloadable_items, 200);
    }

    /**
     * Change Account details
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function changeAccountDetail(Request $request) {
        $data = $request->validate([
            'id' => 'required|integer|min:1',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:4',
            'new_password' => 'nullable|confirmed|string|min:4'
        ]);

        $user = User::findOrFail($data['id']);
                    
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        if ($data['email'] && $user->email !== $data['email']) {
            Order::where('customer_email', $user->email)->update(['customer_email' => $data['email']]);
            $user->email = $data['email'];
        }
        if ($data['password']) {
            if (! Hash::check($data['password'], $user->password)) {
                abort(422, Lang::get('custom.password_error'));
            }
            if ($data['new_password']) {
                $user->password = Hash::make($data['new_password']);
            }
        }
        $user->save();
        return response($user, 202);
    }

    /**
     * Change Account Billing Addresses
     * 
     * @param \Illumniate\Http\Request $request
     * @return \Illumniate\Http\Resonse
     */
    public function changeAccountBillingAddress(Request $request) {
        $data = $request->validate([
            'id' => 'required|integer|min:0',
            'billing_first_name' => 'required|string|max:255',
            'billing_last_name' => 'required|string|max:255',
            'billing_company' => 'nullable|string|max:255',
            'billing_address_1' => 'required|string|max:255',
            'billing_address_2' => 'nullable|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_country' => 'required|string|max:255',
            'billing_postcode' => 'required|string|size:5',
            'billing_phone' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255'
        ]);
        $user = User::findOrFail($data['id']);
        $user->fill(Arr::except($data, ['id']));
        $user->save();
        return response($user, 202);
    }

    /**
     * Change Account Shipping Addresses
     * 
     * @param \Illumniate\Http\Request
     * @return \Illumniate\Http\Resonse
     */
    public function changeAccountShippingAddress(Request $request) {
        $data = $request->validate([
            'id' => 'required|integer|min:0',
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_company' => 'nullable|string|max:255',
            'shipping_address_1' => 'required|string|max:255',
            'shipping_address_2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'shipping_country' => 'required|string|max:255',
            'shipping_postcode' => 'required|string|size:5'
        ]);
        $user = User::findOrFail($data['id']);
        $user->fill(Arr::except($data, ['id']));
        $user->save();
        return response($user, 202);
    }

    /**
     * Download file
     * 
     * @param \Illumniate\Http\Request $request
     * @retrun 
     */
    public function downloadFile(Request $request) {
        return Storage::download($request->input('link'));
    }
}
