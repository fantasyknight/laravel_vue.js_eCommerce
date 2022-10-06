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
                        <a data-toggle="tab" class="nolink active" href="#welcome">Welcome</a>					
                    </li>
                    <li>
                        <a data-toggle="tab" class="nolink" href="#status">Status</a>
                    </li>
                    <li>
                        <a data-toggle="tab" class="nolink" href="#database">Database</a>
                    </li>
                    <li>
                        <a data-toggle="tab" class="nolink" href="#admin">Admin Setting</a>
                    </li>
                    <li>
                        <a data-toggle="tab" class="nolink" href="#demo">Demo Import</a>
                    </li>
                    <li>
                        <a href="#site-settting" class="nolink">Site Setting</a>
                    </li>
                    <li>
                        <a data-toggle="tab" class="nolink" href="#" class="nolink">Ready!</a>
                    </li>
                </ol>
                <div class="col-12 tab-content">
                    <div class="tab-pane fade in show active" id="welcome">
                        <div class="row">
                            <aside class="updates col-sm-3"></aside>
                            <section class="col-sm-9">
                                <h2>Welcome to Laravel Porto eCommerce Template</h2>
                                <div class="notice-success notice-alt notice-large mb-4">
                                    Thanks for choosing <strong>Laravel Porto</strong> as your eCommerce template.
                                </div>
                                <p>Our <strong>Porto eCommerce</strong> Template has well-organized, easily understandable project structure, supports superfast data processing, works pretty well on different kinds of browsers, including Chrome, IE, Edge, Firefox, Safari, and so on.</p>
                                <br />
                                <p class="porto-setup-actions step">
                                    <a
                                        href="#status"
                                        class="btn-primary btn button-next"
                                    >
                                        Continue
                                        <i class="fas fa-chevron-right ml-2"></i>
                                    </a>
                                </p>
                            </section>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="status">
                        <div class="row">
                            <aside class="status col-sm-3"></aside>
                            <section class="col-sm-9">
                                <h2>System Status</h2>

                                <div class="porto_mini_status">
                                    <ul class="system-status">
                                        <li>
                                            @if(floatval(phpversion()) > 7.2)
                                                <i class="status yes fas fa-check"></i>
                                            @else
                                                <i class="status no fas fa-ban"></i>
                                            @endif
                                            <span class="label">Php Version <em>{{ phpversion() }}</em> (minimum 7.2)</span>
                                        </li>

                                        <li>
                                            @if(floatval(ini_get('max_execution_time')) > 180)
                                                <i class="status yes fas fa-check"></i>
                                            @else
                                                <i class="status no fas fa-ban"></i>
                                            @endif

                                            <span class="label">
                                                Max execution time:
                                                <em>{{ ini_get('max_execution_time') }}</em> (minimum 180)
                                            </span>
                                        </li>

                                        <li>
                                            @if(floatval(ini_get('upload_max_filesize')) >= 2)
                                                <i class="status yes fas fa-check"></i>
                                            @else
                                                <i class="status no fas fa-ban"></i>
                                            @endif
                                            <span class="label">
                                                Upload max filesize
                                                <em>{{ ini_get('upload_max_filesize') }}</em> (minimum 2MB)
                                            </span>
                                        </li>
                                        <li class="info">
                                            php.ini values are shown above. Real values may vary, please check your limits using
                                            <a target="_blank" href="#">php_info()</a>
                                        </li>
                                    </ul>
                                </div>
                                <p class="porto-setup-actions step">
                                    <a
                                        href="#database"
                                        class="btn-primary btn button-next"
                                        data-callback="install_plugins"
                                    >
                                        Continue
                                        <i class="fas fa-chevron-right ml-2"></i>
                                    </a>
                                </p>
                            </section>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="database">
                        <div class="row">
                            <aside class="customize col-sm-3"></aside>
                            <section class="col-sm-9">
                                <h2>Database Setting</h2>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">HostName</label>
                                    <input type="text" class="form-control col-md-9" name="hostname" value="127.0.0.1" />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Database Port</label>
                                    <input type="number" min="0" class="form-control col-md-9" name="port" value="3306" />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Database Name</label>
                                    <input type="text" class="form-control col-md-9" name="db_name" required />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Database Username</label>
                                    <input type="text" class="form-control col-md-9" name="db_user" required />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Database Password</label>
                                    <input type="text" class="form-control col-md-9" name="db_password" />
                                </div>
                                <br />
                                <p class="porto-setup-actions step mt-0">
                                    <a
                                        href="#admin"
                                        class="btn-primary btn button-next"
                                        data-callback="install_plugins"
                                    >
                                        Continue
                                        <i class="fas fa-chevron-right ml-2"></i>
                                    </a>
                                </p>
                            </section>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="admin">
                        <div class="row">
                            <aside class="default_plugins col-sm-3"></aside>
                            <section class="col-sm-9">
                                <h2>Admin Setting</h2>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">First Name</label>
                                    <input type="text" class="form-control col-md-9" name="first_name" required />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Last Name</label>
                                    <input type="text" class="form-control col-md-9" name="last_name" required />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Email</label>
                                    <input type="email" class="form-control col-md-9" name="email" required />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Password</label>
                                    <input type="text" class="form-control col-md-9" name="password" required />
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-3 mb-0">Password Confirm</label>
                                    <input type="text" class="form-control col-md-9" name="password_confirmation" />
                                </div>
                                <br />
                                <p class="porto-setup-actions step">
                                    <a
                                        href="#demo"
                                        class="btn-primary btn button-next"
                                        data-callback="install_plugins"
                                    >
                                        Continue
                                        <i class="fas fa-chevron-right ml-2"></i>
                                    </a>
                                </p>
                            </section>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="demo">
                        <div class="row">
                            <aside class="demo_content col-sm-3"></aside>
                            <section class="col-sm-9">
                                <h2>Import demo for initial data</h2>
                                <div class="demo-container">
                                    <img class="demo-img" src="{{ asset('/server/images/shop4.jpg') }}" alt="demo" />
                                </div>
                                <p class="porto-setup-actions step">
                                    <input class="btn btn-dark" name="skip" type="submit" value="Skip this step" />
                                    <a
                                        href="#nothing"
                                        class="btn-primary btn button-next"
                                        data-callback="install_plugins"
                                        id="demo-import-btn"
                                    >
                                        Continue
                                        <i class="fas fa-chevron-right ml-2"></i>
                                    </a>
                                </p>
                                <input type="hidden" id="demo-import" name="demo_import" value="0" />
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

        $(document).ready(function() {
            $(".porto-setup-actions a").click(function(e) {
                e.preventDefault();
                $(".nav-tabs a[href='" + $(this).attr("href") + "']").click();
            });

            $("#demo-import-btn").click(function(e) {
                e.preventDefault();
                $("#demo-import").val(1);
                $("#wizard-form").submit();
            })
        });
	</script>
</body>
</html>
