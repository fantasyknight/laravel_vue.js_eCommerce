<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderNote;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = Auth::user();

        $total_orders = Order::whereIn('status', ['on-hold', 'processing', 'completed', 'refunded']);

        if ($user->role_id == 4) {
            $total_orders = $total_orders->where('author_id', $user->id);
        } else {
            $total_orders = $total_orders->where('order_type', '<>', 'suborder');
        }

        $user_info = array(
            "balance" => $total_orders->sum('order_total_price'),
            "products" => $total_orders->sum('order_total_qty')
        );

        $this_month = Carbon::now()->format("Y-m");
        $last_month = Carbon::now()->subMonth()->format("Y-m");
        $this_month_orders = Order::where("created_at", "LIKE", $this_month . "%");
        $last_month_orders = Order::where("created_at", "LIKE", $last_month . "%");

        if ($user->role_id == 4) {
            $this_month_orders = $this_month_orders->where('author_id', $user->id)->where('order_type', '<>', 'refund')->get();
            $last_month_orders = $last_month_orders->where('author_id', $user->id)->where('order_type', '<>', 'refund')->get();
            $this_order_counts = $this_month_orders->count();
        } else {
            $this_month_orders = $this_month_orders->where('parent', 0)->get();
            $last_month_orders = $last_month_orders->where('parent', 0)->get();
            $this_order_counts = $this_month_orders->count();
        }

        $this_order_avg = $this_month_orders->sum('order_total_price') / Carbon::now()->day;

        $order_info = array(
            "total" => $this_order_counts,
            "order_raised" => $this_order_counts > $last_month_orders->count(),
            "avg" => $this_order_avg,
            "avg_raised" => $this_order_avg > $last_month_orders->sum('order_total_price') / Carbon::now()->setDay(0)->day
        );

        $this_month_customers = User::where('role_id', 2)->where("sign_up", "LIKE", $this_month . "%")->count();
        $last_month_customers = User::where('role_id', 2)->where("sign_up", "LIKE", $last_month . "%")->count();
        $customer_count = array(
            "count" => $this_month_customers,
            "raised" => $this_month_customers > $last_month_customers
        );

        $order_items = OrderItem::selectRaw('sum(qty) as amount, product_id')
                                    ->groupBy('product_id');

        $top_five_products = Product::with('defaultImage')
                                    ->where('type', 'simple');
        if ($user->role_id == 4) {
            $top_five_products = $top_five_products->where('author_id', $user->id);
        }

        $top_five_products = $top_five_products->leftJoinSub($order_items, 'items', function ($join) {
                                            $join->on('id', '=', 'items.product_id');
                                    })
                                    ->orderByDesc('items.amount')
                                    ->limit(5)
                                    ->get();
        foreach ($top_five_products as $top_one) {
            if ((! isset($top_one->default_image)) && $top_one->parent != 0) {
                $top_one->defaultImage = Product::with(['media'])->findOrFail($top_one->parent)->media;
            }
        }
        
        if ($user->role_id == 4) {
            $recent_orders = Order::where('author_id', $user->id)
                                    ->where('order_type', '<>', 'refund')
                                    ->latest()
                                    ->limit(10)
                                    ->sortable()
                                    ->get();
        } else {
            $recent_orders = Order::where('parent', 0)
                                    ->latest()
                                    ->limit(10)
                                    ->sortable()
                                    ->get();
        }

        $customers_by_location = User::selectRaw('count(id) as customers, billing_country, billing_state')
                                        ->where('role_id', 2)
                                        ->where('sign_up', '!=', null)
                                        ->groupBy(['billing_country', 'billing_state'])
                                        ->orderByDesc('customers')
                                        ->limit(5)->get();
                                        
        $for_report = collect([]);

        $this_year_orders = Order::whereIn('status', ['on-hold', 'processing', 'completed', 'refunded'])
                                    ->where('created_at', 'LIKE', Carbon::now()->year . '%');

        if ($user->role_id == 4) {
            $this_year_orders = $this_year_orders->where('author_id', $user->id);
        } else {
            $this_year_orders = $this_year_orders->where('order_type', '<>', 'suborder');
        }

        $this_year_orders = $this_year_orders->get()->groupBy(function ($order) {
            return $order->created_at->format('M');
        });

        foreach ($this_year_orders as $key => $item) {
            $for_report->put($key, array(
                'gross' => round($item->sum('order_total_price'), 2),
                'net' => round($item->sum(function ($query) {
                    return $query->order_total_price - $query->order_tax - $query->shipping_cost;
                }), 2)
            ));
        }

        $recent_notes = OrderNote::with('order');

        if ($user->author_id == 4) {
            $recent_notes = $recent_notes->where('author_id', $user->id);
        }

        $recent_notes = $recent_notes->latest()
                                    ->limit(5)
                                    ->get();

        return view('admin.dashboard', [
            'user_info' => $user_info,
            'order_info' => $order_info,
            'customer_count' => $customer_count,
            'top_five_products' => $top_five_products,
            'recent_orders' => $recent_orders,
            'customers_by_location' => $customers_by_location,
            'total_customers' => User::where('role_id', 2)->where('sign_up', '<>', null)->count(),
            'this_year_items' => $for_report,
            'recent_notes' => $recent_notes
        ]);
    }
}
