@extends('admin.layout')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/basic.css') }}" />   
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/dropzone.css') }}" />
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => $type == 'product' ? 'Product categories' : 'Post categories', 'paths' => ['home' => '/dashboard', $type . 's' => '/' . $type . 's' ]])

    <div class="row">
        <div class="col-xl-4">
            <form action="{{ url('admin/categories') }}" method="post">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}" id="category-type">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="form-group align-items-center">
                            <label class="control-label">Name</label>
                            <input type="text" maxlength="50" class="form-control form-control-modern" name="name" value="" required />
                            <span class="help-block">Name for the category.</span>
                        </div>
                        <div class="form-group align-items-center">
                            <label class="control-label">Slug</label>
                            <input type="text" maxlength="50" class="form-control form-control-modern" name="slug" value="" />
                            <span class="help-block">Unique slug/reference for the category.</span>
                        </div>
                        <div class="form-group align-items-center">
                            <label class="control-label">Parent Category</label>
                            <select class="form-control form-control-modern" name="parent">
                                <option value="0">None</option>
                                @foreach($parent_categories as $cat)
                                    <option value="{{ $cat->id }}">{!! $cat->name !!}</option>
                                @endforeach
                            </select>
                            <span class="help-block">Parent category to which current category belongs.</span>
                        </div>
                        <div class="form-group align-items-center">
                            <label class="control-label">Description</label>
                            <textarea class="form-control form-control-modern" name="description" rows="5" maxlength="200"></textarea>
                            <span class="help-block">Add description for the category.</span>
                        </div>
                        <div class="form-group align-items-center">
                            <a class="modal-sizes btn btn-primary ml-auto mb-2 mr-3" href="#mediaGallery">
                                Add images
                            </a>
                            <div class="category-image d-inline-block">
                                <img width="60" height="60" src="{{ asset('server/images/porto-placeholder-66x66.png') }}" alt="category" />
                            </div>
                            <input type="hidden" name="media_id" id="category-media-image"/>
                        </div>
                        <div class="form-group align-items-center">
                            <label class="control-label">Add Icons</label>
                            <input type="text" maxlength="50" class="form-control form-control-modern" name="icon" value="" />
                            <span class="help-block">Add icons for the category.</span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add category</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xl-8 mt-xl-0 mt-3">
            <form id="categories-list-form" method="get">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-3">
                                    <div class="col col-sm-auto ml-auto pl-lg-1">
                                        <div class="search search-style-1 mx-lg-auto w-auto">
                                            <div class="input-group">
                                                <input type="text" maxlength="50" class="search-term form-control" name="search-term" id="search-term" placeholder="Search" value="{{ old('search-term', null) }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list" style="min-width: 750px">
                                    <thead>
                                        <tr>
                                            <th width="30"><input type="checkbox" name="select-all" class="select-all checkbox-style-1 p-relative" value="" /></th>
                                            <th>@sortablelink('name')</th>
                                            <th>@sortablelink('slug')</th>
                                            <th>@sortablelink('description')</th>
                                            <th>@sortablelink('count')</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($categories->isNotEmpty())
                                            @foreach($categories as $category)
                                                <tr>
                                                    <td>
                                                        @if($category->id > 2)
                                                            <input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative" data-id="{{ $category->id }}"/>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($category->media)
                                                            <img src="{{ asset('storage') }}/{{ Str::replaceLast('.', '-150x150.', $category->media->copy_link) }}" alt="Category" width="60" height="60">
                                                        @else
                                                            <img src="{{ asset('server/images/porto-placeholder-66x66.png') }}" alt="Category" width="60" height="60">
                                                        @endif
                                                        @cannot('vendor-role')
                                                            <a href="{{ url('/admin/categories/' . $category->id . '/edit') }}"><strong>{{ $category->name }}</strong></a>
                                                        @else
                                                            <a href="#"><strong>{{ $category->name }}</strong></a>
                                                        @endcannot
                                                        <a href="javascript:;" class="slide-content d-block d-lg-none"></a>
                                                    </td>
                                                    <td data-column="Slug">{{ $category->slug }}</td>
                                                    <td data-column="Description">{{ $category->description }}</td>
                                                    <td data-column="Count">
                                                        @if($type=='product')
                                                            <a href="{{ action('Admin\ProductController@index', ['filter-category' => $category->id]) }}">{{ $category->count }}</a>
                                                        @else
                                                            <a href="{{ action('Admin\PostController@index', ['category' => $category->id]) }}">{{ $category->count }}</a>
                                                        @endif
                                                    </td>
                                                    <td class="actions" data-column="Actions">
                                                        @cannot('vendor-role')
                                                            @if($category->id > 2)
                                                                <a href="{{ url('admin/categories/' . $category->id . '/edit') }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="javscript:;" class="on-default remove-row"><i class="far fa-trash-alt"></i></a>
                                                            @endif
                                                        @endcannot
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No categories found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>                            
                            <hr class="solid mt-5 opacity-4">
                            <div class="datatable-footer">
                                <div class="row align-items-center justify-content-between mt-3">
                                    <div class="col-md-auto order-1 mb-3 mb-lg-0">
                                        @cannot('vendor-role')
                                            <div class="d-flex align-items-stretch">
                                                <select class="form-control select-style-1 bulk-action w-auto mr-3" style="min-width: 120px;">
                                                    <option value="" selected>Bulk Actions</option>
                                                    <option value="delete">Delete</option>
                                                </select>
                                                <a href="javascript:;" class="bulk-action-apply btn btn-light border font-weight-semibold text-color-dark text-3">Apply</a>
                                            </div>
                                        @endcannot
                                    </div>
                                    <div class="col-lg-auto text-center order-3 order-lg-2">
                                        <div class="results-info-wrapper"></div>
                                    </div>
                                    <div class="col-lg-auto order-2 order-lg-3 mb-3 mb-lg-0">
                                        {!! $categories->appends(\Request::except('page'))->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="mediaGallery" class="modal-block modal-media-gallery mfp-hide">
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Select Images</h2>
            </header>
            <div class="card-body">
                <div class="modal-wrapper">
                    <div class="tabs">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" href="#upload" data-toggle="tab">File Upload</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#gallery" data-toggle="tab">Media Gallery</a>
                            </li>
                        </ul>
                        <div class="tab-content overflow-auto">
                            <div id="upload" class="tab-pane">
                                <div id="dropzone-form-image" class="dropzone-modern dz-square">
                                    <span class="dropzone-upload-message text-center">
                                        <i class="bx bxs-cloud-upload"></i>
                                        <b class="text-color-primary">Drag/Upload</b> your images here.
                                    </span>
                                </div>
                            </div>
                            <div id="gallery" class="tab-pane active media-gallery">
                                <div class="row mg-files">
                                    @if($media->isNotEmpty())
                                        @foreach($media as $medium)
                                            <div class="col-6 col-xs-4 col-sm-3 col-md-1-5 col-lg-2 col-xl-1-8 col-xxl-1-10">
                                                <div class="thumbnail">
                                                    <div class="thumb-preview">
                                                        <div class="centered">
                                                            <a class="thumb-image" href="{{ asset('storage') }}/{{ $medium->copy_link }}">
                                                                <img src="{{ asset('storage') }}/{{ Str::replaceLast('.', '-150x150.', $medium->copy_link) }}" class="img-fluid" alt="Project">
                                                            </a>
                                                        </div>
                                                        <div class="mg-thumb-options">
                                                            <div class="mg-toolbar">
                                                                <div class="mg-option checkbox-custom checkbox-inline">
                                                                    <input type="checkbox" id="file_{{ $loop->index }}" value="1" data-id="{{ $medium->id }}">
                                                                    <label for="file_{{ $loop->index }}">Select</label>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary modal-set">Set</button>
                        <button class="btn btn-default modal-dismiss">Cancel</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>

    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/dropzone/min/dropzone.min.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/categories/list.min.js') }}"></script>
@endsection

@if( $errors->has('slug') )
    @push('scripts')
        <script>
            $(document).ready(function() {
                new PNotify({
                    title: 'Warning',
                    text: 'Category with the same slug already exists.',
                    type: 'error',
                    addclass: 'notification-error',
                    icon: 'fas fa-times'
                });
            })
        </script>
    @endpush
@endif