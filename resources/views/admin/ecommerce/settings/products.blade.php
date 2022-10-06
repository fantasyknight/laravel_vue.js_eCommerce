@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Products Setting', 'paths' => ['home' => '/dashboard', 'eCommerce' => '/ecommerce', 'settings' => '/ecommerce/settings']])

    <!-- start: page -->
    <form class="ecommerce-form " action="{{ url('admin/ecommerce/settings/') }}" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-box"></i>
                                <h2 class="card-big-info-title">General</h2>
                                <p class="card-big-info-desc">Add products info with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Measurements</label>
                                    <div class="col-lg-7 col-xl-9 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="control-label">Weight Unit <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="This controls what unit you will define weights in."></span></label>
                                                <select class="form-control form-control-modern" name="product_weight_unit">
                                                    @foreach(Config::get('constant.product_weight_units') as $unit_key => $unit_value)
                                                        <option value="{{ $unit_key }}" @if($product_weight_unit == $unit_key) selected @endif>{{ $unit_value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="control-label">Dimensions Unit <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="This controls what unit you will define lengths in."></span></label>
                                                <select class="form-control form-control-modern" name="product_dimentions_unit">
                                                    @foreach(Config::get('constant.product_dimentions_units') as $unit_key => $unit_value)
                                                        <option value="{{ $unit_key }}" @if($product_dimentions_unit == $unit_key) selected @endif>{{ $unit_value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Reviews</label>
                                    <div class="col-lg-7 col-xl-9 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="control-label">Enable reviews</label>
                                                <div class="checkbox">
                                                    <label class="my-1">
                                                        <input type="hidden" name="product_enable_reviews" value="0" />
                                                        <input name="product_enable_reviews" class="checkbox-style-1" type="checkbox" @if($product_enable_reviews) checked @endif id="product_enable_reviews" value="1">
                                                        Enable product reviews
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 product-ratings-container">
                                                <label class="control-label">Product ratings</label>
                                                <div class="checkbox">
                                                    <label class="my-1">
                                                        <input type="hidden" name="product_enable_star_rating" value="0" />
                                                        <input name="product_enable_star_rating" class="checkbox-style-1" type="checkbox" @if($product_enable_star_rating) checked @endif id="product_enable_star_rating" value="1">
                                                        Enable star rating on reviews
                                                    </label>
                                                </div>
                                                <div class="checkbox product-star-rating-required-container">
                                                    <label class="my-1">
                                                        <input type="hidden" name="product_star_rating_required" value="0" />
                                                        <input name="product_star_rating_required" class="checkbox-style-1" type="checkbox" @if($product_star_rating_required) checked @endif value="1">
                                                        Star ratings should be required, not optional
                                                    </label>
                                                </div>
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
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-basket"></i>
                                <h2 class="card-big-info-title">Inventory</h2>
                                <p class="card-big-info-desc">Add the inventory info with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Manage stock</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <div class="checkbox">
                                            <label class="my-2">
                                                <input type="hidden" name="product_enable_stock_management" value="0" />
                                                <input name="product_enable_stock_management" class="checkbox-style-1" type="checkbox" @if($product_enable_stock_management) checked @endif id="product_enable_stock_management" value="1">
                                                Enable stock management
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="form-group row align-items-center hold-stock-container">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Hold stock (minutes)</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="number" min="0" max="100000" name="product_hold_stock" class="form-control form-control-modern" value="{{ $product_hold_stock }}">
                                    </div>
                                </div>
                                <div class="form-group row notification-container">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Notifications</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <div class="checkbox">
                                            <label class="my-2">
                                                <input type="hidden" name="product_enable_low_stock_notifications" value="0" />
                                                <input name="product_enable_low_stock_notifications" class="checkbox-style-1" type="checkbox" @if($product_enable_low_stock_notifications) checked @endif value="1">
                                                Enable low stock notificiations
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label class="my-2">
                                                <input type="hidden" name="product_enable_out_of_stock_notifications" value="0" />
                                                <input name="product_enable_out_of_stock_notifications" class="checkbox-style-1" type="checkbox" @if($product_enable_out_of_stock_notifications) checked @endif value="1">
                                                Enable out of stock notifications
                                            </label>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form-group row align-items-center low-stock-threshold-container">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Low stock threshold</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="number" name="product_low_stock_threshold" class="form-control form-control-modern" value="{{ $product_low_stock_threshold }}" min="0">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center out-of-stock-threshold-container">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Out of stock threshold</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="number" name="product_out_of_stock_threshold" class="form-control form-control-modern" value="{{ $product_out_of_stock_threshold }}" min="0">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Out of stock visibility</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <div class="checkbox">
                                            <label class="my-2">
                                                <input type="hidden" name="product_out_of_stock_visibility" value="0" />
                                                <input name="product_out_of_stock_visibility" class="checkbox-style-1" type="checkbox" @if($product_out_of_stock_visibility) checked @endif value="1">
                                                Hide out of stock items from the catalog
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Stock display format</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select class="form-control form-control-modern" name="product_stock_display_format">
                                            <option value="1" @if($product_stock_display_format == '1') selected @endif>Always show quantity remaining in stock</option>
                                            <option value="2" @if($product_stock_display_format == '2') selected @endif>Only show quantity remaining in stock when low</option>
                                            <option value="3" @if($product_stock_display_format == '3') selected @endif>Never show quantity remaining in stock</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row action-buttons">
            <div class="col-12 col-md-auto">
                <button type="submit" class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-loading-text="Loading...">
                    <i class="bx bx-save text-4 mr-2"></i> Save Changes
                </button>
            </div>
            <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                <a href="#" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark line-height-1 d-flex h-100 align-items-center">Back</a>
            </div>
        </div>
    </form>
    <!-- end: page -->
@endsection

@section('page-js')
    <script src="{{ asset('server/js/ecommerce/settings/products.min.js') }}"></script>
@endsection


