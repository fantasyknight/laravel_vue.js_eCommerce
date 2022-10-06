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
        <form action="{{ url('/installer/admin') }}" method="post" id="wizard-form">
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
                        <a class="nolink active" href="#admin">Admin Setting</a>
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
                    <div class="tab-pane fade in show active" id="admin">
                        <div class="row">
                            <aside class="default_plugins col-sm-3"></aside>
                            <section class="col-sm-9">
                                @if($errors->has('password'))
                                    <div class="error-message mb-3 row">
                                        <p class="mb-0">{{ $errors->first('password') }}</p>
                                    </div>
                                @endif
                                @if($errors->has('admin'))
                                    <div class="error-message mb-3 row">
                                        <p class="mb-0">{{ $errors->first('admin') }}</p>
                                    </div>
                                @endif
                                <h2>Admin Setting</h2>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">First Name</label>
                                    <input type="text" class="form-control col-md-9" name="first_name" value="{{ old('first_name') }}" required />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Last Name</label>
                                    <input type="text" class="form-control col-md-9" name="last_name" value="{{ old('last_name') }}" required />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Email</label>
                                    <input type="email" class="form-control col-md-9" name="email" required value="{{ old('email') }}" />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Password</label>
                                    <input type="password" class="form-control col-md-9" name="password" required />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Password Confirm</label>
                                    <input type="password" class="form-control col-md-9" name="password_confirmation" required />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">User Description</label>
                                    <textarea type="text" class="form-control col-md-9" rows="5" maxlength="255" name="description">{{ old('description') }}</textarea>
                                </div>
                                <br />
                                <p class="porto-setup-actions my-0 step">
                                    <button
                                        type="submit"
                                        class="btn-primary btn button-next position-relative"
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
