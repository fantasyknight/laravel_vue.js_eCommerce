@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Order Detail', 'paths' => ['home' => '/dashboard', 'ecommerce' => '/ecommerce', 'orders' => '/ecommerce/orders']])

    <order-detail-component :order="{{ $order }}" :refunded="{{ $refunded }}" :sub-orders="{{ $sub_orders }}" :role-id="{{ Auth::user()->role_id }}"></order-detail-component>
@endsection

@section('vendor-js')
    <script>
        var settings = @json(config('setting'));
    </script>
@endsection