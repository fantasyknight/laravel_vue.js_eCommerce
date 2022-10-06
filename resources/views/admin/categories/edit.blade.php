@extends('admin.layout')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/basic.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/dropzone.css') }}" />
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => $category ? 'Edit Category' : 'Add Category', 'paths' => ['home' => '/dashboard', $type . 's' => '/' . $type . 's', 'categories' => '/categories/' . $type . '']])

    <form class="ecommerce-form " action="{{ $category ? url('/admin/categories/' . $category->id) : url('/admin/categories') }}" method="post">
        @if($category) 
            @method('PUT')
        @endif
        @csrf

        <input type="hidden" name="type" value="{{ $type }}" id="category-type">
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-slider"></i>
                                <h2 class="card-big-info-title">Category Details</h2>
                                <p class="card-big-info-desc">Add here the category description with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Category Name</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" class="form-control form-control-modern" maxlength="50" name="name" value="{{ $category ? $category->name : '' }}" required />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Slug</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" class="form-control form-control-modern" maxlength="50" name="slug" value="{{ $category ? $category->slug : '' }}" />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Parent Category</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select class="form-control form-control-modern" name="parent">
                                            <option value="0" {{ $category && $category->parent == 0 ? 'selected' : '' }}>None</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ $category && $category->parent == $cat->id ? 'selected' : '' }}>{!! $cat->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-0">Description</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <textarea class="form-control form-control-modern" name="description" rows="6" maxlength="200">{{ $category ? $category->description : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Icons</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" class="form-control form-control-modern" maxlength="50" name="icon" value="{{ $category ? $category->icon : '' }}" />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Category Image</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <a class="modal-sizes btn btn-primary ml-auto mb-2 mr-3" href="#mediaGallery">
                                            @if(isset($category->media))Add image @else Update image @endif
                                        </a>
                                        <div class="category-image d-inline-block">
                                            @if(isset($category->media))
                                                <img width="60" height="60" src="{{ asset('storage') }}/{{ Str::replaceLast('.', '-150x150.', $category->media->copy_link) }}" alt="{{ $category->media->alt_text ?: 'category' }}" />
                                            @else
                                                <img width="60" height="60" src="{{ asset('server/images/porto-placeholder-66x66.png') }}" alt="category" />
                                            @endif
                                        </div>
                                        <input type="hidden" name="media_id" id="category-media-image" @if(isset($category->media)) value="{{ $category->media->id }}" @endif/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row action-buttons">
            <div class="col-6 col-md-auto">
                <button type="submit" class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-loading-text="Loading...">
                    <i class="bx bx-save text-4 mr-2"></i> Save Category
                </button>
            </div>
            <div class="col-6 col-md-auto px-md-0">
                <a href="{{ url('/admin/categories/' .  $type) }}" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark line-height-1 d-flex h-100 align-items-center">Back</a>
            </div>

            @if($category)
                <div class="col-6 col-md-auto ml-md-auto mt-3 mt-md-0">
                    <a href="#" class="delete-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-id="{{ $category->id }}">
                        <i class="bx bx-trash text-4 mr-2"></i> Delete Category
                    </a>
                </div>
            @endif
        </div>
    </form>

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
    <script src="{{ asset('server/js/categories/edit.min.js') }}"></script>
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