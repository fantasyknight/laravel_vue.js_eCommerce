@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Stripe Edit', 'paths' => ['home' => '/dashboard', 'eCommerce' => '/ecommerce', 'settings' => '/ecommerce/settings']])

    <!-- start: page -->
    <form class="ecommerce-form " action="{{ url('admin/ecommerce/settings/payment/1') }}" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-money"></i>
                                <h2 class="card-big-info-title">Stripe</h2>
                                <p class="card-big-info-desc">Add stripe info with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Environment</label>
                                    <div class="col-lg-7 col-xl-6 d-flex">
                                        <div class="radio-custom radio-primary mb-0">
                                            <input id="sandbox" name="environment" type="radio" value="test" @if(! isset($environment) || (isset($environment) && $environment == 'test')) checked @endif>
                                            <label for="sandbox">Sandbox</label>
                                        </div>
                                        <div class="radio-custom radio-primary ml-5 mb-0">
                                            <input id="live" name="environment" type="radio" value="live" @if(isset($environment) && $environment == 'live') checked @endif>
                                            <label for="live">Live</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Secret Key</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" class="form-control form-control-modern" name="secret_key" @if(isset($secret_key)) value="{{ $secret_key }}" @endif required />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Publishable Key</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" class="form-control form-control-modern" name="publishable_key" @if(isset($publishable_key)) value="{{ $publishable_key }}" @endif required />
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
                    <i class="bx bx-save text-4 mr-2"></i> Save Payment
                </button>
            </div>
            <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                <a href="{{ url('admin/ecommerce/settings/payment') }}" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark line-height-1 d-flex h-100 align-items-center">Back</a>
            </div>
        </div>
    </form>
    <!-- end: page -->
    @push('scripts')
        <script>
            $(document).ready(function () {
                $("input[name='environment']").change(function(e) {
                    $("input[name='secret_key'], input[name='publishable_key']").val("");
                })
            });
        </script>
    @endpush
@endsection