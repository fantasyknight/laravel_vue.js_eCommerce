@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Gallery Grid', 'paths' => ['home' => '/dashboard', 'media' => '/media/grid']])

    <!-- start: page -->
    <section class="media-gallery">
        <form action="{{ url('/admin/media/grid') }}" method="get" id="media-grid-form">
            <div class="inner-body mg-main ml-0">
            
                <div class="inner-toolbar clearfix">
                    <ul>
                        <li>
                            <a href="{{ url('/admin/media/list') }}"><i class="fas fa-th-list"></i></a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/media/grid') }}" class="active"><i class="fas fa-th-large"></i></a>
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

                <div class="row mg-files">
                    @if($media->isNotEmpty())
                        @foreach($media as $medium)
                            <div class="col-6 col-xs-4 col-sm-3 col-md-1-5 col-lg-2 col-xl-1-8 col-xxl-1-10">
                                <div class="thumbnail">
                                    <div class="thumb-preview">
                                        <div class="centered">
                                            @if(explode('/', $medium->type)[0] == 'image')
                                                <a class="thumb-image" href="{{ asset('storage') }}/{{ $medium->copy_link }}">
                                                    <img src="{{ asset('storage') }}/{{ Str::replaceLast('.', '-150x150.', $medium->copy_link) }}" class="img-fluid" alt="Project">
                                                </a>
                                            @else
                                                <a class="thumb-image" href="{{ asset('img/placeholder-img.png') }}">
                                                    <img src="{{ asset('img/placeholder-img.png') }}" alt="media" >
                                                </a>
                                            @endif
                                        </div>
                                        <div class="mg-thumb-options">
                                            <div class="mg-zoom"><i class="fas fa-search"></i></div>
                                            <div class="mg-toolbar">
                                                <div class="mg-option checkbox-custom checkbox-inline">
                                                    <input type="checkbox" id="file_{{ $loop->index }}" value="1" data-id="{{ $medium->id }}">
                                                    <label for="file_{{ $loop->index }}"></label>
                                                </div>
                                                <div class="mg-group float-right">
                                                    <a href="{{ url('/admin/media') }}/{{ $medium->id }}/edit"><i class="fas fa-pencil-alt"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-results text-center pt-5 m-auto">No media were found</div>
                    @endif
                </div>

                <div class="pagination-wrapper d-flex justify-content-end">
                    {{ $media->appends(['filter-by' => old('filter-by')])->links() }}
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
    <script src="{{ asset('server/js/media/grid.min.js') }}"></script>
@endsection