@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Dashboard', 'paths' => []])

    <div class="row">
        <div class="col-lg-12 col-xl-4">
    
            <div class="row">
                <div class="col-12">
                    <div class="card card-modern">
                        <div class="card-body p-0">
                            <div class="widget-user-info">
                                <div class="widget-user-info-header">
                                    <h2 class="font-weight-bold text-color-dark text-5">Hello, {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h2>
                                    <p class="mb-0">{{ Auth::user()->role->name }}</p>
    
                                    <div class="widget-user-acrostic bg-primary">
                                        <span class="font-weight-bold">Me</span>
                                    </div>
                                </div>
                                <div class="widget-user-info-body">
                                    <div class="row">
                                        <div class="col-auto">
                                            <strong class="text-color-dark text-5">{!! Helper::portoFormattedPrice($user_info["balance"]) !!}</strong>
                                            <h3 class="text-4-1">User Balance</h3>
                                        </div>
                                        <div class="col-auto">
                                            <strong class="text-color-dark text-5">{{ $user_info["products"] }}</strong>
                                            <h3 class="text-4-1">Products</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <a href="{{ url('admin/users/' . Auth::user()->id . '/edit') }}" class="btn btn-light btn-xl border font-weight-semibold text-color-dark text-3 mt-4">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-xl-12 pb-2 pb-lg-0 mb-4 mb-lg-0">
                    <div class="card card-modern">
                        <div class="card-body py-4">
                            <div class="row align-items-center">
                                <div class="col-6 col-md-4">
                                    <h3 class="text-4-1 my-0">Total Orders</h3>
                                    <strong class="text-6 text-color-dark">{{ $order_info["total"] }}</strong>
                                </div>
                                <div class="col-6 col-md-4 border border-top-0 border-right-0 border-bottom-0 border-color-light-grey py-3">
                                    @if($order_info["order_raised"])
                                        <h3 class="text-4-1 text-color-success line-height-2 ws-nowrap my-0">Orders <strong>UP &uarr;</strong></h3>
                                    @else
                                        <h3 class="text-4-1 text-color-danger line-height-2 ws-nowrap my-0 ">Orders <strong>Down &darr;</strong></h3>
                                    @endif
                                    <span>This month</span>
                                </div>
                                <div class="col-md-4 text-left text-md-right pr-md-4 mt-4 mt-md-0">
                                    <i class="bx bx-cart-alt icon icon-inline icon-xl bg-primary rounded-circle text-color-light"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-12 pt-xl-2 mt-xl-4">
                    <div class="card card-modern">
                        <div class="card-body py-4">
                            <div class="row align-items-center">
                                <div class="col-6 col-md-4">
                                    <h3 class="text-4-1 my-0">Average Price</h3>
                                    <strong class="text-6 text-color-dark">{!! Helper::portoFormattedPrice($order_info["avg"]) !!}</strong>
                                </div>
                                <div class="col-6 col-md-4 border border-top-0 border-right-0 border-bottom-0 border-color-light-grey py-3">
                                    @if($order_info["avg_raised"])
                                        <h3 class="text-4-1 text-color-success line-height-2 ws-nowrap my-0">Price <strong>UP &uarr;</strong></h3>
                                    @else
                                        <h3 class="text-4-1 text-color-danger line-height-2 ws-nowrap my-0">Price <strong>DOWN &darr;</strong></h3>
                                    @endif
                                    <span>This month</span>
                                </div>
                                <div class="col-md-4 text-left text-md-right pr-md-4 mt-4 mt-md-0">
                                    <i class="bx bx-purchase-tag-alt icon icon-inline icon-xl bg-primary rounded-circle text-color-light pr-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-8 pt-2 pt-xl-0 mt-4 mt-xl-0">
            
            <div class="row h-100">
                <div class="col">
                    <report-annual-component :items="{{ $this_year_items }}"></report-anual-component>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-xl-4">
            <div class="d-flex flex-column h-100">
                <div class="card card-modern">
                    <div class="card-body py-4">
                        <div class="row align-items-center">
                            <div class="col-6 col-md-4">
                                <h3 class="text-4-1 my-0">Total Customers</h3>
                                <strong class="text-6 text-color-dark">{{ $customer_count['count'] }}</strong>
                            </div>
                            <div class="col-6 col-md-4 border border-top-0 border-right-0 border-bottom-0 border-color-light-grey py-3">
                                @if($customer_count['raised'])
                                    <h3 class="text-4-1 text-color-success line-height-2 ws-nowrap my-0">Customers <strong>UP &uarr;</strong></h3>
                                @else
                                    <h3 class="text-4-1 text-color-danger line-height-2 ws-nowrap my-0">Customers <strong>DOWN &darr;</strong></h3>
                                @endif
                                <span>This month</span>
                            </div>
                            <div class="col-md-4 text-left text-md-right pr-md-4 mt-4 mt-md-0">
                                <i class="bx bx-user icon icon-inline icon-xl bg-primary rounded-circle text-color-light"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-modern flex-grow-1">
                    <div class="card-header">
                        <div class="card-actions">
                            <a href="javascript:;" class="card-action card-action-toggle" data-card-toggle></a>
                        </div>
                        <h2 class="card-title">Recent Activity</h2>
                    </div>
                    <div class="card-body" style="min-height: 330px">
                        <ul class="list list-unstyled mb-0">
                            @forelse($recent_notes as $note)
                                <li class="activity-item">
                                    <span class="activity-time">{{ $note->created_at->diffForHumans() }}</span> <i class="fas fa-chevron-right text-color-primary"></i> 
                                    <span class="activity-description">
                                        <a href="{{ url('admin/ecommerce/orders/' . $note->order->id . '/edit') }}" class="text-color-dark"><strong>Order #{{ $note->order->id }}</strong></a> {{ $note->content }}
                                    </span>
                                </li>
                            @empty
                                <li class="activity-item">
                                    <p>There are no recent activities.</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-4 pt-2 pt-lg-0 mt-4 mt-lg-0">
            <div class="card card-modern h-100">
                <div class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Top 5 Selling Products</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-ecommerce-simple table-no-collapse mb-1" style="min-width: 454px">
                            <thead>
                                <tr>
                                    <th width="72"></th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($top_five_products as $product)
                                    <tr>
                                        <td width="72">
                                            <a href="{{ url('admin/products/' . ($product->parent == 0 ? $product->id : $product->parent) . '/edit') }}">
                                                @if($product->defaultImage->count())
                                                    <img src="{{ asset('storage') }}/{{ Str::replaceLast('.', '-150x150.', $product->defaultImage[0]->copy_link) }}" alt="Category" width="60" height="60">
                                                @else
                                                    <img src="{{ asset('server/images/porto-placeholder-66x66.png') }}" alt="Category" width="60" height="60">
                                                @endif
                                            </a>
                                        </td>
                                        <td><a class="truncate" href="{{ url('admin/products/' . ($product->parent == 0 ? $product->id : $product->parent) . '/edit') }}" class="font-weight-semibold">{{ $product->name }}</a></td>
                                        <td width="90">
                                            @if($product->min_max_price[0] == $product->min_max_price[1])
                                                {!! Helper::portoFormattedPrice($product->min_max_price[0]) !!}
                                            @else
                                                @if($product->type == 'simple')
                                                    <div class="product-price"> 
                                                        <div class="regular-price on-sale">{!! Helper::portoFormattedPrice($product->min_max_price[1]) !!}</div>
                                                        <div class="sale-price">{!! Helper::portoFormattedPrice($product->min_max_price[0]) !!}</div>
                                                    </div>
                                                @else
                                                    {!! Helper::portoFormattedPrice($product->min_max_price[0]) !!} - {!! Helper::portoFormattedPrice($product->min_max_price[1]) !!}
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-4 pt-2 pt-xl-0 mt-4 mt-xl-0">
            <div class="card card-modern h-100">
                <div class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Customers By Location</h2>
                </div>
                <div class="card-body">
                    @if($customers_by_location->isNotEmpty())
                        @foreach($customers_by_location as $location)
                            <label>
                                @if($location->billing_country)
                                    {{ Config::get('constant.countries')[$location->billing_country] ?: $location->billing_country }}
                                    {{ $location->billing_state ? 
                                        array_key_exists($location->billing_country, Config::get('constant.states')) && array_key_exists($location->billing_state, Config::get('constant.states')[$location->billing_country]) ? 
                                            Config::get('constant.states')[$location->billing_country][$location->billing_state] : $location->billing_state 
                                    : ''}} 
                                @else
                                    Unknown
                                @endif
                                ({{ $location->customers }})
                            </label>
                            <div class="progress progress-xs mb-4 light rounded-0">
                                <div class="progress-bar progress-bar-primary rounded-0" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: {{ 100 * $location->customers / $total_customers }}%;">
                                    <span class="sr-only">{{ 100 * $location->customers / $total_customers }}%</span>
                                </div>
                            </div>
                        @endforeach
                        <a href="{{ url('admin/ecommerce/customers') }}" class="btn btn-light btn-xl border font-weight-semibold text-color-dark text-3 mb-4">View More</a>
                    @else
                        <p>There are no customers yet.</p>
                    @endif
    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            
            <div class="card card-modern">
                <div class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Recent Orders</h2>
                </div>
                <div class="card-body">
                    <div class="datatables-header-footer-wrapper">
                        <div class="table-responsive">
                            <table class="table table-ecommerce-simple table-posts table-striped table-responsive-lg mb-0" id="datatable-ecommerce-list">
                                <thead>
                                    <tr>
                                        <th width="100">@sortablelink('id', 'Order')</th>
                                        <th width="30%">Customer & Guests</th>
                                        <th>@sortablelink('created_at', 'Date')</th>
                                        <th>Status</th>
                                        <th class="text-lg-right">@sortablelink('order_total_price', 'Total')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_orders as $order)
                                        <tr>
                                            <td>
                                                <a href="{{ url('/admin/ecommerce/orders/' . $order->id .'/edit') }}"><strong>{{ $order->id }}</strong></a>
                                                <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                            </td>
                                            <td data-column="Customer"><a href="{{ str_replace('&', '&amp;', action('Admin\OrderController@index', Arr::add(\Request::except('page'), 'customer', $order->customer_email))) }}">{{ $order->customer_name }}</td>
                                            <td data-column="Date">{{ $order->created_at->format("M d, Y") }}</td>
                                            <td data-column="Status">
                                                <span class="ecommerce-status {{ $order->status }}">{{ str_replace('-', ' ', Str::title($order->status)) }}</span>
                                            </td>
                                            <td data-column="Total" class="text-lg-right">
                                                @if($order->order_refunded_price < 0)
                                                    <span class="order-old-price">{!! Helper::portoFormattedPrice($order->order_total_price) !!}</span>
                                                    <span class="order-new-price">{!! Helper::portoFormattedPrice($order->order_total_price + $order->order_refunded_price) !!}</span>
                                                @else
                                                    {!! Helper::portoFormattedPrice($order->order_total_price) !!}
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No orders available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
    </div>

    @include('admin.common.modals.delete-confirm')
@endsection
