@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Add User', 'paths' => ['home' => '/dashboard', 'Users' => '/users']])
    
    <form class="ecommerce-form " action="{{ url('/admin/users') }}" method="post">
        @csrf
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-user-circle"></i>
                                <h2 class="card-big-info-title">Account Info</h2>
                                <p class="card-big-info-desc">Add here the user account info.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">First Name</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="20" class="form-control form-control-modern" name="first_name" value="" required />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Last Name</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="20" class="form-control form-control-modern" name="last_name" value="" />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Email</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="email" maxlength="30" class="form-control form-control-modern {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="" required />
                                        {{-- @if ($errors->has('email'))
                                            <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                        @endif --}}
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Password</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="password" maxlength="30" class="form-control form-control-modern {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" value="" />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Password Confirm</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="password" maxlength="30" class="form-control form-control-modern" name="password_confirmation" value="" />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Manage Role</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select class="form-control form-control-modern" name="role_id">
                                            <!-- @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach -->
                                            <option value="2" selected>Customer</option>
                                            @if (config('setting.multivendor') == '1')
                                            <option value="4">Vendor</option>
                                            @endif
                                            <option value="7">Administrator</option>
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
                    <i class="bx bx-save text-4 mr-2"></i> Save User
                </button>
            </div>
            <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                <a href="{{ url('/admin/users') }}" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark line-height-1 d-flex h-100 align-items-center">Cancel</a>
            </div>
        </div>
    </form>
@endsection