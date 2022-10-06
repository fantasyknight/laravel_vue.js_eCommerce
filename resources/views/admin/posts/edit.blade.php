@extends('admin.layout')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/basic.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/jstree/themes/default/style.css') }}" />
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Edit Post', 'paths' => ['home' => '/dashboard', 'post' => '/posts']])
    

    <form class="ecommerce-form " action="{{ url('/admin/posts/' . $post->id) }}" method="post">
        @method('PUT')
        @csrf
        <input type="hidden" name="categories" id="categories">
        <input type="hidden" name="description" id="description" required>
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-box"></i>
                                <h2 class="card-big-info-title">General Info</h2>
                                <p class="card-big-info-desc">Add here the post description with all details and necessary information.</p>
                                <a href="{{ url('/pages/blog/single'). '/' . $post->slug }}" target="_blank">Click here to see the post</a>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Post Title</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="30" class="form-control form-control-modern" name="title" value="{{ $post->title }}" required />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Author</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="30" class="form-control form-control-modern" value="{{ $post->author->first_name }}" required readonly />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Short Description</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <textarea name="short_desc" maxlength="250" rows="3" required="required" class="form-control form-control-modern">{{ $post->short_desc }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-2">Post Categories</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <div class="form-control form-control-modern" id="treeCheckbox">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-2">Post Tags</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input name="tags" id="tags-input" data-role="tagsinput" data-tag-class="badge badge-primary" class="form-control" value="{{ $used_tag_names }}" />

                                        @if($post_tags->isNotEmpty())
                                            <a class="btn btn-link mt-2 px-0" data-toggle="collapse" href="#tags" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                Choose from most used tags.
                                            </a>
                                            <div class="form-control form-control-modern mt-1 collapse" id="tags">
                                                @foreach($post_tags as $tag)
                                                    <a href="javascript:;" class="btn btn-tag">{{ $tag->name }}</a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 col-lg-3">Status</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <div class="switch switch-sm switch-primary">
                                            <input type="hidden" name="enabled" value="0">
                                            <input type="checkbox" name="enabled" data-plugin-ios-switch {{ $post->enabled ? 'checked' : '' }} value="1" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 col-lg-3">Allow Comments</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <div class="switch switch-sm switch-primary">
                                            <input type="hidden" name="allow_comments" value="0">
                                            <input type="checkbox" name="allow_comments" data-plugin-ios-switch {{ $post->allow_comments ? 'checked' : '' }} value="1" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-camera"></i>
                                <h2 class="card-big-info-title">Post Image</h2>
                                <p class="card-big-info-desc">Upload your Product image. You can add multiple images</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group align-items-center">
                                    <div class="row">
                                        <a class="modal-sizes btn btn-primary ml-auto mb-2" href="#mediaGallery">
                                            Add images.
                                        </a>
                                        <input type="hidden" name="media_ids" id="post-media-images" />
                                    </div>
                                    <div class="media-gallery">
                                        <div class="row mg-files mg-post-images">
                                            @foreach ($post->media as $current_medium)
                                                <div class="col-6 col-md-4 col-lg-3">
                                                    <div class="thumbnail">
                                                        <div class="thumb-preview">
                                                            <div class="centered">
                                                                <a class="thumb-image" href="" data-id="{{ $current_medium->id }}">
                                                                    @if(strpos($current_medium->copy_link, 'image'))
                                                                        <img src="{{ asset('storage') }}/{{ Str::replaceLast('.', '-150x150.', $current_medium->copy_link) }}" class="img-fluid" alt="post">
                                                                    @else
                                                                        <img src="{{ asset('storage') }}/{{ $current_medium->copy_link }}" class="img-fluid" alt="post">
                                                                    @endif
                                                                </a>
                                                            </div>
                                                            <div class="mg-thumb-options">
                                                                <div class="mg-remove"><i class="fas fa-times"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-paste"></i>
                                <h2 class="card-big-info-title">Description</h2>
                                <p class="card-big-info-desc">Add here the post description with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row">
                                    <div class="col">
                                        <div class="summernote" data-plugin-summernote data-plugin-options='{ "height": 320, "codemirror": { "theme": "ambiance" } }'>{!! $post->description !!}</div>
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
                    <i class="bx bx-save text-4 mr-2"></i> Save Post
                </button>
            </div>
            <div class="col-6 col-md-auto px-md-0">
                <a href="{{ url('/admin/posts') }}" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark line-height-1 d-flex h-100 align-items-center">Back</a>
            </div>

            <div class="col-6 col-md-auto ml-md-auto mt-3 mt-md-0">
                <a href="#" class="delete-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-id="{{ $post->id }}">
                    <i class="bx bx-trash text-4 mr-2"></i> Delete Post
                </a>
            </div>
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
                                <a class="nav-link" href="#upload" data-toggle="tab">Upload files</a>
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
                                                                @if(strpos($medium->copy_link, 'image'))
                                                                    <img src="{{ asset('storage') }}/{{ Str::replaceLast('.', '-150x150.', $medium->copy_link) }}" class="img-fluid" alt="post">
                                                                @else
                                                                    <img src="{{ asset('storage') }}/{{ $medium->copy_link }}" class="img-fluid" alt="post">
                                                                @endif
                                                            </a>
                                                        </div>
                                                        <div class="mg-thumb-options">
                                                            <div class="mg-zoom"><i class="fas fa-search"></i></div>
                                                            <div class="mg-toolbar">
                                                                <div class="mg-option checkbox-custom checkbox-inline">
                                                                    <input type="checkbox" id="file_{{ $loop->index }}" name="add-image" value="1" data-id="{{ $medium->id }}">
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
    <script src="{{ asset('vendor/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('vendor/jstree/jstree.min.js') }}"></script>
    <script src="{{ asset('vendor/ios7-switch/ios7-switch.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/posts/form.min.js') }}"></script>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#treeCheckbox').jstree({
                'core' : {
                    'data' : {!! $categories !!},
                    'themes' : {
                        'responsive': false
                    }
                },
                'plugins': ['types', 'checkbox'],
                'checkbox': {
                    'three_state': false,
                    'tie_selection': false,
                    'whole_node': true
                }
            });

            $('#treeCheckbox').on('loaded.jstree', function() {
                $('#treeCheckbox').jstree().check_node({!! $current_categories !!});
            });
        });
    </script>
@endpush