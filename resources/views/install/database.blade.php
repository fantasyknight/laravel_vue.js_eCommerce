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
        <form action="{{ url('/installer/database') }}" method="post" id="wizard-form">
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
                        <a class="nolink active" href="#database">Database</a>
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
                    <div class="tab-pane fade in show active" id="database">
                        <div class="row">
                            <aside class="customize col-sm-3"></aside>
                            <section class="col-sm-9">
                                @if($errors->has('database'))
                                    <div class="error-message mb-3 row">
                                        <p class="mb-0">{{ $errors->first('database') }}</p>
                                    </div>
                                @endif
                                <h2>Database Setting</h2>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">HostName</label>
                                    <input type="text" class="form-control col-md-9" name="hostname" value="{{ old('hostname', 'localhost') }}" />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Database Port</label>
                                    <input type="number" min="0" class="form-control col-md-9" name="port" value="{{ old('port', '3306') }}" />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Database Name</label>
                                    <input type="text" class="form-control col-md-9" name="db_name" required value="{{ old('db_name', env('DB_DATABASE')) }}" />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Database Username</label>
                                    <input type="text" class="form-control col-md-9" name="db_user" required value="{{ old('db_user', 'root') }}" />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Database Password</label>
                                    <input type="text" class="form-control col-md-9" name="db_password" value="{{ old('db_password') }}" />
                                </div>
                                <br />
                                <p class="porto-setup-actions step mt-0">
                                    <button
                                        type="submit"
                                        class="btn-primary btn button-next position-relative"
                                        data-callback="install_plugins"
                                    >
                                        <div class="d-loading-container">
                                            <div class="d-loading small"></div>
                                        </div>
                                        Continue
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

        $(document).ready( function () {
            $('#wizard-form').submit( function () {
                $('.button-next').addClass('loading');
            } );
        } );
	</script>
</body>
</html>
