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
    <form class="ecommerce-setting-form pb-5" action="{{ url('admin/ecommerce/settings/shipping') }}/{{ $shipping_zone->id }}" method="post" data-zone-id="{{ $shipping_zone->id }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-1-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-car"></i>
                                <h2 class="card-big-info-title">Shipping</h2>
                                <p class="card-big-info-desc">Add here the shipping zone info with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-4-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-3 col-xl-3 control-label text-lg-right mb-0">Zone name <span class="porto-help-tip" data-toggle="tooltip" title="Name of the zone for your reference"></span></label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input type="text" class="form-control form-control-modern" name="name" value="{{ $shipping_zone->name }}" required />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-3 col-xl-3 control-label text-lg-right mb-0">Region(s) <span class="porto-help-tip" data-toggle="tooltip" title="Names of the regions inside zone."></span></label>
                                    <div class="col-lg-9 col-xl-6">
                                        <select data-plugin-selectTwo multiple class="form-control populate" name="code[]" data-plugin-options='{ "placeholder": "Choose continents / countries / states" }'>
                                            @foreach(Config::get('constant.continents') as $continent_code => $continents)
                                                @php 
                                                    $codes = $shipping_zone->shippingLocations->pluck('code')->toArray();
                                                @endphp
                                                <option value="continent:{{ $continent_code }}" @if(in_array('continent:' . $continent_code, $codes)) selected @endif>{{ $continents['name'] }}</option>

                                                @foreach ($continents['countries'] as $country_code )
                                                    @if(array_key_exists($country_code, Config::get('constant.states')) && count(Config::get('constant.states')[$country_code]) != 0)
                                                        <option value="country:{{ $country_code }}" @if(in_array('country:' . $country_code, $codes)) selected @endif>&nbsp;&nbsp;{!! Config::get('constant.countries')[$country_code] !!}</option>

                                                        @foreach (Config::get('constant.states')[$country_code] as $state_code => $state_name )
                                                            <option value="state:{{ $country_code }}:{{ $state_code }}" @if(in_array('state:' . $country_code . ':' . $state_code, $codes)) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;{!! $state_name !!}, {!! Config::get('constant.countries')[$country_code] !!}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="country:{{ $country_code }}" @if(in_array('country:' . $country_code, $codes)) selected @endif>&nbsp;&nbsp;{!! Config::get('constant.countries')[$country_code] !!}</option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row mb-3">
                                        <label class="col-lg-3 col-xl-3 control-label text-lg-right mb-0 pt-2">Shipping Methods <span class="porto-help-tip" data-toggle="tooltip" title="Shipping methods which will be applied to customers with shipping address within this zone."></span></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <table class="table table-shipping-methods">
                                                <thead>
                                                    <tr>
                                                        <th width="35%">Title</th>
                                                        <th>Enabled</th>
                                                        <th width="50%">Description</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($shipping_zone->shippingZoneMethods as $method)
                                                        <tr data-id="{{ $method->id }}">
                                                            <td><a href="#" class="btn btn-link method-link">{{ $method->name }}</a></td>
                                                            <td>
                                                                <div class="switch switch-sm switch-primary">
                                                                    <input type="checkbox" name="switch" data-plugin-ios-switch {{ $method->enabled == true ? 'checked' : ''}} />
                                                                </div>
                                                                <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                            </td>
                                                            <td data-column="Description">{{ $method->description }}</td>
                                                            <td data-column="Action" class="actions"><a href="javascript:;" class="remove-shipping-method"><i class="far fa-trash-alt"></i></a></td>
                                                        </tr>
                                                    @empty
                                                        <tr class="no-method">
                                                            <td colspan="4" class="pt-4 pb-4">
                                                                You can add multiple shipping methods within this zone. Only customers within the zone will see them.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="4">
                                                            <div class="input-group add-shipping-method">
                                                                <select class="form-control form-control-modern w-auto method-add-select" title="Please select at least one state" required>
                                                                    <option value="free">Free Shipping</option>
                                                                    <option value="flat">Flat Rate</option>
                                                                    <option value="local">Local Pickup</option>
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <a href="javascript:;" class="btn btn-primary create-shipping-button">Add</a>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
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
            <div class="col-12 col-md-auto">
                <button type="submit" class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-loading-text="Loading...">
                    <i class="bx bx-save text-4 mr-2"></i> Save Zone
                </button>
            </div>
            <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                <a href="{{ url('/admin/ecommerce/settings/shipping') }}" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark line-height-1 d-flex h-100 align-items-center">Back</a>
            </div>
            <div class="col-12 col-md-auto ml-md-auto mt-3 mt-md-0">
                <a href="#" class="delete-zone-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-id="{{ $shipping_zone->id }}">
                    <i class="bx bx-trash text-4 mr-2"></i> Delete Zone
                </a>
            </div>
        </div>
    </form>

    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/ios7-switch/ios7-switch.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/ecommerce/settings/shipping.min.js') }}"></script>
@endsection