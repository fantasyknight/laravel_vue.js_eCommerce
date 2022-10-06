@extends('admin.layout')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/basic.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/dropzone.css') }}" />
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Add new Media', 'paths' => []])

    <!-- start: page -->
    <form class="ecommerce-form" action="#" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col">
                <section class="card card-modern">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div id="dropzone-form-image" class="dropzone-modern dz-square">
                                    <span class="dropzone-upload-message text-center">
                                        <i class="bx bxs-cloud-upload"></i>
                                        <b class="text-color-primary">Drag/Upload</b> your images here.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="help-block text-3 mb-1">You are using the multi-file uploader.</span>
                <span class="help-block text-3">Maximum upload file size: 8 MB.</span>
            </div>
        </div>
    </form>
    <!-- end: page -->
@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/dropzone/min/dropzone.min.js') }}"></script>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/media/create.min.js') }}"></script>
@endsection