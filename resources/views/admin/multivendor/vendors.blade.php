@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Vendors', 'paths' => ['home' => '/dashboard', 'vendors' => '/multivendor/vendor' ]])

    <div class="row">
        <div class="col">
            <form id="users-list-form" method="get">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-3">
                                    <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                        <a href="{{ url('/admin/users/create') }}" class="btn btn-primary btn-md font-weight-semibold">+ Add Vendor</a>
                                    </div>
                                    <div class="col-8 col-lg-auto ml-lg-auto mb-3 mb-lg-0">
                                    </div>
                                    <div class="col-12 col-lg-auto">
                                        <div class="search search-style-1 mx-lg-auto w-auto">
                                            <div class="input-group">
                                                <input type="text" maxlength="20" class="search-term form-control" name="search-term" id="search-term" placeholder="Search" value="{{ old('search-term') }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list">
                                    <thead>
                                        <tr>
                                            <th width="30"><input type="checkbox" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                            <th>@sortablelink('first_name', 'Name')</th>
                                            <th>Store</th>
                                            <th>Paypal Email</th>
                                            <th>Phone</th>
                                            <th>Balance</th>
                                            <th>Featured</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($vendors as $user)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="checkbox-style-1 p-relative" data-id="{{ $user->id }}" />
                                                </td>
                                                <td>
                                                    <a href="{{ url('admin/ecommerce/vendor-setting/' . $user->id) }}"><strong>{{ $user->first_name . ' ' . $user->last_name }}</strong></a>
                                                    <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                </td>
                                                <td data-column="store">{{ $user->vendor->store_name }}</td>
                                                <td data-column="Paypal Email">{{ $user->vendor->paypal_email }}</td>
                                                <td data-column="Phone">{{ $user->vendor->phone }}</td>
                                                <td data-column="Balance">{{ $user->vendor->balance }}</td>
                                                <td data-column="Featured">
                                                    <div class="switch switch-sm switch-primary">
                                                        <input type="checkbox" class="vendor-featured" data-id="{{ $user->vendor->id }}" data-plugin-ios-switch {{ $user->vendor->featured == true ? 'checked' : ''}} />
                                                    </div>
                                                </td>
                                                <td data-column="Status">
                                                    <div class="switch switch-sm switch-primary">
                                                        <input type="checkbox" class="vendor-status" data-id="{{ $user->vendor->id }}" data-plugin-ios-switch {{ $user->vendor->status == true ? 'checked' : ''}} />
                                                    </div>
                                                </td>
                                                <td class="actions" data-column="Actions">
                                                    <a href="{{ url('admin/ecommerce/vendor-setting/' . $user->id) }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="javscript:;" class="on-default remove-row"><i class="far fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No vendors available.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <hr class="solid mt-5 opacity-4">
                            <div class="datatable-footer">
                                <div class="row align-items-center justify-content-between mt-3">
                                    <div class="col-md-auto order-1 mb-3 mb-lg-0">
                                        <div class="d-flex align-items-stretch">
                                            <select class="form-control select-style-1 bulk-action mr-3" style="min-width: 120px;">
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
                                        {!! $vendors->appends(\Request::except('page'))->render() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/ios7-switch/ios7-switch.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/multivendor/vendors.min.js') }}"></script>
@endsection