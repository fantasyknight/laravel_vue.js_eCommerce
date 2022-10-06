@extends('admin.layout')

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Media Settings', 'paths' => ['home' => '/dashboard', 'media' => '/media/list']])

    <!-- start: page -->
    <div class="row media-settings">
        <div class="col">
            <form id="media-setting-form" action="{{ url('/admin/media/setting') }}" method="post" class="form-horizontal">
                @csrf
                @method('put')
                <section class="card">
                    <div class="card-body pb-5">
                        <h3 class="form-title pt-3">Small Thumbnail</h3>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Width <span class="required">*</span></label>
                            <div class="col-lg-3">
                                <input type="number" min="10" name="media_small_thumbnail_width" class="form-control" placeholder="150" required value="{{ old('media_small_thumbnail_width') }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Height <span class="required">*</span></label>
                            <div class="col-lg-3">
                                <input type="number" min="10" name="media_small_thumbnail_height" class="form-control" placeholder="150" required value="{{ old('media_small_thumbnail_height') }}"/>
                            </div>
                        </div>
                        <h3 class="form-title pt-3">Medium Thumbnail</h3>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Width <span class="required">*</span></label>
                            <div class="col-lg-3">
                                <input type="number" min="10" name="media_medium_thumbnail_width" class="form-control" placeholder="400" required value="{{ old('media_medium_thumbnail_width') }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Height <span class="required">*</span></label>
                            <div class="col-lg-3">
                                <input type="number" min="10" name="media_medium_thumbnail_height" class="form-control" placeholder="400" required value="{{ old('media_medium_thumbnail_height') }}"/>
                            </div>
                        </div>
                        <h3 class="form-title pt-3">Large Thumbnail</h3>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Width <span class="required">*</span></label>
                            <div class="col-lg-3">
                                <input type="number" min="10" name="media_large_thumbnail_width" class="form-control" placeholder="800" required value="{{ old('media_large_thumbnail_width') }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Height <span class="required">*</span></label>
                            <div class="col-lg-3">
                                <input type="number" min="10" name="media_large_thumbnail_height" class="form-control" placeholder="800" required value="{{ old('media_large_thumbnail_height') }}"/>
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <div class="row justify-content-end">
                            <div class="col-sm-9">
                                <button class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-default" id="btn-reset">Reset</button>
                            </div>
                        </div>
                    </footer>
                </section>
            </form>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('server/js/media/setting.min.js') }}"></script>
@endsection