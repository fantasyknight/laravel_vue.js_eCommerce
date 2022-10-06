<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

	<title>Porto - Bootstrap eCommerce Template</title>

	<meta name="keywords" content="HTML5 Template" />
	<meta name="description" content="Porto - Bootstrap eCommerce Template">
	<meta name="author" content="SW-THEMES">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    

	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="{{ asset('client/images/icons/favicon.ico') }}">
	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800%7CPoppins:300,400,500,600,700,800" media="all">

	<!-- Plugins CSS File -->
	<link rel="stylesheet" href="{{ asset('client/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/pnotify/pnotify.custom.css') }}" />
	<!-- Main CSS File -->
	<link rel="stylesheet" href="{{ asset('server/css/installer.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/font-awesome/css/all.min.css') }}">
    <style>
        .ui-pnotify-icon span {
            line-height: 32px;
        }
    </style>
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
                    <a class="nolink active" href="#status">Status</a>
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
                <div class="tab-pane fade in show active" id="status">
                    <div class="row">
                        <aside class="status col-sm-3"></aside>
                        <section class="col-sm-9">
                            @if(floatval(phpversion()) < 7.2)
                                <div class="error-message mb-3 row">
                                    <p class="mb-0">Please check your php version. <a target="_blank" href="{{ url('installer/phpinfo') }}">php_info()</a></p>
                                </div>
                            @endif
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
                                        @if(floatval(ini_get('max_execution_time')) >= 120)
                                            <i class="status yes fas fa-check"></i>
                                        @else
                                            <i class="status no fas fa-ban"></i>
                                        @endif

                                        <span class="label">
                                            Max execution time:
                                            <em>{{ ini_get('max_execution_time') }}</em> (minimum 120)
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
                                        <a target="_blank" href="{{ url('installer/phpinfo') }}">php_info()</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="activation mt-5">
                                <h6>Enter your activation code</h6>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 mb-2">
                                            <input type="password" id="activation" class="form-control h-100" value="{{ $activation_key }}" />
                                        </div>
                                        <div class="col-sm-6 mb-2 d-flex align-items-center">
                                            @if(! $activated)
                                            <button type="button" class="btn btn-primary mb-0 activate position-relative">
                                                <div class="d-loading-container">
                                                    <div class="d-loading small"></div>
                                                </div>
                                                Activate
                                            </button>
                                            @else
                                            <label for="" class="text-primary">Activated</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($activated)
                            <p class="porto-setup-actions step">
                                <a
                                    @if (floatval(phpversion()) > 7.2 && {{-- floatval(ini_get('max_execution_time')) >= 120  && --}} floatval(ini_get('upload_max_filesize')) >= 2)
                                        href="{{ url('installer/database') }}"
                                    @else href="#"
                                    @endif
                                    class="btn-primary btn button-next"
                                    data-callback="install_plugins"
                                >
                                    Continue
                                    <i class="fas fa-chevron-right ml-2"></i>
                                </a>
                            </p>
                            @endif
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
		var baseUrl = "{{ url('/') }}";
    </script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/pnotify/pnotify.custom.js') }}"></script>
	<script>
		window.addEventListener('load', function() {
			document.querySelector("body").classList.add('loaded');
        });

        $(document).ready(function () {
            window.localStorage.clear();
            $(".activate").click(function (e) {
                var code = $("#activation").val();
                if(! code || code == '') {
                    new PNotify({
                        title: 'Warning',
                        text: 'Please input activation code.',
                        type: 'error',
                        addclass: 'notification-warning',
                        icon: 'fas fa-exclamation'
                    });
                    return;
                }

                let $button = $(this);

                $(this).addClass("loading");

                $.ajax({
                    url: 'https://d-themes.com/laravel/porto/activation-server/api/activate',
                    type: 'get',
                    data: {
                        key: code,
                        item_id: '123456',                                               
                        domain: document.domain,
                        type: 'single'
                    },
                    success: function (response) {
                        if (response.key && response.activated) {
                            $.ajax({
                                url: baseUrl + '/installer/activate',
                                type: 'post',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    key: response.key,
                                    activated: response.activated
                                },
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                success: function () {
                                    location.reload();
                                },
                                error: function () {
                                    $button.removeClass("loading");
                                    new PNotify({
                                        title: 'Error',
                                        text: 'Error found validating purchase code.',
                                        type: 'error',
                                        addclass: 'notification-error',
                                        icon: 'fas fa-times'
                                    });
                                }
                            });
                        } else {
                            $button.removeClass("loading");
                            new PNotify({
                                title: 'Error',
                                text: 'Error found validating purchase code.',
                                type: 'error',
                                addclass: 'notification-error',
                                icon: 'fas fa-times'
                            });
                        }
                    },
                    error: function () {
                        $button.removeClass("loading");
                        new PNotify({
                            title: 'Error',
                            text: 'Error found validating purchase code.',
                            type: 'error',
                            addclass: 'notification-error',
                            icon: 'fas fa-times'
                        });
                    }
                });
            })
        });
	</script>
</body>
</html>
