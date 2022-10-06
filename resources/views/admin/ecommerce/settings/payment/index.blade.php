@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Payment Methods', 'paths' => ['home' => '/dashboard', 'eCommerce' => '/ecommerce', 'settings' => '/ecommerce/settings']])

    <form class="ecommerce-form" action="{{ url('admin/ecommerce/settings/payment') }}" method="get">
        <!-- start: page -->
        <div class="card card-modern">
            <div class="card-body">
                <div class="datatables-header-footer-wrapper">
                    <div class="datatable-header">
                        <div class="row align-items-center mb-3 text-right">
                            <div class="col-12 col-lg-auto pl-lg-1 ml-auto">
                                <div class="search search-style-1 mx-lg-auto">
                                    <div class="input-group">
                                        <input type="text" maxlength="20" class="search-term form-control" name="search-term" id="search-term" value="{{ old('search-term') }}" placeholder="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list">
                        <thead>
                            <tr>
                                <th width="15%">ID</th>
                                <th >Title</th>
                                <th width="25%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payment_methods as $method)
                                @if($method->id != '3')
                                    <tr>
                                        <td><a href="{{ url('admin/ecommerce/settings/payment') }}/{{ $method->id }}/edit"><strong>{{ $method->id }}</strong></a></td>
                                        <td><a href="{{ url('admin/ecommerce/settings/payment') }}/{{ $method->id }}/edit"><strong>{{ $method->name }}</strong></a><a href="javascript:;" class="slide-content d-block d-lg-none"></a></td>
                                        <td data-column="Status"><input type="checkbox" class="checkbox-style-1 p-relative payment-method-checkbox" @if($method->enabled) checked @endif data-id="{{ $method->id }}" /></td>
                                    </tr>
                                @else 
                                    <tr>
                                        <td><a href="javascript:;"><strong>{{ $method->id }}</strong></a></td>
                                        <td><a href="javascript:;"><strong>{{ $method->name }}</strong></a><a href="javascript:;" class="slide-content d-block d-lg-none"></a></td>
                                        <td data-column="Status"><input type="checkbox" class="checkbox-style-1 p-relative payment-method-checkbox" @if($method->enabled) checked @endif data-id="{{ $method->id }}" /></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
        <!-- end: page -->
    </form>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/ecommerce/settings/payment.min.js') }}"></script>
@endsection


