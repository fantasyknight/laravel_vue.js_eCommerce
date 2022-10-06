<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Display vue component
     *
     * @return \Illuminate\Http\Response
     */
    public function ordersReport()
    {
        return view('admin.ecommerce.reports.orders');
    }

    /**
     * Get report of orders
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getOrdersReport(Request $request) {
        $start_date = Carbon::create($request->input('start'));
        $end_date = Carbon::create($request->input('end'));
        $offset = $request->input('offset');
        $period = $end_date->diffInDays($start_date);
        $groupByMonth = false;

        if ($period > 120) {
            $groupByMonth = true;
        }

        $ordersByDate = Order::select(['id', 'order_type', 'parent', 'order_total_price', 'order_total_qty', 'order_tax', 'shipping_cost', 'shipping_tax', 'created_at', 'status'])
                                ->with('coupons')
                                ->whereIn('status', ['on-hold', 'processing', 'completed', 'refunded'])
                                ->where('order_type', '<>', 'suborder')
                                ->whereDate('created_at', '>=', $start_date)
                                ->whereDate('created_at', '<=', $end_date)
                                ->get()
                                ->groupBy(function ($item) use ($groupByMonth, $offset) {
                                    $local_time = $item->created_at->subMinutes($offset);
                                    if ($groupByMonth) {
                                        return $local_time->format('Y-m');
                                    } else {
                                        return $local_time->format('Y-m-d');
                                    }
                                });
        
        $refunded_orders = Order::select('id')->where('parent', 0)
                                    ->where('status', 'refunded')
                                    ->whereDate('created_at', '>=', $start_date)
                                    ->whereDate('created_at', '<=', $end_date)->get()->pluck('id');

        $for_report = collect([]);
        
        foreach ($ordersByDate as $key => $orders) {
            $for_report->put($key, array(
                'gross_sales' => $orders->whereNotIn('parent', $refunded_orders)->whereNotIn('id', $refunded_orders)->sum('order_total_price'),
                'net_sales' => $orders->whereNotIn('parent', $refunded_orders)->whereNotIn('id', $refunded_orders)->sum(function ($order) {
                    return $order->order_total_price - $order->order_tax - $order->shipping_cost;
                }),
                'order_count' => $orders->where('order_type', 'order')->count(),
                'items_count' => $orders->where('order_type', 'order')->sum('order_total_qty'),
                'refunded' => - $orders->where('order_type', 'refund')->sum('order_total_price'),
                'shipping' => $orders->whereNotIn('parent', $refunded_orders)->whereNotIn('id', $refunded_orders)->sum(function ($order) {
                    return $order->shipping_cost + $order->shipping_tax;
                }),
                'coupon' => $orders->whereNotIn('parent', $refunded_orders)->whereNotIn('id', $refunded_orders)->sum(function ($order) {
                    return $order->coupons->sum('coupon_amount');
                })
            ));
        }
        
        $orders = $ordersByDate->flatten();
        $for_report->put('gross_total', $orders->whereNotIn('parent', $refunded_orders)->whereNotIn('id', $refunded_orders)->sum('order_total_price'));
        $for_report->put('net_total', $orders->whereNotIn('parent', $refunded_orders)->whereNotIn('id', $refunded_orders)->sum(function ($order) {
            return $order->order_total_price - $order->order_tax - $order->shipping_cost;
        }));
        $for_report->put('refunded_total', - $orders->where('order_type', 'refund')->sum('order_total_price'));
        $for_report->put('refunded_orders', $orders->where('status', 'refunded')->count());
        $for_report->put('refunded_items', - $orders->where('order_type', 'refund')->sum('order_total_qty'));
        $for_report->put('orders_total', $orders->where('order_type', 'order')->count());
        $for_report->put('items_total', $orders->where('order_type', 'order')->sum('order_total_qty'));
        $for_report->put('shipping_total', $orders->whereNotIn('parent', $refunded_orders)->whereNotIn('id', $refunded_orders)->sum(function ($order) {
            return $order->shipping_cost + $order->shipping_tax;
        }));
        $for_report->put('coupon_total', $orders->whereNotIn('parent', $refunded_orders)->whereNotIn('id', $refunded_orders)->sum(function ($order) {
            return $order->coupons->sum('coupon_amount');
        }));

        $for_report->put('gross_avg', $for_report['gross_total'] / $period);
        $for_report->put('net_avg', $for_report['net_total'] / $period);
        $for_report->put('by_month', $groupByMonth);
        return response($for_report, Response::HTTP_OK);
    }

    /**
     * Display report of customers
     *
     * @return \Illuminate\Http\Response
     */
    public function customersReport(Request $request)
    {
        return view('admin.ecommerce.reports.customers');
    }
    
    /**
     * Get report of customers
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCustomersReport(Request $request)
    {
        $start_date = Carbon::create($request->input('start'));
        $end_date = Carbon::create($request->input('end'));
        $period = $end_date->diffInDays($start_date);
        $offset = $request->input('offset');
        $groupByMonth = false;

        if ($period > 120) {
            $groupByMonth = true;
        }

        $items = Order::with('customer')
                    ->whereIn('status', ['on-hold', 'processing', 'completed', 'refunded'])
                    ->where('parent', 0)
                    ->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date)
                    ->get()
                    ->groupBy(function ($item) use ($groupByMonth, $offset) {
                        $local_time = $item->created_at->subMinutes($offset);
                        if ($groupByMonth) {
                            return $local_time->format('Y-m');
                        } else {
                            return $local_time->format('Y-m-d');
                        }
                    });
        $for_report = collect([]);
        foreach ($items as $key => $item) {
            $for_report->put($key, array(
                'customer' => $item->where('customer.sign_up', '<>', null)->count(),
                'guest' => $item->where('customer.sign_up', null)->count()
            ));
        }

        $items = $items->flatten();
        $for_report->put('customer_sales', $items->where('customer.sign_up', '<>', null)->count());
        $for_report->put('guest_sales', $items->where('customer.sign_up', null)->count());
        $for_report->put('by_month', $groupByMonth);
        return response($for_report->toJson(), Response::HTTP_OK);
    }

    /**
     * Display report of customers
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function stockReport(Request $request)
    {
        $request->flash();
        $status = $request->input('status', 'low');
        $products = Product::where('manage_stock', 1);

        if ($status === 'most') {
            $products = $products->where('stock_quantity', '>', 2)
                                    ->orderByDesc('stock_quantity');
        } elseif ($status === 'low') {
            $products = $products->where('stock_quantity', '>', 0)
                                    ->where('stock_quantity', '<=', 2);
        } else {
            $products = $products->where('stock_quantity', '<=', '1');
        }
        
        $products = $products->paginate(24);
        return view('admin.ecommerce.reports.stock', ['products' => $products]);
    }
}
