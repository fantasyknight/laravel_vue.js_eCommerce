@extends('admin.layout')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('vendor/codemirror/lib/codemirror.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/codemirror/theme/monokai.css') }}" />
@endsection

@section('sidebar')
    @include('admin.common.sidebar')
@endsection

@section('page-content')
    @include('admin.common.breadcrumb', ['current_page' => 'Main Menu', 'paths' => ['home' => '/dashboard']])

    <div class="row">
        <div class="col">
            <form method="post" action="{{ url('admin/customize/menu/') }}">
                @csrf
                <div class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <i class="card-big-info-icon bx bx-store"></i>
                                <h2 class="card-big-info-title">Edit Here</h2>
                                <p class="card-big-info-desc">We provide menu structure in json format. Please try to edit them in valid format.</p>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control" rows="50" id="codemirror_js_code" name="menu-json" data-plugin-codemirror data-plugin-options='{ "mode": "text/javascript" }'>{!! $content !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row action-buttons mt-4">
                    <div class="col-12 col-md-auto">
                        <button type="submit" class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-loading-text="Loading...">
                            <i class="bx bx-save text-4 mr-2"></i> Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('vendor-js')
    <script src="{{ asset('vendor/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('vendor/codemirror/addon/selection/active-line.js') }}"></script>
    <script src="{{ asset('vendor/codemirror/addon/edit/matchbrackets.js') }}"></script>
    <script src="{{ asset('vendor/codemirror/mode/javascript/javascript.js') }}"></script>
    <script src="{{ asset('vendor/codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('vendor/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
    <script src="{{ asset('vendor/codemirror/mode/css/css.js') }}"></script>
@endsection

@section('page-js')
@endsection