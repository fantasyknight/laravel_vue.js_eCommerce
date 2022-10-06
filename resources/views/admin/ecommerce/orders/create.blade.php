@extends('admin.layout')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'New Order', 'paths' => ['home' => '/dashboard', 'ecommerce' => '/ecommerce', 'orders' => '/ecommerce/orders']])

    <order-create-component
        :author="{{ Auth::user() }}"
        :customers="{{ $customers }}" 
        :payment-methods="{{ Helper::getAvailablePaymentMethods() }}"
        :products="{{ $products }}"
    ></order-create-component>
@endsection

@section('vendor-js')
    <script>
        var settings = @json(config('setting'));
    </script>
@endsection