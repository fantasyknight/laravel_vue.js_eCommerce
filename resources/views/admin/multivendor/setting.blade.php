@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Vendor Setting', 'paths' => ['home' => '/dashboard', 'settings' => '/multivendor/setting']])

    <!-- start: page -->
    <div class="row">
        <div class="col">
            <section class="card card-modern card-big-info">
                <div class="card-body">
                <div class="tabs-modern row" style="min-height: 490px;">
                    <div class="col-lg-2-5 col-xl-1-5">
                        <div id="tab" role="tablist" aria-orientation="vertical" class="nav flex-column">
                            <a id="general-tab" data-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="true" class="nav-link active">General</a> 
                            <a id="privilege-tab" data-toggle="pill" href="#privilege" role="tab" aria-controls="privilege" aria-selected="false" class="nav-link">Privilege</a>
                            <a id="appearance-tab" data-toggle="pill" href="#appearance" role="tab" aria-controls="appearance" class="nav-link" aria-selected="false">Appearance</a>
                        </div>
                    </div>
                    <div class="col-lg-3-5 col-xl-4-5">
                        <div id="tabContent" class="tab-content">
                            <div id="general" role="tabpanel" aria-labelledby="general-tab" class="tab-pane fade active show">
                                <form class="ecommerce-form " action="{{ url('admin/ecommerce/settings/') }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <h3 class="mt-0 pb-2 w-100 border-bottom mb-3">Commission</h3>
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Commision Type</label> 
                                        <div class="col-lg-7 col-xl-6">
                                            <select name="commission_type" class="form-control form-control-modern float-left w-auto mr-3">
                                                <option value="flat" @if ($commission_type == 'flat') selected @endif>Flat</option>
                                                <option value="percentage" @if ($commission_type == 'percentage') selected @endif>Percentage</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center border-top-0 pt-0">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Admin Commission</label> 
                                        <div class="col-lg-7 col-xl-6">
                                            <input type="text" name="commission_amount" value="{{ $commission_amount }}" required="required" class="form-control form-control-modern">
                                        </div>
                                    </div>

                                    <h3 class="mt-0 pb-2 w-100 border-bottom mb-3">Withdraw</h3>
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Withdraw Method</label> 
                                        <div class="col-lg-7 col-xl-6">
                                            <div class="checkbox">
                                                <label class="my-2">
                                                    <input type="hidden" value="0" name="withdraw_paypal" class="checkbox-style-1">
                                                    <input type="checkbox" value="1" name="withdraw_paypal" @if ($withdraw_paypal == '1') checked @endif class="checkbox-style-1">Paypal
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center border-top-0 pt-0">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Minimum Withdraw Limit</label> 
                                        <div class="col-lg-7 col-xl-6">
                                            <input type="text" name="minimum_withdraw" value="{{ $minimum_withdraw }}" required="required" class="form-control form-control-modern">
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Exclude COD Payments</label> 
                                        <div class="col-lg-7 col-xl-6">
                                            <div class="checkbox">
                                                <label class="my-2">
                                                    <input type="hidden" value="0" name="exclude_cod_payment" class="checkbox-style-1">
                                                    <input type="checkbox" value="1" name="exclude_cod_payment" @if ($exclude_cod_payment == '1') checked @endif class="checkbox-style-1">If an order is paid with Cash on Delivery (COD), then exclude that payment from vendor balance.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bt-3">
                                        <button type="submit" class="btn btn-primary mb-2 mr-3">Save</button>
                                    </div>
                                </form>
                            </div>
                            <div id="privilege" role="tabpanel" aria-labelledby="privilege-tab" class="tab-pane fade">
                                <form class="ecommerce-form " action="{{ url('admin/ecommerce/settings/') }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <h3 class="mt-0 pb-2 w-100 border-bottom mb-3">Vendor Capability</h3>
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0"></label> 
                                        <div class="col-lg-7 col-xl-6">
                                            <div class="checkbox">
                                                <label class="my-2">
                                                    <input type="hidden" value="0" name="vendor_allow_media" class="checkbox-style-1">
                                                    <input type="checkbox" value="1" name="vendor_allow_media" @if ($vendor_allow_media == '1') checked @endif class="checkbox-style-1">Allow vendors to manage media
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0"></label> 
                                        <div class="col-lg-7 col-xl-6">
                                            <div class="checkbox">
                                                <label class="my-2">
                                                    <input type="hidden" value="0" name="vendor_allow_product" class="checkbox-style-1">
                                                    <input type="checkbox" value="1" name="vendor_allow_product" @if ($vendor_allow_product == '1') checked @endif class="checkbox-style-1">Allow vendors to manage product
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0"></label> 
                                        <div class="col-lg-7 col-xl-6">
                                            <div class="checkbox">
                                                <label class="my-2">
                                                    <input type="hidden" value="0" name="vendor_allow_post" class="checkbox-style-1">
                                                    <input type="checkbox" value="1" name="vendor_allow_post" @if ($vendor_allow_post == '1') checked @endif class="checkbox-style-1">Allow vendors to manage post
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0"></label> 
                                        <div class="col-lg-7 col-xl-6">
                                            <div class="checkbox">
                                                <label class="my-2">
                                                    <input type="hidden" value="0" name="vendor_allow_order_status" class="checkbox-style-1">
                                                    <input type="checkbox" value="1" name="vendor_allow_order_status" @if ($vendor_allow_order_status == '1') checked @endif class="checkbox-style-1">Allow vendors to manage order status
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bt-3">
                                        <button type="submit" class="btn btn-primary mb-2 mr-3">Save</button>
                                    </div>
                                </form>
                            </div>
                            <div id="appearance" class="tab-pane fade" role="tabpanel" aria-labelledby="appearance-tab">
                                <form class="ecommerce-form " action="{{ url('admin/ecommerce/settings/') }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <h3 class="mt-0 pb-2 w-100 border-bottom mb-3">Appearance</h3>
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Vendor Header One</label> 
                                        <div class="col-lg-7 col-xl-9">
                                            <div class="radio-custom radio-image">
                                                <input type="radio" id="product-type-one" name="vendor_header_type" value="StoreHeaderOneComponent" @if ($vendor_header_type == 'StoreHeaderOneComponent') checked @endif> 
                                                <label for="product-type-one">
                                                    <img class="w-100 h-auto" src="{{ url('/server/images/vendors/vendor-header-1.PNG') }}" alt="header" width="1103" height="231">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Vendor Header Two</label> 
                                        <div class="col-lg-7 col-xl-9">
                                            <div class="radio-custom radio-image">
                                                <input type="radio" id="product-type-two" name="vendor_header_type" value="StoreHeaderTwoComponent" @if ($vendor_header_type == 'StoreHeaderTwoComponent') checked @endif> 
                                                <label for="product-type-two">
                                                    <img class="w-100 h-auto" src="{{ url('/server/images/vendors/vendor-header-2.PNG') }}" alt="header" width="1106" height="799">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Vendor Header Three</label>
                                        <div class="col-lg-7 col-xl-9">
                                            <div class="radio-custom radio-image">
                                                <input type="radio" id="product-type-three" name="vendor_header_type" value="StoreHeaderThreeComponent"> 
                                                <label for="product-type-three">
                                                    <img class="w-100 h-auto" src="{{ url('/server/images/vendors/vendor-header-3.PNG') }}" alt="header" width="290" height="446">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Vendor Header Four</label>
                                        <div class="col-lg-7 col-xl-9">
                                            <div class="radio-custom radio-image">
                                                <input type="radio" id="product-type-four" name="vendor_header_type" value="StoreHeaderFourComponent"> 
                                                <label for="product-type-four">
                                                    <img class="w-100 h-auto" src="{{ url('/server/images/vendors/vendor-header-4.PNG') }}" alt="header" width="290" height="446">
                                                </label>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="bt-3">
                                        <button type="submit" class="btn btn-primary mb-2 mr-3">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('page-js')
@endsection