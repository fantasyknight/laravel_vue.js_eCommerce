@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Stock', 'paths' => ['home' => '/dashboard', 'ecommerce' => '/ecommerce', 'reports' => '/ecommerce/reports']])

    <div class="row">
        <div class="col">
            <form id="tags-list-form" method="get">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-3">
                                    <div class="col-auto mb-0 mt-1">
                                    </div>
                                    <div class="col col-sm-auto ml-auto pl-lg-1">
                                        <a href="{{ action('Admin\ReportController@stockReport', ['status' => 'low']) }}" class="btn btn-light border {{ ! old('status') || old('status') === 'low' ? 'active' : '' }}">Low in stock</a>
                                        <a href="{{ action('Admin\ReportController@stockReport', ['status' => 'out']) }}" class="btn btn-light border {{ old('status') === 'out' ? 'active' : '' }}">Out of stock</a>
                                        <a href="{{ action('Admin\ReportController@stockReport', ['status' => 'most']) }}" class="btn btn-light border {{ old('status') === 'most' ? 'active' : '' }}">Most stocked</a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list">
                                    <thead>
                                        <tr>
                                            <th width="15%">Product</th>
                                            <th>Parent</th>
                                            <th width="15%">Units in stock</th>
                                            <th width="15%">Stock status</th>
                                            <th width="100">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($products->isNotEmpty())
                                            @foreach($products as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>
                                                        <a href="{{ url('admin/products/') }}/{{ $product->parent == 0 ? $product->id : $product->parent }}{{ '/edit' }}">
                                                            {{ $product->parent == 0 ? '-' : explode('-', $product->name)[0] }}
                                                        </a>
                                                        <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                    </td>
                                                    <td data-column="Units in stock">{{ $product->stock_quantity }}</td>
                                                    <td data-column="Stock status">{{ $product->stock_status }}</td>
                                                    <td class="actions" data-column="Actions">
                                                        <a href="{{ url('admin/products/') }}/{{ $product->parent == 0 ? $product->id : $product->parent }}{{ '/edit' }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No products found</td>
                                            </tr>
                                        @endif
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
                                        {!! $products->appends(\Request::except('page'))->render() !!}
                                    </div>
                                </div>
                            </div>
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
@endsection

