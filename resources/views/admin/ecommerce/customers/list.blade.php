@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Customers', 'paths' => ['home' => '/dashboard', 'ecommerce' => '/ecommerce' ]])

    <div class="row">
        <div class="col">
            <form id="users-list-form" method="get">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-3">
                                    <div class="col-auto ml-auto pl-lg-1">
                                        <div class="search search-style-1 mx-lg-auto w-auto">
                                            <div class="input-group">
                                                <input type="text" maxlength="50" class="search-term form-control" name="search-term" id="search-term" placeholder="Search" value="{{ old('search-term') }}">
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
                                            <th width="100">@sortablelink('first_name', 'Name')</th>
                                            <th>Email</th>
                                            <th>@sortablelink('last_active', 'Last Actvie')</th>
                                            <th>@sortablelink('sign_up', 'Sign Up')</th>
                                            <th>@sortablelink('orders_count', 'Orders')</th>
                                            <th>@sortablelink('total_spend', 'Total spend')</th>
                                            <th>@sortablelink('aov', 'AOV')</th>
                                            <th>Country</th>
                                            <th>City</th>
                                            <th>Region</th>
                                            <th>Postal Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customers as $customer)
                                            <tr>
                                                <td>
                                                    @if(! empty($customer->sign_up))
                                                        <a href="{{ url('admin/users/' . $customer->id . '/edit') }}"><strong>{{ $customer->first_name . ' ' . $customer->last_name }}</strong></a>
                                                    @else
                                                        <strong>{{ $customer->first_name . ' ' . $customer->last_name }}</strong>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ 'mailTo:' . $customer->email }}">{{ $customer->email }}</a>
                                                    <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                </td>
                                                <td data-column="Last Active">{{ $customer->last_active ? $customer->last_active->format("F d, Y") : '' }}</td>
                                                <td data-column="Sign Up">{{ $customer->sign_up ? $customer->sign_up->format("F d, Y") : '' }}</td>
                                                <td data-column="Orders">{{ $customer->orders_count ?: 0 }}</td>
                                                <td data-column="Total Spend">{!! Helper::portoFormattedPrice($customer->total_spend) !!}</td>
                                                <td data-column="AOV">{!! Helper::portoFormattedPrice($customer->aov) !!}</td>
                                                <td data-column="Country">
                                                    {{ $customer->billing_country ? Config::get('constant.countries')[$customer->billing_country] : '' }}
                                                </td>
                                                <td data-column="City">{{ $customer->billing_city ?: '' }}</td>
                                                <td data-column="Region">{{ $customer->billing_country && $customer->billing_state ? Config::get('constant.states')[$customer->billing_country][$customer->billing_state] : '' }}</td>
                                                <td data-column="Postal Code">{{ $customer->billing_postcode ?: '' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="11">There are no customers.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <hr class="solid mt-5 opacity-4">
                            <div class="datatable-footer">
                                <div class="row align-items-center justify-content-between mt-3">
                                    <div class="col-lg-auto text-center order-3 order-lg-2">
                                        <div class="results-info-wrapper"></div>
                                    </div>
                                    <div class="col-lg-auto order-2 order-lg-3 mb-3 mb-lg-0">
                                        {!! $customers->appends(\Request::except('page'))->render() !!}
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