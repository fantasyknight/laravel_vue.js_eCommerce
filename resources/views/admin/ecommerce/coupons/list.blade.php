@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'All Coupons', 'paths' => ['home' => '/dashboard', 'ecommerce' => '/ecommerce']])

    <div class="row">
        <div class="col">
            <form id="posts-list-form" method="get">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-lg-center mb-3">
                                    <div class="col-xl-auto mb-2 mt-1 mb-xl-0">
                                        <a href="{{ url('/admin/ecommerce/coupons/create') }}" class="btn btn-primary btn-md font-weight-semibold">+ Add Coupon</a>
                                    </div>
                                    <div class="col-lg-auto mb-2 mb-lg-0 ml-xl-auto pl-xl-1">
                                        <div class="d-flex align-items-lg-center flex-wrap">
                                            <label class="d-none d-xl-block ws-nowrap mr-3 mb-0">Filter By:</label>
                                            <select class="form-control select-style-1 filter-by w-auto my-1 mr-2" name="discount-type">
                                                <option value="percent" {{ old('discount-type') == 'percent' ? 'selected' : '' }}>Percent Discount</option>
                                                <option value="cart" {{ old('discount-type') == 'cart' ? 'selected' : '' }}>Fixed Cart Discount</option>
                                                <option value="product" {{ old('discount-type') == 'product' ? 'selected' : '' }}>Fixed Product Discount</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary filter-btn my-1">Filter</button>
                                        </div>
                                    </div>
                                    <div class="col-auto pl-lg-1">
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
                            <div class="table-responsive">
                                <table class="table table-ecommerce-simple table-posts table-striped table-responsive-lg mb-0" id="datatable-ecommerce-list">
                                    <thead>
                                        <tr>
                                            <th width="30"><input type="checkbox" name="select-all" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                            <th>Code</th>
                                            <th>Coupon type</th>
                                            <th>Coupon amount</th>
                                            <th>Description</th>
                                            <th>Product IDs</th>
                                            <th>Usage / Limit</th>
                                            <th width="120">@sortablelink('expiry_date', 'Expiry Date')</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($coupons->isNotEmpty())
                                            @foreach($coupons as $coupon)
                                                <tr>
                                                    <td><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative" value="" data-id="{{ $coupon->id }}" /></td>
                                                    <td>
                                                        <a href="{{ url('/admin/ecommerce/coupons/' . $coupon->id . '/edit') }}"><strong>{{ $coupon->code }}</strong></a>
                                                        <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                    </td>
                                                    <td data-column="Coupon type">
                                                        @switch($coupon->discount_type)
                                                            @case('percent')
                                                                Percentage Discount
                                                                @break
                                                            @case('cart')
                                                                Fixed Cart Discount
                                                                @break
                                                            @case('product')
                                                                Fixed Product Discount
                                                                @break
                                                        @endswitch
                                                    </td>
                                                    <td data-column="Coupon amount">{{ $coupon->amount }}</td>
                                                    <td data-column="Description">{{ $coupon->description }}</td>
                                                    <td data-column="Product IDs">{{ implode(',', $coupon->products) }}</td>
                                                    <td data-column="Usage / Limit">{{ $coupon->usage }} / {{ $coupon->limit_per_coupon ?: '∞' }}</td>
                                                    <td data-column="Expiry Date">{{ $coupon->expiry_date }}</td>
                                                    <td class="actions" data-column="Actions">
                                                        <a href="{{ url('admin/ecommerce/coupons/' . $coupon->id . '/edit') }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="javscript:;" class="on-default remove-row"><i class="far fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else 
                                            <tr>
                                                <td colspan="9" class="text-center">No coupons available.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
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
                                        {!! $coupons->appends(\Request::except('page'))->render() !!}
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
    <script src="{{ asset('server/js/ecommerce/coupons/list.min.js') }}"></script>
@endsection