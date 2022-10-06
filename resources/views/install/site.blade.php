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
	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800" media="all">

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
        <form action="{{ url('/installer/site') }}" method="post" id="wizard-form">
            @csrf
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
                        <a href="{{ url('installer/welcome') }}">Welcome</a>					
                    </li>
                    <li>
                        <a href="{{ url('installer/status') }}">Status</a>
                    </li>
                    <li>
                        <a href="{{ url('installer/database') }}">Database</a>
                    </li>
                    <li>
                        <a href="{{ url('installer/admin') }}">Admin Setting</a>
                    </li>
                    <li>
                        <a href="{{ url('installer/demo') }}">Demo Import</a>
                    </li>
                    <li>
                        <a href="{{ url('installer/site') }}" class="nolink active">Site Setting</a>
                    </li>
                    <li>
                        <a class="nolink" href="#">Ready!</a>
                    </li>
                </ol>
                <div class="col-12 tab-content">
                    <div class="tab-pane fade in show active" id="site">
                        <div class="row">
                            <aside class="help_support col-sm-3"></aside>
                            <section class="col-sm-9">
                                <h2>Configure Site Url!</h2>

                                <p>It is time to configure site url. It is very important for shared web hosting. The standard site url is <strong>{{ env('DEMO') }}</strong> because the project is installed in <strong>{{ env('DEMO') }}</strong> directory.<br />
                                For example, if you unzip and run project just in htdocs using xampp server, please configure it as <strong>{{ env('DEMO') }}</strong> only, Otherwise you should configure <strong>webpack.min.js</strong> and build the project using <strong>npm run build</strong> command after setup. 
                                Please refer to <a href="https://d-themes.com/laravel/porto/porto-docs" target="_blank">documentation</a>.</p>

                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">site shared hosting url</label>
                                    <input type="text" class="form-control col-md-9" name="app-url" value="{{ env('DEMO') }}" />
                                </div>

                                <p class="porto-setup-actions step">
                                    <a
                                        class="btn btn-borders"
                                        href="{{ url('/installer/ready') }}"
                                    >
                                        Skip this step
                                        <i class="fas fa-chevron-right ml-2"></i>
                                    </a>
                                    <button class="btn btn-primary" type="submit">
                                        Change App Url
                                        <i class="fas fa-chevron-right ml-2"></i>
                                    </button>
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
