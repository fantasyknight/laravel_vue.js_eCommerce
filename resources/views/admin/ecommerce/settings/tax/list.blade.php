@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Tax Setting', 'paths' => ['home' => '/dashboard', 'eCommerce' => '/ecommerce', 'settings' => '/ecommerce/settings']])

    <!-- start: page -->
    <form class="ecommerce-setting-form pb-5" action="{{ url('admin/ecommerce/settings/') }}" method="post">
        @method('PUT')
        @csrf
        <div class="card card-modern">
            <header class="card-header">
                <h2 class="card-title">Tax options</h2>
                <div class="card-actions">
                    <a href="javascript:;" class="card-action card-action-toggle" data-card-toggle></a>
                </div>
            </header>
            <div class="card-body">
                <div class="form-group row align-items-center">
                    <label class="col-lg-5 col-xl-4 control-label text-lg-right mb-0">Calculate tax based on <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="This option determines which address is used to calculate tax."></span></label>
                    <div class="col-lg-7 col-xl-8">
                        <select class="form-control form-control-modern" name="calculate_tax_based_on">
                            <option value="shipping" @if($calculate_tax_based_on == 'shipping') selected @endif>Customer shipping address</option>
                            <option value="billing" @if($calculate_tax_based_on == 'billing') selected @endif>Customer billing address</option>
                            <option value="base" @if($calculate_tax_based_on == 'base') selected @endif>Shop base address</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-5 col-xl-4 control-label text-lg-right mt-2 mb-0">Shipping tax class <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="Optionally control which tax class shipping gets, or leave it so shipping tax is based on the cart items themselves."></span></label>
                    <div class="col-lg-7 col-xl-8">
                        <select class="form-control form-control-modern" name="shipping_tax_class">
                            <option value="cart_item" @if($shipping_tax_class == 'cart_item') selected @endif>Shipping tax class based on cart items.</option>
                            @foreach($tax_types as $tax_type)
                                <option value="{{ $tax_type['slug'] }}" @if($shipping_tax_class == $tax_type['slug']) selected @endif>{{ $tax_type['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label class="col-lg-5 col-xl-4 control-label text-lg-right mb-0">Rounding</label>
                    <div class="col-lg-7 col-xl-8">
                        <div class="checkbox-custom my-2">
                            <input type="hidden" name="tax_round_at_subtotal" value="0" />
                            <input type="checkbox" id="tax_round" name="tax_round_at_subtotal" value="1" @if($tax_round_at_subtotal == '1') checked @endif>
                            <label for="tax_round">
                                Round tax at subtotal level, instead of rounding per line
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label class="col-lg-5 col-xl-4 control-label text-lg-right mb-0">Display prices during cart and checkout</label>
                    <div class="col-lg-7 col-xl-8">
                        <select class="form-control form-control-modern" name="tax_display_in_cart_checkout">
                            <option value="include" @if($tax_display_in_cart_checkout == 'include') selected @endif>Including tax</option>
                            <option value="exclude" @if($tax_display_in_cart_checkout == 'exclude') selected @endif>Excluding tax</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label class="col-lg-5 col-xl-4 control-label text-lg-right mb-0">Price display suffix</label>
                    <div class="col-lg-7 col-xl-8">
                        <input type="text" maxlength="20" class="form-control form-control-modern" name="tax_display_suffix" value="{{ $tax_display_suffix }}" placeholder="N/A">
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button class="btn btn-primary">Save changes</button>
            </footer>
        </div>
    </form>

    <form class="ecommerce-tax-class-form">
        <div class="card card-modern">
            <div class="card-body">
                <div class="datatables-header-footer-wrapper">
                    <div class="datatable-header">
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                <a href="{{ url('/admin/ecommerce/settings/tax/create') }}" class="btn btn-primary btn-md font-weight-semibold">+ Add Tax Class</a>
                            </div>
                            <div class="col-sm-6 col-lg-auto ml-lg-auto">
                                <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                    <label class="d-none d-lg-block ws-nowrap mr-3 mb-0">Filter By:</label>
                                    <select class="form-control select-style-1 filter-by" name="filter-by">
                                        <option value="*" @if(old('filter-by') == '*')) selected @endif>All</option>
                                        <option value="name" @if(old('filter-by') == 'name')) selected @endif>Tax Class</option>
                                        <option value="description" @if(old('filter-by') == 'description')) selected @endif>Description</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-auto pl-lg-1">
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
                                <th width="3%"><input type="checkbox" name="select-all" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                <th>@sortablelink('name', 'Class')</th>
                                <th width="50%">@sortablelink('description', 'Description')</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tax_classes as $tax_class)
                                <tr>
                                    <td width="30"><input type="checkbox" class="checkbox-style-1 p-relative" value="" data-id="{{ $tax_class->id }}"/></td>
                                    <td><a href="{{ url('admin/ecommerce/settings/tax/'.$tax_class->id.'/edit') }}"><strong>{{ $tax_class->name }}</strong></a><a href="javascript:;" class="slide-content d-block d-lg-none"></a></td>
                                    <td data-column="Description">{{ $tax_class->description }}</td>
                                    <td class="actions" data-column="Actions">
                                        <a href="{{ url('admin/ecommerce/settings/tax/'.$tax_class->id.'/edit') }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="javscript:;" class="on-default remove-row"><i class="far fa-trash-alt"></i></a>
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
                                <div class="pagination-wrapper d-flex justify-content-end">
                                    {!! $tax_classes->appends(\Request::except('page'))->render() !!}
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- end: page -->
    @include('admin.common.modals.delete-confirm')
@endsection

@section('page-js')
    <script src="{{ asset('server/js/ecommerce/settings/tax.min.js') }}"></script>
@endsection