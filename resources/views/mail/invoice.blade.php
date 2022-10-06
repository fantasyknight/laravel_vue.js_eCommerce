<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Laravel porto" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Porto</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('server/images/icons/favicon.ico') }}">
    <!-- Fonts -->

    <!-- Vendor Css -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" />
</head>
<body>
    <div class="container pt-5 mt-2">
        <h2 class="text-center font-weight-bolder">Invoice</h2>
        <hr class="mb-4">
        <p>Invoice Date: {{ $order->created_at }}</p>

        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-4">From</h4>
                <p>
                    {{ $user->first_name }} {{ $user->last_name }} <br />
                    {{ $user->billing_address_1 }}, {{ $user->billing_state }}, {{ $user->billing_country }} <br />
                    Phone: {{ $user->billing_phone }}
                </p>
            </div>
            <div class="col-sm-6">
                <h4 class="mb-4">To</h4>
                <p>
                    {{ $order->billing_first_name }} {{ $order->billing_last_name }} <br />
                    {{ $order->billing_street_1 }}, {{ $order->billing_state }}, {{ $order->billing_country }} <br />
                    Phone: {{ $order->billing_phone }}
                </p>
            </div>
        </div>
        <hr class="mb-5">
        <h5 class="mb-3">Purchased Items</h5>            
        <table class="table table-bordered mb-5">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->gross_revenue }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h5 class="mb-3">General order info</h5>   
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Info</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Payment Method</td>
                    <td>{{ $order->payment_method }}</td>
                </tr>
                <tr>
                    <td>Shipping Method</td>
                    <td>{{ $order->shipping_method }}  <strong>${{ $order->shipping_cost }}</strong></td>
                </tr>
                <tr>
                    <td>Refund</td>
                    <td>{{ $order->order_refunded_price }}</td>
                </tr>
                @foreach($order->coupons as $coupon)
                    <tr>
                        <td>Coupon <strong>{{ $coupon->coupon_code }}<strong></td>
                        <td>{{ $coupon->coupon_amount }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>Tax</td>
                    <td>{{ $order->order_tax }}</td>
                </tr>
                <tr>
                    <td><strong>Grant Total</strong></td>
                    <td>${{ $order->order_total_price }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
