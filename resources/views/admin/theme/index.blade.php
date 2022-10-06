<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="modern has-top-menu has-left-sidebar-half sidebar-left-sm overflow-hidden">
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Laravel porto" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Porto') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('server/images/icons/favicon.ico') }}">

    <!-- Vendor Css -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/pnotify/pnotify.custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/basic.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/dropzone.css') }}" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('server/css/theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('server/css/custom.css') }}" />
    <!-- Theme Custom CSS -->

    <!-- Theme Skin CSS -->

    <!-- Head Libs -->
    <script src="{{ asset('vendor/modernizr/modernizr.js') }}"></script>

</head>
<body>
	<div>
		<input type="hidden" id="base-url" value="{{ url('/') }}" />
	</div>
	
	<div id="app">
		<theme-settings-component :settings="{{ json_encode($settings) }}" :media="{{ $media }}" asset-url="{{ asset('/') }}"></theme-settings-component>
	</div>

    <!-- Vendor -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
    <script src="{{ asset('vendor/nanoscroller/nanoscroller.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

	<script>
        var baseUrl = "{{ url('/') }}";
    </script>

	<!-- Vue JS -->
    <script src="{{ asset('server/js/app.js') }}"></script>

	<!-- Theme Base, Components and Settings -->
	<script src="{{ asset('server/js/theme.min.js') }}"></script>

	<!-- Theme Custom -->
	<script src="{{ asset('server/js/custom.min.js') }}"></script>

	<!-- Theme Initialization Files -->
	<script src="{{ asset('server/js/theme.init.min.js') }}"></script>
    <script>
        window.addEventListener('load', function () {
            document.querySelector("body").classList.add('loaded');
		})
    </script>
</body>