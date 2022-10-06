@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Users', 'paths' => ['home' => '/dashboard', 'users' => '/users' ]])

    <div class="row">
        <div class="col">
            <form id="users-list-form" method="get">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-3">
                                    <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                        <a href="{{ url('/admin/users/create') }}" class="btn btn-primary btn-md font-weight-semibold">+ Add User</a>
                                    </div>
                                    <div class="col-8 col-lg-auto ml-lg-auto mb-3 mb-lg-0">
                                        <div class="d-flex align-items-lg-center flex-wrap">
                                            <label class="d-none d-xl-block ws-nowrap mr-3 mb-0">Filter By:</label>
                                            <select class="form-control select-style-1 filter-by w-auto my-1 mr-2" name="filter-by">
                                                <option value="*" {{ old('filter-by') == '*' ? 'selected' : '' }}>All</option>
                                                <option value="4" {{ old('filter-by') == '4' ? 'selected' : '' }}>Vendor</option>
                                                <option value="2" {{ old('filter-by') == '2' ? 'selected' : '' }}>Customer</option>
                                                <option value="7" {{ old('filter-by') == '7' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary filter-btn my-1">Filter</button>
                                        </div>
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
                                            <th>@sortablelink('email', 'E-mail')</th>
                                            <th>Role</th>
                                            <th>@sortablelink('posts_count', 'Posts')</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>
                                                    @if(Auth::id() != $user->id)
                                                    <input type="checkbox" class="checkbox-style-1 p-relative" data-id="{{ $user->id }}" />
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url('admin/users/' . $user->id . '/edit') }}"><strong>{{ ( $user->first_name . ' ' . $user->last_name ) ?: 'unnamed' }}</strong></a>
                                                    <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                </td>
                                                <td data-column="E-mail">{{ $user->email }}</td>
                                                <td data-column="Role">{{ $user->role->name }}</td>
                                                <td data-column="Posts"><a href="{{ action('Admin\PostController@index', ['author' => $user->id]) }}">{{ $user->posts_count }}</a></td>
                                                <td data-column="Status"><span class="ecommerce-status active">Active</span></td>
                                                <td class="actions" data-column="Actions">
                                                    <a href="{{ url('admin/users/' . $user->id . '/edit') }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                                    @if(Auth::id() != $user->id )
                                                    <a href="javscript:;" class="on-default remove-row"><i class="far fa-trash-alt"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr class="solid mt-5 opacity-4">
                            <div class="datatable-footer">
                                <div class="row align-items-center justify-content-between mt-3">
                                    <div class="col-md-auto order-1 mb-3 mb-lg-0">
                                        <div class="d-flex align-items-stretch">
                                            <select class="form-control select-style-1 bulk-action w-auto mr-3">
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
                                        {!! $users->appends(\Request::except('page'))->render() !!}
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
    <script src="{{ asset('server/js/users/list.min.js') }}"></script>
@endsection