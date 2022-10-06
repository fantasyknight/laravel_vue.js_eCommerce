@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Tax Rate Create', 'paths' => ['home' => '/dashboard', 'eCommerce' => '/ecommerce', 'settings' => '/ecommerce/settings']])

    <!-- start: page -->
    <div class="row">
        <div class="col">
            <form class="ecommerce-setting-form pb-5" action="{{ url('admin/ecommerce/settings/tax') }}" method="post">
                @csrf
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-cog"></i>
                                <h2 class="card-big-info-title">General</h2>
                                <p class="card-big-info-desc">Add here the tax rate info with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Class Name</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="50" class="form-control form-control-modern" name="name" value="{{ old('name') }}" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Description</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <textarea class="form-control form-control-modern" rows="6" name="description">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </section>
            </form>
        </div>
    </div>
    <!-- end: page -->
@endsection