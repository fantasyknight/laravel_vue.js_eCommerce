@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Orders', 'paths' => ['home' => '/dashboard', 'ecommerce' => '/ecommerce']])

    @php
        $currency = Config::get('constant.currency_symbols')[Config::get('setting.currency')]
    @endphp

    <div class="row">
        <div class="col">
            <form id="orders-list-form" method="get">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-lg-center mb-3">
                                    <div class="col-xl-auto mb-2 mt-1 mb-xl-0">
                                        @if (Auth::user()->role_id != 4)
                                            <a href="{{ url('/admin/ecommerce/orders/create') }}" class="btn btn-primary btn-md font-weight-semibold">+ New Order</a>
                                        @endif
                                    </div>
                                    <div class="col-lg-auto ml-lg-auto pl-lg-1">
                                        <div class="d-flex align-items-center">
                                            <label class="ws-nowrap mr-3 mb-0 d-none d-lg-block">Filter By:</label>
                                            <select class="form-control select-style-1 filter-by w-auto my-1 mr-2" name="date">
                                                <option value="*" {{ old('date') == '*' ? 'selected' : '' }}>All dates</option>
                                                @foreach($dates as $date)
                                                    <option value="{{ $date->month }}" {{ old('date') == $date->month ? 'selected' : '' }}>{{ $date->month }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-primary filter-btn my-1">Filter</button>
                                        </div>
                                    </div>
                                    <div class="col-auto pl-lg-1 mt-2 mt-lg-0">
                                        <div class="search search-style-1 mx-lg-auto w-auto">
                                            <div class="input-group">
                                                <input type="text" maxlength="50" class="search-term form-control" name="search-term" id="search-term" placeholder="Search" value="{{ old('search-term') }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-ecommerce-simple table-posts table-striped table-responsive-lg mb-0" id="datatable-ecommerce-list">
                                <thead>
                                    <tr>
                                        <th width="30"><input type="checkbox" name="select-all" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                        <th>@sortablelink('id', 'Order')</th>
                                        <th width="30%">Customer</th>
                                        <th>@sortablelink('created_at', 'Date')</th>
                                        <th>Status</th>
                                        <th class="text-lg-right">@sortablelink('order_total_price', 'Total')</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($orders->isNotEmpty())
                                        @foreach($orders as $order)
                                            <tr>
                                                <td><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative" value="" data-id="{{ $order->id }}" /></td>
                                                <td>
                                                    <a href="{{ url('/admin/ecommerce/orders/' . $order->id .'/edit') }}"><strong>#{{ $order->id }}</strong></a>
                                                    <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                </td>
                                                <td data-column="Customer"><a href="#">{{ $order->customer_email }}</a></td>
                                                <td data-column="Date">{{ $order->diff }}</td>
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
                                                <td class="actions" data-column="Actions">
                                                    <a href="{{ url('admin/ecommerce/orders/' . $order->id . '/edit') }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                                    @if(Auth::user()->role_id != 4)
                                                        <a href="javscript:;" class="on-default remove-row"><i class="far fa-trash-alt"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else 
                                        <tr>
                                            <td colspan="7" class="text-center">No orders available.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <hr class="solid mt-5 opacity-4">
                            <div class="datatable-footer">
                                <div class="row align-items-center justify-content-between mt-3">
                                    <div class="col-md-auto order-1 mb-3 mb-lg-0">
                                        <div class="d-flex align-items-stretch">
                                            <select class="form-control select-style-1 bulk-action w-auto mr-3">
                                                <option value="" selected>Bulk Actions</option>
                                                <option value="delete">Delete</option>
                                            </select>
                                            <a href="javascript:;" class="bulk-action-apply btn btn-light border font-weight-semibold text-color-dark text-3">Apply</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-auto text-center order-3 order-lg-2">
                                        <div class="results-info-wrapper"></div>
                                    </div>
                                    <div class="col-lg-auto order-2 order-lg-3 mb-3 mb-lg-0">
                                        {!! $orders->appends(\Request::except('page'))->render() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
@endsection

@section('page-js')
    <script src="{{ asset('server/js/ecommerce/orders/list.min.js') }}"></script>
@endsection