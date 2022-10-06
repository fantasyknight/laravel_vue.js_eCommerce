@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Withdraw', 'paths' => ['home' => '/dashboard', 'withdraw' => '/multivendor/withdraw']])

    <div class="row">
        <div class="col">
            <form id="posts-list-form" class="ecommerce-form" method="get">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-lg-center mb-3">
                                    <div class="col-xl-auto mb-2 mt-1 mb-xl-0">
                                        <a href="#add-withdraw" class="modal-sizes btn btn-primary btn-md font-weight-semibold">+ Add withdraw</a>
                                    </div>
                                    <div class="col-lg-auto mb-2 mb-lg-0 ml-xl-auto pl-xl-1">
                                        <div class="d-flex align-items-lg-center flex-wrap">
                                            <label class="d-none d-xl-block ws-nowrap mr-3 mb-0">Filter By:</label>
                                            <select class="form-control select-style-1 filter-by w-auto my-1 mr-2" name="filter-by">
                                                <option value="*" {{ old('filter-by') == '*' ? 'selected' : '' }}>All</option>
                                                <option value="approved" {{ old('filter-by') == 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="cancelled" {{ old('filter-by') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                <option value="processing" {{ old('filter-by') == 'processing' ? 'selected' : '' }}>Processing</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary filter-btn my-1">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-ecommerce-simple table-posts table-striped table-responsive-lg mb-0" id="datatable-ecommerce-list">
                                    <thead>
                                        <tr>
                                            <th width="30"><input type="checkbox" name="select-all" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                            <th>User Name</th>
                                            <th>Amount</th>
                                            <th>Paypal Email</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($withdraws->isNotEmpty())
                                            @foreach($withdraws as $withdraw)
                                                <tr>
                                                    <td><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative" value="" data-id="{{ $withdraw->id }}" /></td>
                                                    <td>
                                                        {{ $withdraw->user->first_name }} {{ $withdraw->user->last_name }}
                                                        <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                    </td>
                                                    <td>
                                                        {{ $withdraw->amount }}
                                                    </td>
                                                    <td data-column="Paypal Email">
                                                        {{ $withdraw->user->vendor->paypal_email }}
                                                    </td>
                                                    <td data-column="Date">{{ $withdraw->updated_at }}</td>
                                                    <td data-column="Status" class="ecommerce-status {{ $withdraw->status }}">{{ $withdraw->status }}</td>
                                                    <td data-column="Actions">
                                                        @if ($withdraw->status == 'processing')
                                                            <a href="#" class="on-default cancel-withdraw mr-1" data-title="cancel" data-id="{{ $withdraw->id }}" title="Cancel"><i class="fas fa-reply"></i></a>
                                                            <a href="#" data-id="{{ $withdraw->id }}" class="on-default approve-withdraw mr-1" data-title="approve" title="Approve"><i class="fas fa-check"></i></a>
                                                        @endif
                                                        <a href="#" class="on-default remove-withdraw" data-id="{{ $withdraw->id }}" data-title="delete" title="Remove"><i class="far fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else 
                                            <tr>
                                                <td colspan="9" class="text-center">No withdraws available.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <hr class="solid mt-5 opacity-4">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('vendor-js')
@endsection

@section('page-js')
    <script src="{{ asset('server/js/multivendor/withdraw.min.js') }}"></script>
@endsection