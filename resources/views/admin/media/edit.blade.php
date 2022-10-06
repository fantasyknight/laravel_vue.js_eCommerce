@extends('admin.layout')

@section('vendor-css')
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Edit Media', 'paths' => []])

    <!-- start: page -->
    <form class="ecommerce-form  edit-media-form" action="{{ url('/admin/media/') }}/{{ $media->id }}" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-lg-7">
                @if(explode('/', $media->type)[0] == 'image')
                    @if(isset($media->copy_link))
                        <img src="{{ asset('storage') }}/{{ $media->copy_link }}" class="img-fluid" alt="media" width="{{ $media->width }}" height="{{ $media->height }}">
                    @else
                        <img src="{{ asset('img/placeholder-img.png') }}" alt="Product" width="247" height="296">
                    @endif
                @else
                    <video width="500" height="500" loop="" autoplay="true" preload="metadata">
                        <source src="{{ asset('storage') }}/{{ $media->copy_link }}" type="video/mp4">
                    </video>
                @endif
            </div>
            <div class="col-lg-5 mt-3 mt-lg-0">
                <div class="card card-info media-info">
                    <header class="card-header">
                        <div class="card-actions">
                            <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        </div>

                        <h2 class="card-title">Media info</h2>
                    </header>
                    <div class="card-body">
                        <div class="info-section d-flex align-items-center mb-3">
                            <h5 class="info-title">Date</h5>
                            <span class="info-text">{{ $media->created_at }}</span>
                        </div>
                        <div class="info-section mb-3">
                            <h5 class="info-title">File URL</h5>
                            <input type="text" maxlength="40" class="form-control form-control-modern mt-1" value="{{ $media->copy_link }}" readonly>
                        </div>
                        <div class="info-section d-flex align-items-center mb-3">
                            <h5 class="info-title">File name</h5>
                            <span class="info-text">{{ $media->name }}</span>
                        </div>
                        <div class="info-section d-flex align-items-center mb-3">
                            <h5 class="info-title">File size</h5>
                            <span class="info-text">{{ $media->size/1000 }} Kb</span>
                        </div>
                        <div class="info-section d-flex align-items-center mb-0">
                            <h5 class="info-title">Dimensions</h5>
                            <span class="info-text">{{ $media->width }} x {{ $media->height }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-box"></i>
                                <h2 class="card-big-info-title">General</h2>
                                <p class="card-big-info-desc">Add here the product description with all details and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Title</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="50" class="form-control form-control-modern" name="name" value="{{ $media->name }}" required />
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Alternative Text</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <input type="text" maxlength="20" class="form-control form-control-modern" name="alt_text" value="{{ $media->alt_text }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-3 control-label text-lg-right mt-2 mb-0">Description</label>
                                    <div class="col-lg-7 col-xl-6">
                                        <textarea class="form-control form-control-modern" name="description" rows="5">{{ $media->description }}</textarea>
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
                    <i class="bx bx-save text-4 mr-2"></i> Save Media
                </button>
            </div>
            <div class="col-6 col-md-auto px-md-0 mt-0">
                <a href="{{ url('/admin/media/list') }}" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark line-height-1 d-flex h-100 align-items-center">Back</a>
            </div>
            <div class="col-6 col-md-auto ml-md-auto mt-3 mt-md-0">
                <a href="#" class="delete-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-id="{{ $media->id }}">
                    <i class="bx bx-trash text-4 mr-2"></i> Delete Media
                </a>
            </div>
        </div>
    </form>
    <!-- end: page -->
    @include('admin.common.modals.delete-confirm')
@endsection

@section('vendor-js')
@endsection

@section('page-js')
    <script src="{{ asset('server/js/media/edit.min.js') }}"></script>
@endsection