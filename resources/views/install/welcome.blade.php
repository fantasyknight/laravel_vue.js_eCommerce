<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

	<title>Porto - Bootstrap eCommerce Template</title>

	<meta name="keywords" content="HTML5 Template" />
	<meta name="description" content="Porto - Bootstrap eCommerce Template">
	<meta name="author" content="SW-THEMES">

	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="{{ asset('client/images/icons/favicon.ico') }}">
	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800%7CPoppins:300,400,500,600,700,800" media="all">

	<!-- Plugins CSS File -->
	<link rel="stylesheet" href="{{ asset('client/vendor/bootstrap.min.css') }}">

	<!-- Main CSS File -->
	<link rel="stylesheet" href="{{ asset('server/css/installer.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/font-awesome/css/all.min.css') }}">
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
    <div class="container">
        <form action="{{ url('/installer') }}" method="post" id="wizard-form">
            <div class="porto-setup-wizard">
                <header class="porto-setup-wizard-header d-flex justify-between">
                    <div class="header-left">
                        <h2>Laravel Porto Setup Wizard</h2>
                        <h6>This quick setup wizard will help you configure your new website.</h6>
                    </div>
                    <div class="header-right">
                        <div class="porto-logo">
                            <img src="{{ asset('server/images/installer/logo_white_small.png') }}" alt="">
                            <span class="version">version 1.0.0</span>
                        </div>
                    </div>
                </header>
                <ol class="porto-setup-steps nav nav-tabs">
                    <li>
                        <a class="active" href="#welcome">Welcome</a>					
                    </li>
                    <li>
                        <a class="nolink" href="#status">Status</a>
                    </li>
                    <li>
                        <a class="nolink" href="#database">Database</a>
                    </li>
                    <li>
                        <a class="nolink" href="#admin">Admin Setting</a>
                    </li>
                    <li>
                        <a class="nolink" href="#demo">Demo Import</a>
                    </li>
                    <li>
                        <a href="#site-settting" class="nolink">Site Setting</a>
                    </li>
                    <li>
                        <a class="nolink" href="#" class="nolink">Ready!</a>
                    </li>
                </ol>
                <div class="col-12 tab-content">
                    <div class="tab-pane fade in show active" id="welcome">
                        <div class="row">
                            <aside class="updates col-sm-3"></aside>
                            <section class="col-sm-9">
                                <h2>Welcome to Laravel Porto eCommerce Theme</h2>
                                <div class="notice-success notice-alt notice-large mb-4">
                                    Thanks for choosing <strong>Laravel Porto</strong> as your eCommerce theme.
                                </div>
                                <p>Our <strong>Porto eCommerce</strong> theme has well-organized, easily understandable project structure, supports superfast data processing, works pretty well on different kinds of browsers, including Chrome, Edge, Firefox, Safari, and so on.</p>
                                <br />
                                <p class="porto-setup-actions step">
                                    <a
                                        href="{{ url('installer/status') }}"
                                        class="btn-primary btn button-next"
                                    >
                                        Continue
                                        <i class="fas fa-chevron-right ml-2"></i>
                                    </a>
                                </p>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
		var baseUrl = "{{ url('/') }}";
    </script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script>
		window.addEventListener('load', function() {
			document.querySelector("body").classList.add('loaded');
        });
	</script>
</body>
</html>
