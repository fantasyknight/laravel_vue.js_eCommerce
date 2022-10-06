<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	
    <!-- CSRF Token -->
	<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
	<!-- <meta http-equiv="refresh" content="10"> -->

	<title>{{ $site_title }} - {{ $tagline }}</title>

	<meta name="keywords" content="Laravel Porto Theme" />
	<meta name="description" content="{{ $site_title }} - {{ $tagline }}">
	<meta name="theme-color" content="#c96">
	<meta name="author" content="D-THEMES">

	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="{{ asset('client/images/icons/favicon.ico') }}">
	<link rel="apple-touch-icon" href="{{ asset('client/images/icons/apple-touch-icon.png') }}">
	<link rel="dns-prefetch" href="//fonts.googleapis.com">
	
	<script>
		WebFontConfig = {
			google: { families: [ 'Open+Sans:400,600,700','Poppins:400,500,600,700', 'Oswald:300,400' ] }
		};
		(function(d) {
			var wf = d.createElement('script'), s = d.scripts[0];
			wf.src = "{{ asset('client/vendor/webfont.js') }}";
			wf.async = true;
			s.parentNode.insertBefore(wf, s);
		})(document);
	</script>
	<!-- Plugins CSS File -->
	<link rel="stylesheet" href="{{ asset('client/vendor/bootstrap.min.css') }}">

	<!-- Main CSS File -->
	<link rel="preload" href="{{ asset('client/fonts/porto.woff2') }}" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="{{ asset('vendor/font-awesome/webfonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="{{ asset('vendor/font-awesome/webfonts/fa-brands-400.woff2') }}" as="font" type="font/woff2" crossorigin>
	<link id="base-css" rel="stylesheet" href="{{ asset('client/css/style.css') }}">
	<style id="custom-typography-css"></style>
	<style id="custom-inline-css">{!! config('setting.custom_css') !!}</style>
	<style id="skin-css"></style>
</head>
<body>
	<div class="loading-overlay">
        <div class="bounce-loader">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
	<div>
		<input type="hidden" id="base-url" value="{{ url('/') }}" />
	</div>
    <div id="app">
    </div>
    <script>
		var baseUrl = "{{ url('/') }}";
		var sellableCountries = @json(array_keys(Helper::getSellableCountries()));
		var shippableCountries = @json(array_keys(Helper::getShippableCountries()));

		document.cookie = 'porto-single-user=@json(Auth::user() ? Arr::except(Auth::user()->toArray(), ["description"]) : null); path=/';
		window.addEventListener('load', function () {
			setTimeout(() => {
				document.querySelector("body").classList.add('loaded');
			}, 300);
		});

		let preloadLink = document.createElement("link");
			preloadLink.href = "{{ asset('vendor/font-awesome/css/all.min.css') }}";
			preloadLink.rel = "stylesheet";
		document.body.appendChild(preloadLink);
	</script>

	<script src="https://js.stripe.com/v3/" defer></script>
	
	<script src="{{ asset('client/js/app.js') }}"></script>
</body>
</html>
