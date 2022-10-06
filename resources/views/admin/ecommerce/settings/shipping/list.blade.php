@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Shipping', 'paths' => ['home' => '/dashboard', 'eCommerce' => '/ecommerce', 'settings' => '/ecommerce/settings']])

    <!-- start: page -->
    <div class="row">
        <div class="col">
            <form action="{{ url('admin/ecommerce/settings/') }}" class="ecommerce-setting-form" method="post">
                @method('PUT')
                @csrf
                <div class="card card-modern shadow-none">
                    <header class="card-header">
                        <div class="card-actions">
                            <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        </div>

                        <h2 class="card-title">Shipping options</h2>
                    </header>
                    <div class="card-body">
                        <div class="form-group row align-items-center">
                            <label class="col-lg-5 col-xl-4 control-label text-lg-right mb-0">Calculations</label>
                            <div class="col-lg-7 col-xl-8">
                                <div class="checkbox-custom my-2">
                                    <input type="hidden" name="enable_shipping_calc_on_cartpage" value="0" />
                                    <input type="checkbox" id="enable_on_cart_page" name="enable_shipping_calc_on_cartpage" value="1" {{ $enable_shipping_calc_on_cartpage == '1' ? 'checked' : '' }} />
                                    <label for="enable_on_cart_page">
                                        Enable the shipping calculator on the cart page
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-5 col-xl-4 control-label text-lg-right mt-2 pt-1 mb-0">Shipping destination <span class="porto-help-tip" data-toggle="tooltip" title="This shows which address is used by default"></span></label>
                            <div class="col-lg-7 col-xl-8">
                                <div class="radio-custom my-2">
                                    <input name="default_shipping_address" id="customer_shipping" value="customer_shipping" type="radio" {{ $default_shipping_address == 'customer_shipping' ? 'checked' : '' }}>
                                    <label for="customer_shipping">
                                        Default to customer shipping address
                                    </label>
                                </div>
                                <div class="radio-custom my-2">
                                    <input name="default_shipping_address" id="customer_billing" value="customer_billing" type="radio" {{ $default_shipping_address == 'customer_billing' ? 'checked' : '' }}>
                                    <label for="customer_billing">
                                        Default to customer billing address
                                    </label>
                                </div>
                                <div class="radio-custom my-2">
                                    <input name="default_shipping_address" id="force_billing" value="force_billing" type="radio" {{ $default_shipping_address == 'force_billing' ? 'checked' : '' }}>
                                    <label for="force_billing">
                                        Force shipping to the customer billing address
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer text-right">
                        <button class="btn btn-primary">Save changes</button>
                    </footer>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            
            <div class="card card-modern">
                <div class="card-body">
                    <div class="datatables-header-footer-wrapper">
                        <form action="{{ url('/admin/ecommerce/settings/shipping') }}" method="GET">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-3">
                                    <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                        <a href="{{ url('/admin/ecommerce/settings/shipping/create') }}" class="btn btn-primary btn-md font-weight-semibold">+ Add Zone</a>
                                    </div>
                                    <div class="col-sm-6 col-lg-auto ml-lg-auto mb-4 mb-lg-0">
                                        <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                            <label class="ws-nowrap mr-3 mb-0">Filter By:</label>
                                            <select class="form-control select-style-1 filter-by" name="filter-by">
                                                <option value="*" {{ old('filter-by') == '*' ? 'selected' : '' }}>All</option>
                                                <option value="name" {{ old('filter-by') == 'name' ? 'selected' : '' }}>Zone</option>
                                                <option value="regions" {{ old('filter-by') == 'regions' ? 'selected' : '' }}>Region</option>
                                                <option value="methods" {{ old('filter-by') == 'methods' ? 'selected' : '' }}>Shipping Methods</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-auto pl-lg-1">
                                        <div class="search search-style-1 mx-lg-auto">
                                            <div class="input-group">
                                                <input type="text" class="search-term form-control" name="search-term" id="search-term" placeholder="Search" value="{{ old('search-term') }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list">
                            <thead>
                                <tr>
                                    <th width="3%"><input type="checkbox" name="select-all" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                    <th width="28%">@sortablelink('name', 'Zone Name')</th>
                                    <th width="23%">Region(s)</th>
                                    <th width="30%">Shipping Method</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shipping_zones as $shipping_zone)
                                    <tr>
                                        <td width="30"><input type="checkbox" class="checkbox-style-1 p-relative" value="" data-id="{{ $shipping_zone->id }}" /></td>
                                        <td>
                                            <a href="{{ url('/admin/ecommerce/settings/shipping') }}/{{ $shipping_zone->id }}/edit"><strong>{{ $shipping_zone->name }}</strong></a>
                                            <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                        </td>
                                        <td data-column="Zone name">
                                            @foreach($shipping_zone->shippingLocations as $location)
                                                @if ($loop->last) 
                                                    {{ $location->name }}
                                                @else 
                                                    {{ $location->name }},
                                                @endif
                                            @endforeach
                                        </td>
                                        <td data-column="Shipping Method">
                                            @foreach($shipping_zone->shippingZoneMethods as $method)
                                                @if ($loop->last) 
                                                    {{ $method->name }}
                                                @else 
                                                    {{ $method->name }},
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="actions" data-column="Actions">
                                            <a href="{{ url('admin/ecommerce/settings/shipping/' . $shipping_zone->id . '/edit') }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="javscript:;" class="on-default remove-row" data-id="{{ $shipping_zone->id }}"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr class="solid mt-5 opacity-4">
                        <div class="datatable-footer">
                            <div class="row align-items-center justify-content-between mt-3">
                                <div class="col-md-auto order-1 mb-3 mb-lg-0">
                                    <div class="d-flex align-items-stretch">
                                        <select class="form-control select-style-1 bulk-action mr-3" name="bulk-action" style="min-width: 120px;">
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
                                    <div class="pagination-wrapper"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end: page -->
    @include('admin.common.modals.delete-confirm')
@endsection

@section('page-js')
    <script src="{{ asset('server/js/ecommerce/settings/shipping.min.js') }}"></script>
@endsection