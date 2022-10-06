@extends('admin.layout')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}" />
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Edit Reply', 'paths' => ['home' => '/dashboard', 'posts' => '/posts', 'replies' => '/posts/comments']])

    <form class="ecommerce-form " action="{{ url('/admin/posts/comments/' . $comment->id) }}" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-box"></i>
                                <h2 class="card-big-info-title">General Info</h2>
                                <p class="card-big-info-desc">Add here the product description with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Name</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="50" class="form-control form-control-modern" name="author_name" value="{{ $comment->author_name }}" required />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">E-mail</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="email" maxlength="50" class="form-control form-control-modern" name="author_email" value="{{ $comment->author_email }}" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-0">URL</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="50" class="form-control form-control-modern" name="website" value="{{ $comment->website }}" />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 col-lg-3">Status</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <select class="form-control form-control-modern" name="approved" required>
                                            <option value="1" {{ $comment->approved ? 'selected' : '' }}>Approved</option>
                                            <option value="0" {{ $comment->approved ? '' : 'selected' }}>Pending</option>
                                        </select>
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
                                        <input type="hidden" name="content" id="content">
                                        <div class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "ambiance" } }'>{!! $comment->content !!}</div>
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
                    <i class="bx bx-save text-4 mr-2"></i> Save Reply
                </button>
            </div>
            <div class="col-6 col-md-auto px-md-0">
                <a href="{{ url('/admin/posts/comments') }}" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark line-height-1 d-flex h-100 align-items-center">Back</a>
            </div>

            <div class="col-6 col-md-auto ml-md-auto mt-3 mt-md-0">
                <a href="#" class="delete-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-id="{{ $comment->id }}">
                    <i class="bx bx-trash text-4 mr-2"></i> Delete Reply
                </a>
            </div>
        </div>
    </form>

    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/comments/posts/edit.min.js') }}"></script>
@endsection