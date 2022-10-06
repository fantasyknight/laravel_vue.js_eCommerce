@extends('admin.layout')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Add Coupon', 'paths' => ['home' => '/dashboard', 'ecommerce' => '/ecommerce', 'coupons' => '/ecommerce/coupons']])
    
    <form class="ecommerce-form " action="{{ url('admin/ecommerce/coupons') }}" method="post">
        @csrf
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="tabs-modern row" style="min-height: 490px;">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <div class="nav flex-column" id="tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="general-tab" data-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="true"><i class="bx bx-cog mr-2"></i> General</a>
                                    <a class="nav-link" id="usage-restriction-tab" data-toggle="pill" href="#usage-restriction" role="tab" aria-controls="usage-restriction" aria-selected="false"><i class="bx bx-block mr-2"></i> Usage Restriction</a>
                                    <a class="nav-link" id="usage-limits-tab" data-toggle="pill" href="#usage-limits" role="tab" aria-controls="usage-limits" aria-selected="false"><i class="bx bx-timer mr-2"></i> Usage Limits</a>
                                </div>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="tab-content" id="tabContent">
                                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                        <div class="form-group row align-items-center">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Coupon Code</label>
                                            <div class="col-lg-7 col-xl-6">
                                                <input type="text" maxlength="50" class="form-control form-control-modern" name="code" value="" required />
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Discount Type</label>
                                            <div class="col-lg-7 col-xl-6">
                                                <select class="form-control form-control-modern" name="discount_type" id="discount-type">
                                                    <option value="percent">Percentage Discount</option>
                                                    <option value="cart">Fixed Cart Discount</option>
                                                    <option value="product">Fixed Product Discount</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Coupon Amount <span class="porto-help-tip ml-0" data-toggle="tooltip" title="" data-original-title="Value of a coupon"></span></label>
                                            <div class="col-lg-7 col-xl-6">
                                                <input type="text" maxlength="20" class="form-control form-control-modern" name="amount" value="0" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-0">Description</label>
                                            <div class="col-lg-7 col-xl-6">
                                                <textarea class="form-control form-control-modern" name="description" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Allow free shipping</label>
                                            <div class="col-lg-7 col-xl-6">
                                                <div class="checkbox">
                                                    <input type="hidden" name="free_shipping" value="0">
                                                    <label class="my-2">
                                                        <input type="checkbox" class="checkbox-style-1" name="free_shipping" value="1">
                                                        Check this box if the coupon grants free shipping. A free shipping method must be enabled in your shipping zone and be set to require "a valid free shipping coupon" (see the "Free Shipping Requires" setting).
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Coupon expiry date <span class="porto-help-tip ml-0" data-toggle="tooltip" title="" data-original-title="The date coupon will expire"></span></label>
                                            <div class="col-lg-7 col-xl-6">
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </span>
                                                    </span>
                                                    <input type="text" class="form-control" name="expiry_date" data-plugin-datepicker  data-plugin-options='{ "format" : "yyyy-mm-dd" }' >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="usage-restriction" role="tabpanel" aria-labelledby="usage-restriction-tab">
                                        <div class="form-group row align-items-center">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Minimum Spend <span class="porto-help-tip ml-0" data-toggle="tooltip" data-original-title="Minimum spend (subtotal) allowed to use the coupon."></span></label>
                                            <div class="col-lg-7 col-xl-6">
                                                <input type="text" maxlength="20" class="form-control form-control-modern" name="minimum_spend" value="" placeholder="No minimum" />
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Maximum Spend <span class="porto-help-tip ml-0" data-toggle="tooltip" data-original-title="Maximum spend (subtotal) allowed to use the coupon."></span></label>
                                            <div class="col-lg-7 col-xl-6">
                                                <input type="text" maxlength="20" class="form-control form-control-modern" name="maximum_spend" value="" placeholder="No maximum" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Individual Use Only?</label>
                                            <div class="col-lg-7 col-xl-6">
                                                <div class="checkbox">
                                                    <input type="hidden" name="individual_use" value="0">
                                                    <label class="my-2">
                                                        <input type="checkbox" class="checkbox-style-1" name="individual_use" value="1">
                                                        Check this box if the coupon cannot be used in conjunction with other coupons.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Exclude Sale Items?</label>
                                            <div class="col-lg-7 col-xl-6">
                                                <div class="checkbox">
                                                    <input type="hidden" name="exclude_sale_items" value="0">
                                                    <label class="my-2">
                                                        <input type="checkbox" class="checkbox-style-1" name="exclude_sale_items" value="1">
                                                        Check this box if the coupon should not apply to items on sale. Per-item coupons will only work if the item is not on sale. Per-cart coupons will only work if there are items in the cart that are not on sale.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Products <span class="porto-help-tip ml-0" data-toggle="tooltip" title="" data-original-title="The products that coupon will be applied to"></span></label>
                                            <div class="col-lg-7 col-xl-6">
                                                <select 
                                                    multiple 
                                                    data-plugin-selectTwo 
                                                    class="form-control form-control-modern" 
                                                    name="products[]"
                                                    data-plugin-options='{
                                                    "minimumInputLength": 3,
                                                    "multiple": true,
                                                    "ajax": {
                                                        "url": "{{ url("/") . "/admin/products/search" }}",
                                                        "delay": 500
                                                    }
                                                }'>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Exclude Products <span class="porto-help-tip ml-0" data-toggle="tooltip" title="" data-original-title="The products that coupon will not be applied to"></span></label>
                                            <div class="col-lg-7 col-xl-6">
                                                <select 
                                                    multiple 
                                                    data-plugin-selectTwo 
                                                    class="form-control form-control-modern" 
                                                    name="exclude_products[]"
                                                    data-plugin-options='{
                                                        "minimumInputLength": 3,
                                                        "multiple": true,
                                                        "ajax": {
                                                            "url": "{{ url("/") . "/admin/products/search" }}",
                                                            "delay": 500
                                                        }
                                                    }'
                                                >
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Product Categories <span class="porto-help-tip ml-0" data-toggle="tooltip" title="" data-original-title="The product categories that coupon will be applied to"></span></label>
                                            <div class="col-lg-7 col-xl-6">
                                                <select
                                                    multiple 
                                                    data-plugin-selectTwo 
                                                    class="form-control form-control-modern"
                                                    name="categories[]"
                                                    data-plugin-options='{
                                                        "minimumInputLength": 3,
                                                        "multiple": true,
                                                        "ajax": {
                                                            "url": "{{ url("/") . "/admin/categories/search" }}",
                                                            "delay": 500
                                                        }
                                                    }'
                                                >
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Exclude Categories <span class="porto-help-tip ml-0" data-toggle="tooltip" title="" data-original-title="The product categories that coupon will not be applied to"></span></label>
                                            <div class="col-lg-7 col-xl-6">
                                                <select 
                                                    multiple
                                                    data-plugin-selectTwo 
                                                    class="form-control form-control-modern" 
                                                    name="exclude_categories[]"
                                                    data-plugin-options='{
                                                        "minimumInputLength": 3,
                                                        "multiple": true,
                                                        "ajax": {
                                                            "url": "{{ url("/") . "/admin/categories/search" }}",
                                                            "delay": 500
                                                        }
                                                    }'
                                                >
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Allowed E-mails <span class="porto-help-tip ml-0" data-toggle="tooltip" title="" data-original-title="Emails that coupon will be applied. use comma(,) or asterisk(*) for multiple emails. e.g. *@gmail.com"></span></label>
                                            <div class="col-lg-7 col-xl-6">
                                                <input type="text" maxlength="50" class="form-control form-control-modern" name="allowed_emails" value="" placeholder="No restrictions" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="usage-limits" role="tabpanel" aria-labelledby="usage-limits-tab">
                                        <div class="form-group row align-items-center">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Usage Limit Per Coupon <span class="porto-help-tip ml-0" data-toggle="tooltip" title="" data-original-title="How many times this coupon will be used."></span></label>
                                            <div class="col-lg-7 col-xl-6">
                                                <input type="number" min="0" class="form-control form-control-modern" name="limit_per_coupon" value="" placeholder="Unlimited Usage" />
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center" id="limit-x-items">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Limit Usage to X Items <span class="porto-help-tip ml-0" data-toggle="tooltip" title="" data-original-title="How many items this coupon will be applied to"></span></label>
                                            <div class="col-lg-7 col-xl-6">
                                                <input type="number" max="10000" min="0" class="form-control form-control-modern" name="limit_x_items" value="" placeholder="Apply to all qualifying items in cart" />
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Usage Limit Per User <span class="porto-help-tip ml-0" data-toggle="tooltip" title="" data-original-title="How many times this coupon will be used by individual user"></span></label>
                                            <div class="col-lg-7 col-xl-6">
                                                <input type="number" max="10000" min="0" class="form-control form-control-modern" name="limit_per_user" value="" placeholder="Unlimited Usage" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row action-buttons">
            <div class="col-6 col-md-auto">
                <button type="submit" class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-loading-text="Loading...">
                    <i class="bx bx-save text-4 mr-2"></i> Save Coupon
                </button>
            </div>
            <div class="col-6 col-md-auto px-md-0">
                <a href="{{ url('/admin/ecommerce/coupons') }}" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark line-height-1 d-flex h-100 align-items-center">Back</a>
            </div>
        </div>
    </form>

    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/common/common.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/ecommerce/coupons/edit.min.js') }}"></script>
@endsection