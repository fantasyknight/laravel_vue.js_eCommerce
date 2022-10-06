@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('custom-css')
<style>
    img {
        object-fit: contain;
    }
</style>
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Gallery List', 'paths' => ['home' => '/dashboard', 'media' => '/media/grid']])

    <!-- start: page -->
    <section class="media-gallery">
        <form action="{{ url('/admin/media/list') }}" method="get" id="media-list-form">
            <div class="inner-body mg-main ml-0">
                <div class="inner-toolbar clearfix">
                    <ul>
                        <li>
                            <a href="{{ url('/admin/media/list') }}" class="active"><i class="fas fa-th-list"></i></a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/media/grid') }}"><i class="fas fa-th-large"></i></a>
                        </li>
                        <li>
                            <a href="#" id="mg-select-all"><i class="fas fa-check-square mr-1"></i> <span data-all-text="Select All" data-none-text="Select None">Select All</span></a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/media/create') }}"><i class="fas fa-upload mr-1"></i> Upload</a>
                        </li>
                        <li>
                            <a href="#" id="mg-delete-all"><i class="far fa-trash-alt mr-1"></i> Delete</a>
                        </li>
                        <li class="right d-flex align-items-center">
                            <label class="ws-nowrap mr-3 mb-0">Filter:</label>
                            <select class="form-control form-control-sm select-style-1 filter-by" id="filter-by" name="filter-by">
                                <option value="*" {{ old('filter-by') == "*" ? 'selected': '' }}>All</option>
                                <option value="image" {{ old('filter-by') == "image" ? 'selected': '' }}>Images</option>
                                <option value="stream" {{ old('filter-by') == "stream" ? 'selected': '' }}>Videos</option>
                            </select>
                        </li>
                    </ul>
                </div>

                <div class="mg-files">
                    <div class="card card-modern">
                        <div class="card-body">
                            <div class="datatables-header-footer-wrapper">
                                <div class="datatable-header">
                                    <div class="row align-items-center mb-3 justify-content-end">
                                        <div class="col-12 col-lg-auto pl-lg-1">
                                            <div class="search search-style-1 mx-lg-auto">
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
                                    <table class="table table-ecommerce-simple table-medias table-striped mb-0" id="datatable-ecommerce-list">
                                        <thead>
                                            <tr>
                                                <th width="30"><input type="checkbox" name="select-all" id="select-all" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                                <th>@sortablelink('name', 'File')</th>
                                                <th width="15%">@sortablelink('uploaded_by', 'Author')</th>
                                                <th width="15%">Type</th>
                                                <th width="15%">@sortablelink('size')</th>
                                                <th width="15%">@sortablelink('created_at', 'Date')</th>													
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($media->isNotEmpty())
                                                @foreach($media as $medium)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative" value="" data-id="{{ $medium->id }}" />
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('/admin/media') }}/{{ $medium->id }}/edit">
                                                                @if(explode('/', $medium->type)[0] == 'image')
                                                                    <img @if(isset($medium->copy_link)) src="{{ asset('storage') }}/{{ Str::replaceLast('.', '-100x100.', $medium->copy_link) }}" @else src="{{ asset('server/images/porto-placeholder-66x66.png') }}" @endif alt="Product" width="60" height="60">
                                                                @else
                                                                    <img src="{{ asset('server/images/porto-placeholder-66x66.png') }}" alt="Product" width="60" height="60">
                                                                @endif
                                                            </a>
                                                            <span class="ml-3">{{ $medium->name }}</span>
                                                            <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                        </td>
                                                        <td data-column="Author">
                                                            {{ $medium->uploaded_by }}
                                                        </td>
                                                        <td data-column="Type">{{ $medium->type }}</td>
                                                        <td data-column="Size">{{ number_format($medium->size / 1024, 2) }}Kb</td>
                                                        <td data-column="Date">{{ $medium->created_at }}</td>
                                                        <td class="actions" data-column="Actions">
                                                            <a href="{{ url('admin/media/'.$medium->id.'/edit') }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                                            <a href="javscript:;" class="on-default remove-row"><i class="far fa-trash-alt"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="12" class="text-center">No results were found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                <input type="hidden" name="order-by" id="order-by" value="{{ old('order-by', 'id') }}">
                                <input type="hidden" name="direction" id="direction" value="{{ old('direction', 'asc') }}">

                                <hr class="solid mt-5 opacity-4">
                                <div class="datatable-footer">
                                    <div class="row align-items-center justify-content-between mt-3">
                                        <div class="col-md-auto order-1 mb-3 mb-lg-0">
                                            <div class="d-flex align-items-stretch">
                                                <select class="form-control select-style-1 bulk-action w-auto mr-3" style="min-width: 120px;">
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
                                                {!! $media->appends(\Request::except('page'))->render() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </form>
    </section>
    <!-- end: page -->
    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/media/list.min.js') }}"></script>
    
@endsection