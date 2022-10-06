@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar', ['active' => [3, 4, 4]])
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Tax Rate Edit', 'paths' => ['home' => '/dashboard', 'eCommerce' => '/ecommerce', 'settings' => '/ecommerce/settings']])

    <!-- start: page -->
    <div class="row">
        <div class="col">
            <form class="ecommerce-setting-form pb-5" action="{{ url('admin/ecommerce/settings/tax') }}/{{ $tax_type->id }}" method="post">
                @method('PUT')
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
                                        <input type="text" maxlength="50" class="form-control form-control-modern" name="name" value="{{ $tax_type->name }}" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Description</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <textarea class="form-control form-control-modern" rows="6" maxlength="250" name="description">{{ $tax_type->description }}</textarea>
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
    <div class="row">
        <div class="col">
            <form action="{{ url('/admin/ecommerce/settings/tax/') }}/{{ $tax_type->id }}/edit" class="ecommerce-tax-rate-form" method="get">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-3">
                                    <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                        <a href="#taxModal" class="btn btn-primary btn-md modal-add font-weight-semibold">+ Add Tax</a>
                                    </div>
                                    <div class="col-8 col-lg-auto ml-auto mb-3 mb-lg-0">
                                        <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                            <label class="ws-nowrap mr-3 mb-0">Filter By:</label>
                                            <select class="form-control select-style-1 filter-by" name="filter-by">
                                                <option value="*" @if(old('filter-by') == '*') selected @endif>All</option>
                                                <option value="name" @if(old('filter-by') == 'name') selected @endif>Name</option>
                                                <option value="country" @if(old('filter-by') == 'country') selected @endif>Country Code</option>
                                                <option value="state" @if(old('filter-by') == 'state') selected @endif>State Code</option>
                                                <option value="postcode" @if(old('filter-by') == 'postcode') selected @endif>Post Code / ZIP</option>
                                                <option value="city" @if(old('filter-by') == 'city') selected @endif>City</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-auto pl-lg-1">
                                        <div class="search search-style-1 mx-lg-auto">
                                            <div class="input-group">
                                                <input type="text" maxlength="20" class="search-term form-control" name="search-term" id="search-term" value="{{ old('search-term') }}" placeholder="Search Tax Rate">
                                                <div class="input-group-append">
                                                    <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list" style="min-width: 900px">
                                    <thead>
                                        <tr>
                                            <th width="30"><input type="checkbox" name="select-all" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                            <th width="15%">@sortablelink('name', 'Tax Name')</th>
                                            <th>@sortablelink('country', 'Country Code')</th>
                                            <th>@sortablelink('state', 'State Code')</th>
                                            <th>@sortablelink('postcode', 'Post Code / ZIP')</th>
                                            <th>@sortablelink('city', 'City')</th>
                                            <th>Rate (%)</th>
                                            <th>Shipping</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tax_rates as $tax_rate)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="checkbox-style-1 p-relative" value="" data-id="{{ $tax_rate->id }}" />
                                                </td>
                                                <td data-column="Tax Name">{{ $tax_rate->name }}<a href="javascript:;" class="slide-content d-block d-lg-none"></a></td>
                                                <td data-column="Country Code">{{ $tax_rate->country ?: '*' }}</td>
                                                <td data-column="State Code">{{ $tax_rate->state ?: '*' }}</td>
                                                <td data-column="Post Code / ZIP">{{ $tax_rate->postcode ?: '*' }}</td>
                                                <td data-column="City">{{ $tax_rate->city ?: '*' }}</td>
                                                <td data-column="Rate (%)">{{ $tax_rate->rate }}</td>
                                                <td data-column="Shipping">{{$tax_rate->is_shipping ? 'Enabled' : 'Disabled' }}</td>
                                                <td class="actions" data-column="actions">
                                                    <a href="#taxModal" class="modal-sizes edit-tax-rate" data-id="{{ $tax_rate->id }}"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="#" class="remove-tax-rate remove-row" data-id="{{ $tax_rate->id }}"><i class="fas fa-trash-alt"></i></a>                                                        
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
                                            <select class="form-control select-style-1 bulk-action mr-3">
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
                                        <div class="pagination-wrapper d-flex justify-content-end">
                                            {!! $tax_rates->appends(\Request::except('page'))->render() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row action-buttons">
        <div class="col-12 col-md-auto">
            <a href="{{ url('/admin/ecommerce/settings/tax') }}" class="btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                <i class="bx bx-arrow-back text-4 mr-2"></i> Back
            </a>
        </div>
        <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
        </div>
    </div>
    <div id="taxModal" class="modal-block modal-block-lg mfp-hide">
        <form action="#" method="GET" id="tax-rate-add-form" data-id="{{ $tax_type->id }}">
            <section class="card">
                <header class="card-header">
                    <h2 class="card-title">Are you sure?</h2>
                </header>
                <div class="card-body">
                    <div class="modal-wrapper">
                        <div class="form-group row">
                            <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-0">Tax Name <span class="porto-help-tip" data-toggle="tooltip" title="Enter name for this tax rate"></span></label>
                            <div class="col-lg-7 col-xl-6">
                                <input type="text" maxlength="20" class="form-control form-control-modern" required id="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-0">Country Code <span class="porto-help-tip" data-toggle="tooltip" title="A 2 digit country code, e.g. US."></span></label>
                            <div class="col-lg-7 col-xl-6">
                                <input type="text" maxlength="20" class="form-control form-control-modern" name="country" id="country">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-0">State Code <span class="porto-help-tip" data-toggle="tooltip" title="A 2 digit state code, e.g. AL. Leave blank to apply to all."></span></label>
                            <div class="col-lg-7 col-xl-6">
                                <input type="text" maxlength="20" class="form-control form-control-modern" name="state" id="state">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-0">Post Code / ZIP <span class="porto-help-tip" data-toggle="tooltip" title="Postcode for this rule. Leave blank to apply to all areas."></span></label>
                            <div class="col-lg-7 col-xl-6">
                                <input type="text" maxlength="20" class="form-control form-control-modern" id="postcode">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-0">City <span class="porto-help-tip" data-toggle="tooltip" title="Cities for this rule. Leave blank to apply to all cities."></span></label>
                            <div class="col-lg-7 col-xl-6">
                                <input type="text" maxlength="20" class="form-control form-control-modern" id="city">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-0">Rate (%) <span class="porto-help-tip" data-toggle="tooltip" title="Enter a tax rate (percentage)"></span></label>
                            <div class="col-lg-7 col-xl-6">
                                <input type="text" maxlength="20" class="form-control form-control-modern" required id="rate">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-0">Apply to Shipping <span class="porto-help-tip" data-toggle="tooltip" title="Choose whether or not this tax rate also gets applied to shipping."></span></label>
                            <div class="col-lg-7 col-xl-6">
                                <div class="checkbox-custom checkbox-default mt-1 pt-3">
                                    <input type="checkbox" name="is_shipping" value="1" id="is_shipping">
                                    <label for="is_shipping"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="card-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary" type="submit">Save</button>
                            <button class="btn btn-default modal-dismiss" type="button">Cancel</button>
                        </div>
                    </div>
                </footer>
            </section>
        </form>
    </div>
    <!-- end: page -->
    @include('admin.common.modals.delete-confirm')
@endsection

@section('page-js')
    <script src="{{ asset('server/js/ecommerce/settings/tax_rate.min.js') }}"></script>
@endsection