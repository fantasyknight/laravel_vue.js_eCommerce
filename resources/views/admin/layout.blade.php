<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="modern fixed has-top-menu has-left-sidebar-half sidebar-left-sm">
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Laravel porto" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel Porto</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('server/images/icons/favicon.ico') }}">
    <!-- Fonts -->
    <script type="text/javascript">
		WebFontConfig = {
			google: { families: [ 'Open+Sans:400,600,700','Poppins:400,500,600,700' ] }
		};
		(function(d) {
			var wf = d.createElement('script'), s = d.scripts[0];
			wf.src = "{{ asset('client/vendor/webfont.js') }}";
			wf.async = true;
			s.parentNode.insertBefore(wf, s);
		})(document);
	</script>

    <!-- Vendor Css -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/pnotify/pnotify.custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/magnific-popup/magnific-popup.css') }}">
    @yield('vendor-css')

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('server/css/theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('server/css/custom.css') }}" />
    <!-- Theme Custom CSS -->
    @yield('custom-css')

    <!-- Theme Skin CSS -->
    @yield('skin-css')

    <!-- Head Libs -->
    <script src="{{ asset('vendor/modernizr/modernizr.js') }}"></script>

</head>
<body>
    <div class="loading-overlay">
        <div class="bounce-loader">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <div id="app">
        <!-- start: header -->
        <header class="header header-nav-menu header-nav-links">
            <div class="logo-container">
                <a href="../" class="logo">
                    <img src="{{ asset('server/images/logo-modern.png') }}" class="logo-image" width="90" height="24" alt="Porto Admin" /><img src="{{ asset('server/images/logo-default.png') }}" class="logo-image-mobile" width="90" height="41" alt="Porto Admin" />
                </a>
                <button class="btn header-btn-collapse-nav d-md-none" data-toggle="collapse" data-target=".header-nav">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="header-nav show d-none d-md-block">
                    <div class="header-nav-main"><a href="{{ url('/') }}" class="text-body" target="_blank"><strong>Visit Site <i class="fas fa-angle-double-right ml-1"></i></strong></a></div>
                </div>

                <div class="header-nav collapse">
                    <div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1 header-nav-main-square">
                        <nav>
                            <ul class="nav nav-pills" id="mainNav">
                                <li class="">
                                    <a class="nav-link" href="{{ url('admin/dashboard') }}">
                                        Dashboard
                                    </a>    
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#">
                                        Media
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="nav-link" href="{{ url('admin/media/grid') }}">
                                                Media Gallery
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ url('admin/media/create') }}">
                                                Add New
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ url('admin/media/setting') }}">
                                                Media Settings
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#">
                                        Comments
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="nav-link" href="{{ url('/admin/products/reviews') }}">
                                                Product Reviews
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ url('/admin/posts/comments') }}">
                                                Blog Replies
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#">
                                        eCommerce
                                    </a>
                                    <ul class="dropdown-menu">
                                        @if(config('setting.enable_coupon'))
                                        <li>
                                            <a class="nav-link" href="{{ url('admin/ecommerce/coupons') }}">
                                                Coupons
                                            </a>
                                        </li>
                                        @endif
                                        <li>
                                            <a class="nav-link" href="{{ url('admin/ecommerce/orders') }}">
                                                Orders
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ url('admin/ecommerce/customers') }}">
                                                Customers
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ url('admin/ecommerce/reports') }}">
                                                Reports
                                            </a>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a class="nav-link" href="#">
                                                Settings
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="nav-link" href="{{ url('admin/ecommerce/settings/general') }}">
                                                        General
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" href="{{ url('admin/ecommerce/settings/product') }}">
                                                        Products
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" href="{{ url('admin/ecommerce/settings/shipping') }}">
                                                        Shipping
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" href="{{ url('admin/ecommerce/settings/payment') }}">
                                                        Payment
                                                    </a>
                                                </li>
                                                @if(config('setting.enable_tax'))
                                                <li>
                                                    <a class="nav-link" href="{{ url('admin/ecommerce/settings/tax') }}">
                                                        Tax
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#">
                                        Products
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="nav-link" href="{{ url('admin/products') }}">
                                                All Products
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ url('admin/categories/product') }}">
                                                Categories
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ url('admin/products/attributes') }}">
                                                Attributes
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ url('/admin/tags/product') }}">
                                                Tags
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#">
                                        Posts
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="nav-link" href="{{ url('admin/posts') }}">
                                                All Posts
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ url('admin/posts/create') }}">
                                                New Post
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ url('/admin/categories/post') }}">
                                                Categories
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ url('/admin/tags/post') }}">
                                                Tags
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#">
                                        User
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="nav-link" href="{{ url('/admin/users') }}">
                                                All Users
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="{{ url('/admin/users/create') }}">
                                                New User
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                
                                <li class="dropdown">
                                    <a class="nav-link" href="{{ url('/admin/theme-settings') }}">
                                        Theme Settings
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- start: search & user box -->
            <div class="header-right">
                <notifications-component role-id="{{ Auth::user()->role_id }}"></notifications-component>

                <span class="separator"></span>
                
                @if(Auth::check())
                    <div id="userbox" class="userbox">
                        <a href="#" data-toggle="dropdown">
                            <span class="profile-picture profile-picture-as-text">Me</span>
                            <div class="profile-info profile-info-no-role" data-lock-name="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" data-lock-email="{{ Auth::user()->email }}">
                                <span class="name">Hi, <strong class="font-weight-semibold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong></span>
                            </div>
                            
                            <i class="fas fa-chevron-down text-color-dark"></i>
                        </a>

                        <div class="dropdown-menu">
                            <ul class="list-unstyled">
                                <li>
                                    <a role="menuitem" tabindex="-1" href="{{ url('admin/users/' . Auth::user()->id . '/edit') }}"><i class="bx bx-user"></i> My Profile</a>
                                </li>
                                <li>
                                    <a role="menuitem" tabindex="-1" href="{{ url('admin/logout') }}"><i class="bx bx-log-out"></i> Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
            <!-- end: search & user box -->
        </header>
        <!-- end: header -->

        <div class="inner-wrapper">
            <input type="hidden" id="base-url" value="{{ url('/') }}" />
            
            <!-- start: sidebar -->
            @yield('sidebar')
            <!-- end: sidebar -->

            <section role="main" class="content-body content-body-modern mt-0">
                @yield('page-content')
                <!-- end: page -->
            </section>
        </div>
    </div>
    
    <!-- Vendor -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
    <script src="{{ asset('vendor/popper/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/nanoscroller/nanoscroller.js') }}"></script>
    <script src="{{ asset('vendor/pnotify/pnotify.custom.js') }}"></script>
    <script src="{{ asset('vendor/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    
    <script>
        var baseUrl = "{{ url('/') }}";
    </script>
    
    @yield('vendor-js')
    
    <!-- Vue JS -->
    <script src="{{ asset('server/js/app.js') }}"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('server/js/theme.min.js') }}"></script>
    
    <!-- Theme Custom -->
    <script src="{{ asset('server/js/custom.min.js') }}"></script>
    
    <!-- Theme Initialization Files -->
    <script src="{{ asset('server/js/theme.init.min.js') }}"></script>

    <script>
        var portoStorage = JSON.parse(window.localStorage.getItem('porto-single'));
        if (portoStorage) {
            portoStorage.user = {
                data: JSON.parse(`{!! json_encode(Auth::user()) !!}`),
                token: '{{ csrf_token() }}'
            };

            window.localStorage.setItem('porto-single', JSON.stringify(portoStorage));
        } else {
            window.localStorage.setItem('porto-single', JSON.stringify({
                user: {
                    data: JSON.parse(`{!! json_encode(Auth::user()) !!}`),
                    token: '{{ csrf_token() }}'
                }
            }))
        }
        window.addEventListener('load', function () {
            document.querySelector("body").classList.add('loaded');
		})
    </script>
    <!-- Page Js -->
    @yield('page-js')
    @stack('scripts')
    
</body>

</html>
