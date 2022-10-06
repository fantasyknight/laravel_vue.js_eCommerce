@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Withdraw', 'paths' => ['home' => '/dashboard', 'eCommerce' => '/ecommerce']])

    <div class="row">
        <div class="col">
            <form id="posts-list-form" class="ecommerce-form" method="get">
                <div class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-store"></i>
                                <h2 class="card-big-info-title">Withdraw Info</h2>
                                <p class="card-big-info-desc">Shows vendor withdraw information.</p>
                            </div>
                            <div class="col-xl-3-5 col-lg-3-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">
                                        Current Balance
                                    </label>
                                    <div class="col-lg-7 col-xl-9">
                                        ${{ $balance }}
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">
                                        Minimum Withdraw Amount
                                    </label>
                                    <div class="col-lg-7 col-xl-9">
                                        ${{ config('setting.withdraw_minimum_limit') }}
                                    </div>
                                </div>
                                @if (! $can_add)
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">
                                            Info
                                        </label>
                                        <div class="col-lg-7 col-xl-9">
                                            <div class="withdraw-notice">
                                                <p class="mb-0">You already have pending withdraw request(s). <br />
                                                    Please submit your request after approval or cancellation of your previous request.</p>
                                            
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-lg-center mb-3">
                                    <div class="col-xl-auto mb-2 mt-1 mb-xl-0">
                                        @if ($can_add)
                                            <a href="#add-withdraw" class="modal-sizes btn btn-primary btn-md font-weight-semibold">+ Add withdraw</a>
                                        @endif
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
                                            <th>Amount</th>
                                            <th>Payment Method</th>
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
                                                        {{ $withdraw->amount }}
                                                        <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                    </td>
                                                    <td data-column="Method">
                                                        {{ $withdraw->payment_method }}
                                                    </td>
                                                    <td data-column="Date">{{ $withdraw->updated_at }}</td>
                                                    <td data-column="Status" class="ecommerce-status {{ $withdraw->status }}">{{ $withdraw->status }}</td>
                                                    <td data-column="Actions">
                                                        @if ($withdraw->status == 'processing')
                                                            <a href="#" data-id="{{ $withdraw->id }}" class="cancel-withdraw">Cancel</a>
                                                        @endif
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

    <div id="add-withdraw" class="modal-block modal-block-lg mfp-hide">
        <form action="{{ url('admin/ecommerce/vendor-withdraw/add') }}" method="POST" id="add-withdraw-form">
            <section class="card">
                <header class="card-header">
                    <h2 class="card-title">Are you sure?</h2>
                </header>
                <div class="card-body">
                    <div class="modal-wrapper">
                        <div class="form-group row">
                            <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-0">Withdraw Amount<span class="porto-help-tip" data-toggle="tooltip" title="Enter name for this tax rate"></span></label>
                            <div class="col-lg-7 col-xl-6">
                                <input type="text" maxlength="20" class="form-control form-control-modern" required id="add-amount">
                            </div>
                        </div>
                    </div>
                    <div class="modal-wrapper">
                        <div class="form-group row">
                            <label class="col-lg-5 col-xl-3 mt-1 text-right">Payment Method <span class="porto-help-tip" data-toggle="tooltip" title="Enter name for this tax rate"></span></label>
                            <div class="col-lg-7 col-xl-6">
                                <strong>Paypal</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="card-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary modal-confirm" type="submit">Save</button>
                            <button class="btn btn-default modal-dismiss" type="button">Cancel</button>
                        </div>
                    </div>
                </footer>
            </section>
        </form>
    </div>
@endsection

@section('vendor-js')
@endsection

@section('page-js')
    <script src="{{ asset('server/js/ecommerce/vendor/withdraw.min.js') }}"></script>
@endsection