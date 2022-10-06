@extends('admin.layout')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('vendor/magnific-popup/magnific-popup.css') }}" />
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'All Products', 'paths' => ['home' => '/dashboard']])

    <!-- start: page -->
    <div class="card card-modern">
        <div class="card-body">
            <form method="GET">
                <div class="datatables-header-footer-wrapper overflow-lg-auto overflow-xl-unset">
                    <div class="datatable-header">
                        <div class="row align-items-lg-center mb-3">
                            <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                <a href="{{ url('/admin/products/create') }}" class="btn btn-primary btn-md font-weight-semibold">+ Add Product</a>
                            </div>
                            <div class="col-8 col-lg-auto ml-lg-auto mb-3 mb-lg-0">
                                <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                    <label class="ws-nowrap mr-3 mb-0">Filter By:</label>
                                    <select class="form-control select-style-1 filter-by my-1 mr-2 w-lg-auto" name="filter-category">
                                        <option value="*">All Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('filter-category') == $cat->id ? 'selected' : '' }}>{!! $cat->name !!}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-control select-style-1 filter-by my-1 mr-2" name="filter-type">
                                        <option value="*" {{ old('filter-type') == '*' ? 'selected' : '' }}>All Type</option>
                                        <option value="simple" {{ old('filter-type') == 'simple' ? 'selected' : '' }}>Simple</option>
                                        <option value="variable" {{ old('filter-type') == 'variable' ? 'selected' : '' }}>Variable</option>
                                    </select>
                                    <select class="form-control select-style-1 filter-by my-1 mr-2" name="filter-stock">
                                        <option value="*">All Stock</option>
                                        <option value="in-stock" {{ old('filter-stock') == 'in-stock' ? 'selected' : '' }}>In Stock</option>
                                        <option value="out-of-stock" {{ old('filter-stock') == 'out-of-stock' ? 'selected' : '' }}>Out of Stock</option>
                                        <option value="on-backorder" {{ old('filter-stock') == 'on-backorder' ? 'selected' : '' }}>On backorder</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary filter-btn my-1">Filter</button>
                                </div>
                            </div>
                            <div class="col-12 col-lg-auto">
                                <div class="search search-style-1 mx-lg-auto my-1">
                                    <div class="input-group">
                                        <input type="text" class="search-term form-control" name="search-term" id="search-term" value="{{ old('search-term') }}" placeholder="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-ecommerce-simple table-products table-striped mb-0" id="datatable-ecommerce-list" style="min-width: 1475px">
                            <thead>
                                <tr>
                                    <th width="30"><input type="checkbox" name="select-all" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                    <th width="20%" >@sortablelink('name', 'Name')</th>
                                    <th>@sortablelink('sku', 'SKU')</th>
                                    <th>@sortablelink('stock_status', 'Stock')</th>
                                    <th>Price</th>
                                    <th style="width: 20%">Categories</th>
                                    <th>Tags</th>
                                    <th style="width: 7%">@sortablelink('featured', 'Featured')</th>
                                    <th>@sortablelink('created_at', 'Date')</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="checkbox-style-1 p-relative" value="1" data-id="{{ $product->id }}" />
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ url('/admin/products/') }}/{{ $product->id }}/edit" class="product-img mr-1">
                                                    @if(count($product->media) > 0)
                                                        <img src="{{ asset('storage') }}/{{ Str::replaceLast('.', '-100x100.', $product->media[0]->copy_link) }}" alt="Product" width="60" height="60" />
                                                    @else
                                                        <img src="{{ asset('server/images/porto-placeholder-66x66.png') }}" alt="Product" width="60" height="60" />
                                                    @endif
                                                </a>
                                                <a href="{{ url('/admin/products/') }}/{{ $product->id }}/edit">{{ $product->name }}</a>
                                                <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                            </div>
                                        </td>
                                        <td data-column="SKU"># {{ $product->sku }}</td>
                                        <td data-column="Stock">
                                            {{ $product->stock_status }}
                                            @if($product->stock_status != 'in-stock')
                                                ({{ $product->stock_quantity }})
                                            @endif
                                        </td>
                                        <td data-column="Price">
                                            @if($product->min_max_price[0] == $product->min_max_price[1])
                                                {!! Helper::portoFormattedPrice($product->min_max_price[0]) !!}
                                            @else
                                                @if($product->type == 'simple')
                                                    <div class="product-price"> 
                                                        <div class="regular-price on-sale">{!! Helper::portoFormattedPrice($product->min_max_price[1]) !!}</div>
                                                        <div class="sale-price">{!! Helper::portoFormattedPrice($product->min_max_price[0]) !!}</div>
                                                    </div>
                                                @else 
                                                    {!! Helper::portoFormattedPrice($product->min_max_price[0]) !!} - {!! Helper::portoFormattedPrice($product->min_max_price[1]) !!}
                                                @endif
                                            @endif
                                        </td>
                                        <td data-column="Categories">
                                            @foreach($product->categories as $category)
                                                @if($loop->last)
                                                    {{ $category->name }}
                                                @else
                                                    {{ $category->name }},
                                                @endif
                                            @endforeach
                                        </td>
                                        <td data-column="Tags">
                                            @foreach($product->tags as $tag)
                                                @if($loop->last)
                                                    {{ $tag->name }}
                                                @else
                                                    {{ $tag->name }},
                                                @endif
                                            @endforeach
                                        </td>
                                        <td data-column="Featured">
                                            <a href="javascript:;">
                                                @cannot('vendor-role')
                                                    @if($product->featured)
                                                        <i class="fas fa-star" data-id="{{ $product->id }}"></i>
                                                    @else
                                                        <i class="far fa-star" data-id="{{ $product->id }}"></i>
                                                    @endif
                                                @else
                                                    @if($product->featured)
                                                        <i class="fas fa-star vendor" data-id="{{ $product->id }}"></i>
                                                    @else
                                                        <i class="far fa-star vendor" data-id="{{ $product->id }}"></i>
                                                    @endif
                                                @endcannot
                                            </a>
                                        </td>
                                        <td data-column="Date">{{ $product->created_at }}</td>
                                        <td class="actions" data-column="Actions">
                                            <a href="{{ url('admin/products/' . $product->id . '/edit') }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="javscript:;" class="on-default remove-row"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No posts available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <hr class="solid mt-5 opacity-4">
                    <div class="datatable-footer">
                        <div class="row align-items-center justify-content-between mt-3">
                            <div class="col-sm-auto order-1 mb-3 mb-lg-0">
                                <div class="d-flex align-items-stretch">
                                    <select class="form-control select-style-1 bulk-action mr-3" style="min-width: 120px;">
                                        <option value="" selected>Bulk Actions</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                    <a href="javscript:;" class="bulk-action-apply btn btn-light border font-weight-semibold text-color-dark text-3">Apply</a>
                                </div>
                            </div>
                            <div class="col-lg-auto text-center order-3 order-lg-2">
                                <div class="results-info-wrapper"></div>
                            </div>
                            <div class="col-lg-auto order-2 order-lg-3 mb-3 mb-lg-0">
                                <div class="pagination-wrapper d-flex justify-content-end">
                                    {!! $products->appends(\Request::except('page'))->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end: page -->
    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/products/list.min.js') }}"></script>
@endsection