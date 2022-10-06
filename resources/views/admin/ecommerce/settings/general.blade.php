@extends('admin.layout')

@section('vendor-css')
    <!-- <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'General Setting', 'paths' => ['home' => '/dashboard', 'eCommerce' => '/ecommerce', 'settings' => '/ecommerce/settings']])

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
                                <i class="card-big-info-icon bx bx-store"></i>
                                <h2 class="card-big-info-title">Store Address</h2>
                                <p class="card-big-info-desc">Add here the customer billing info with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Address Line 1 <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="The street address for your business location."></span></label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="50" class="form-control form-control-modern" name="store_address_line_1" value="{{ $store_address_line_1 }}" />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Address Line 2 <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="An additional, optional address line for your business location."></span></label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="50" class="form-control form-control-modern" name="store_address_line_2" value="{{ $store_address_line_2 }}" />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">City <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="The city in which your business is located."></span></label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="50" class="form-control form-control-modern" name="store_city" value="{{ $store_city }}" />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Country / State <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="The country and state or province, if any, in which your business is located."></span></label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select data-plugin-selectTwo class="form-control populate" name="store_country" data-plugin-options='{ "placeholder": "Choose countries / cities" }'>
                                            @foreach ( Config::get('constant.countries') as $country_code => $country_name )
                                                @if(array_key_exists($country_code, Config::get('constant.states')) && count(Config::get('constant.states')[$country_code]) != 0)
                                                    <optgroup label="{!! $country_name !!}">
                                                        @foreach ( Config::get('constant.states')[$country_code] as $state_code => $state_name )
                                                            <option value="state:{{ $country_code }}:{{ $state_code }}" @if($store_country == 'state:' . $country_code . ':' . $state_code) selected @endif>&nbsp;&nbsp;{!! $state_name !!}, {!! $country_name !!}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @else
                                                    <option value="country:{{ $country_code }}" @if($store_country == 'country:' . $country_code) selected @endif>{!! $country_name !!}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Postcode / ZIP <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="The postal code, if any, in which your business is located."></span></label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="number" class="form-control form-control-modern" name="store_postcode" value="{{ $store_postcode }}" min="10000" max="99999" />
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
                                <i class="card-big-info-icon bx bx-box"></i>
                                <h2 class="card-big-info-title">General Option</h2>
                                <p class="card-big-info-desc">Add here the customer shipping info with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Selling Location(s) <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="This option lets you limit which countries you are willing to sell to."></span></label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select class="form-control form-control-modern" name="selling_location" id="selling_location">
                                            <option value="all" @if($selling_location == 'all') selected @endif>Sell to all countries</option>
                                            <option value="all_except" @if($selling_location == 'all_except') selected @endif>Sell to all countries, except for ...</option>
                                            <option value="specific" @if($selling_location == 'specific') selected @endif>Sell to specific countries</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center" id="sell_to_specific_countries_container">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Sell to specific countries</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select multiple data-plugin-selectTwo class="form-control populate" name="sell_to_specific_countries[]" data-plugin-options='{ "placeholder": "Choose countries" }'>
                                            @foreach ( Config::get('constant.countries') as $country_code => $country_name )
                                                <option value="country:{{ $country_code }}" @if($sell_to_specific_countries && in_array('country:' . $country_code, json_decode($sell_to_specific_countries))) selected @endif>{!! $country_name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Shipping Location(s) <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="Choose which countries you want to ship to, or choose to ship to all locations you sell to."></span></label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select class="form-control form-control-modern" name="shipping_location" id="shipping_location">
                                            <option value="sellable" @if($shipping_location == 'sellable') selected @endif>Ship to all countries you sell to</option>
                                            <option value="all" @if($shipping_location == 'all') selected @endif>Ship to all countries</option>
                                            <option value="specific" @if($shipping_location == 'specific') selected @endif>Ship to specific countries only</option>
                                            {{-- <option value="disabled" @if($shipping_location == 'disabled') selected @endif>Disable shipping &amp; shipping calculations</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center" id="ship_to_specific_countries_container">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Ship to specific countries</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select multiple data-plugin-selectTwo class="form-control populate" name="ship_to_specific_countries[]" data-plugin-options='{ "placeholder": "Choose countries" }'>
                                            @foreach ( Config::get('constant.countries') as $country_code => $country_name )
                                                <option value="country:{{ $country_code }}" @if($ship_to_specific_countries && in_array('country:' . $country_code, json_decode($ship_to_specific_countries))) selected @endif>{!! $country_name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Default Customer Location <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="This option determines a customers default location."></span></label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select class="form-control form-control-modern" name="default_customer_location">
                                            <option value="">No location by default</option>
                                            <option value="base" @if($default_customer_location == 'base') selected @endif>Shop base address</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Enable taxes</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <div class="checkbox">
                                            <label class="mt-2 mb-1">
                                                <input type="hidden" name="enable_tax" value="0" />
                                                <input name="enable_tax" type="checkbox" class="checkbox-style-1" @if($enable_tax) checked @endif value="1">
                                                Enable tax rates and calculations
                                            </label>
                                            <i class="font-weight-light">Rates will be configurable and taxes will be calculated during checkout.</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Enable coupons</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <div class="checkbox mb-3">
                                            <label class="mt-2 mb-1">
                                                <input type="hidden" name="enable_coupon" value="0" />
                                                <input name="enable_coupon" type="checkbox" class="checkbox-style-1" @if($enable_coupon) checked @endif value="1">
                                                Enable the use of coupon codes
                                            </label>
                                            <i class="font-weight-light">Coupons can be applied from the cart and checkout pages.</i>
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
                                <i class="card-big-info-icon bx bx-dollar-circle"></i>
                                <h2 class="card-big-info-title">Currency Option</h2>
                                <p class="card-big-info-desc">Add here the customer account info with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Currency <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="This controls what currency prices are listed at in the catalog and which currency gateways will take payments in."></span></label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select data-plugin-selectTwo class="form-control form-control-modern" name="currency" data-plugin-options='{ "placeholder": "Choose currency" }'>
                                            @foreach(Config::get('constant.currencies') as $currency_key => $currency_name)
                                                @if(array_key_exists($currency_key, Config::get('constant.currency_symbols')))
                                                    <option value="{{ $currency_key }}" @if($currency == $currency_key) selected @endif>{!! $currency_name !!} - ({!! Config::get('constant.currency_symbols')[$currency_key] !!})</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Currency Position <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="This controls the position of the currency symbol."></span></label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select class="form-control form-control-modern" name="currency_position">
                                            <option value="left" @if($currency_position == 'left') selected @endif>Left</option>
                                            <option value="right" @if($currency_position == 'right') selected @endif>Right</option>
                                            <option value="left_space" @if($currency_position == 'left_space') selected @endif>Left with space</option>
                                            <option value="right_space" @if($currency_position == 'right_space') selected @endif>Right with space</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Thousand separator <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="This sets the thousand separator of displayed prices."></span></label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="10" class="form-control form-control-modern" name="thousand_separator" value="{{ $thousand_separator }}" required />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Deciaml separator <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="This sets the decimal separator of displayed prices."></span></label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="10" class="form-control form-control-modern" name="decimal_separator" value="{{ $decimal_separator }}" required />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Number of decimal <span class="porto-help-tip" data-toggle="tooltip" title="" data-original-title="This sets the number of decimal points shown in displayed prices."></span></label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="number" class="form-control form-control-modern" min="0" max="5" name="number_of_decimal" value="{{ $number_of_decimal }}" required />
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
        </div>
    </form>
    <!-- end: page -->
@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/ecommerce/settings/general.min.js') }}"></script>
@endsection


