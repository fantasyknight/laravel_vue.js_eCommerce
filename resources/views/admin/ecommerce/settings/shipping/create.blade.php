@extends('admin.layout')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Shipping Zone Create', 'paths' => ['home' => '/dashboard', 'eCommerce' => '/ecommerce', 'settings' => '/ecommerce/settings']])

    <!-- start: page -->
    <form class="ecommerce-setting-form pb-5" action="{{ url('admin/ecommerce/settings/shipping') }}" method="post">
        @csrf
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-car"></i>
                                <h2 class="card-big-info-title">Shipping</h2>
                                <p class="card-big-info-desc">Add here the customer billing info with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Zone name</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="50" class="form-control form-control-modern" name="name" value="" required />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Region(s)</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select data-plugin-selectTwo multiple class="form-control populate" name="code[]" data-plugin-options='{ "placeholder": "Choose continents / countries / states" }'>
                                            @foreach(Config::get('constant.continents') as $continent_code => $continents)
                                                @if(!count(array_intersect(array_keys(Helper::getShippableCountries()), $continents['countries'])))
                                                    @continue
                                                @endif
                                                <option value="continent:{{ $continent_code }}">{{ $continents['name'] }}</option>

                                                @foreach ($continents['countries'] as $country_code )
                                                    @if(!array_key_exists($country_code, Helper::getShippableCountries()))
                                                        @continue
                                                    @endif
                                                    @if(array_key_exists($country_code, Config::get('constant.states')) && count(Config::get('constant.states')[$country_code]) != 0)
                                                        <option value="country:{{ $country_code }}">&nbsp;&nbsp;{!! Config::get('constant.countries')[$country_code] !!}</option>

                                                        @foreach (Config::get('constant.states')[$country_code] as $state_code => $state_name )
                                                            <option value="state:{{ $country_code }}:{{ $state_code }}">&nbsp;&nbsp;&nbsp;&nbsp;{!! $state_name !!}, {!! Config::get('constant.countries')[$country_code] !!}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="country:{{ $country_code }}">&nbsp;&nbsp;{!! Config::get('constant.countries')[$country_code] !!}</option>
                                                    @endif
                                                @endforeach
                                            @endforeach
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
                    <i class="bx bx-save text-4 mr-2"></i> Save Zone
                </button>
            </div>
            <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                <a href="{{ url('/admin/ecommerce/settings/shipping') }}" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark line-height-1 d-flex h-100 align-items-center">Back</a>
            </div>
        </div>
    </form>
    <!-- end: page -->
@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/ecommerce/settings/shipping.min.js') }}"></script>
@endsection