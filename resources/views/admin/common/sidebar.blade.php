<aside id="sidebar-left" class="sidebar-left">		
    <div class="sidebar-header">
        <div class="sidebar-title">
            Navigation
        </div>
        <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <form action="#" method="get" class="search-wrapper mt-3 mb-2 menu-search-wrapper">
                <input type="text" autocomplete="false" placeholder="Search..." required="required" class="form-control mb-0 text-white" id="menu-search" onkeyup="menuSearch(event)">
            </form>

            <nav id="menu" role="navigation">
                <ul class="nav nav-main">
                    <li class="{{ Request::is('admin/dashboard') ? 'nav-expanded' : '' }}">
                        <a class="nav-link" href="{{ url('admin/dashboard') }}">
                            <i class="bx bx-home" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>                        
                    </li>
                    @if (Auth::user()->role_id != 4 || config('setting.vendor_allow_media') == '1' )
                    <li class="nav-parent {{ strpos(Request::url(), 'admin/media/') ? 'nav-expanded' : '' }}">
                        <a class="nav-link" href="#">
                            <i class="bx bx-images" aria-hidden="true"></i>
                            <span>Media</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="{{ Request::is('admin/media/grid') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('admin/media/grid') }}">
                                    <span>Media Gallery</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/media/create') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('admin/media/create') }}">
                                    <span>Add New</span>
                                </a>
                            </li>
                            @cannot('vendor-role')
                            <li class="{{ Request::is('admin/media/setting') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('admin/media/setting') }}">
                                    <span>Media Settings</span>
                                </a>
                            </li>
                            @endcannot
                        </ul>
                    </li>
                    @endif
                    @cannot('vendor-role')
                        <li class="nav-parent {{ strpos(Request::url(), '/comments') ? 'nav-expanded' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="bx bx-comment-detail" aria-hidden="true"></i>
                                <span>Comments</span>
                            </a>
                            <ul class="nav nav-children">
                                <li class="{{ Request::is('admin/products/comments') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/admin/products/comments') }}">
                                        <span>Product Reviews</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/posts/comments') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/admin/posts/comments') }}">
                                        <span>Post Replies</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcannot

                    <li class="nav-parent {{ strpos(Request::url(), 'admin/ecommerce/') ? 'nav-expanded' : '' }}">
                        <a class="nav-link" href="#">
                            <i class="bx bx-cart-alt" aria-hidden="true"></i>
                            <span>eCommerce</span>
                        </a>
                        <ul class="nav nav-children">
                            @cannot('vendor-role')
                                @if(config('setting.enable_coupon'))
                                    <li class="{{ Request::is('admin/ecommerce/coupons') ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ url('admin/ecommerce/coupons') }}">
                                            <span>Coupons</span>
                                        </a>
                                    </li>
                                @endif
                            @endcannot
                            <li class="{{ Request::is('admin/ecommerce/orders') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('admin/ecommerce/orders') }}">
                                    <span>Orders</span>
                                </a>
                            </li>
                            @cannot('vendor-role')
                                <li class="{{ Request::is('admin/ecommerce/customers') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/ecommerce/customers') }}">
                                        <span>Customers</span>
                                    </a>
                                </li>
                                <li class="nav-parent {{ strpos(Request::url(), 'admin/ecommerce/reports/') ? 'nav-expanded' : '' }}">
                                    <a class="nav-link" href="#">
                                        <span>Reports</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <li class="{{ Request::is('admin/ecommerce/reports/orders') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/ecommerce/reports/orders') }}">
                                                <span>Orders</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('admin/ecommerce/reports/customers') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/ecommerce/reports/customers') }}">
                                                <span>Customers</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('admin/ecommerce/reports/stock') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/ecommerce/reports/stock') }}">
                                                <span>Stock</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ strpos(Request::url(), 'admin/ecommerce/settings/') ? 'nav-expanded' : '' }}">
                                    <a class="nav-link" href="#">
                                        <span>Settings</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <li class="{{ Request::is('admin/ecommerce/settings/general') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/ecommerce/settings/general') }}">
                                                <span>General</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('admin/ecommerce/settings/product') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/ecommerce/settings/product') }}">
                                                <span>Products</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('admin/ecommerce/settings/shipping') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/ecommerce/settings/shipping') }}">
                                                <span>Shipping</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('admin/ecommerce/settings/payment') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/ecommerce/settings/payment') }}">
                                                <span>Payment</span>
                                            </a>
                                        </li>
                                        @if(config('setting.enable_tax'))
                                        <li class="{{ Request::is('admin/ecommerce/settings/tax') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/ecommerce/settings/tax') }}">
                                                <span>Tax</span>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                            @else
                                <li class="{{ Request::is('admin/ecommerce/vendor-setting') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/ecommerce/vendor-setting') }}/{{ Auth::user()->id }}">
                                        <span>Settings</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/ecommerce/vendor-withdraw') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/ecommerce/vendor-withdraw') }}">
                                        <span>Withdraw</span>
                                    </a>
                                </li>
                            @endcannot
                        </ul>
                    </li>

                    @if (Auth::user()->role_id != 4 && config('setting.multivendor') )
                        <li class="nav-parent {{ strpos(Request::url(), 'admin/multivendor') ? 'nav-expanded' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="bx bx-album" aria-hidden="true"></i>
                                <span>Multivendor</span>
                            </a>
                            <ul class="nav nav-children">
                                <li class="{{ Request::is('admin/multivendor/vendor') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/multivendor/vendor') }}">
                                        <span>Vendors</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/multivendor/withdraw') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/multivendor/withdraw') }}">
                                        <span>Withdraws</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/multivendor/setting') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/multivendor/setting') }}">
                                        <span>Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (Auth::user()->role_id != 4 || config('setting.vendor_allow_product') == '1' )
                        <li class="nav-parent {{ ! strpos(Request::url(), 'admin/products/comments') && strpos(Request::url(), 'admin/products') || Request::is('admin/categories/product') || Request::is('admin/tags/product')  ? 'nav-expanded' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="bx bx-gift" aria-hidden="true"></i>
                                <span>Products</span>
                            </a>
                            <ul class="nav nav-children">
                                <li class="{{ Request::is('admin/products') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/products') }}">
                                        <span>All Products</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/products/create') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/products/create') }}">
                                        <span>New Product</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/categories/product') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/categories/product') }}">
                                        <span>Categories</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/products/attributes') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/products/attributes') }}">
                                        <span>Attributes</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/tags/product') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/tags/product') }}">
                                        <span>Tags</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    
                    @if (Auth::user()->role_id != 4 || config('setting.vendor_allow_post') == '1' )
                        <li class="nav-parent {{ ! strpos(Request::url(), 'admin/posts/comments') && strpos(Request::url(), 'admin/posts') || strpos(Request::url(), 'admin/categories/post') || strpos(Request::url(), 'admin/tags/post') ? 'nav-expanded' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="bx bx-calendar" aria-hidden="true"></i>
                                <span>Post</span>
                            </a>
                            <ul class="nav nav-children">
                                <li class="{{ Request::is('admin/posts') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/posts') }}">
                                        <span>All Posts</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/posts/create') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/posts/create') }}">
                                        <span>New Post</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/categories/post') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/categories/post') }}">
                                        <span>Categories</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/tags/post') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/tags/post') }}">
                                        <span>Tags</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @cannot('vendor-role')
                        <li class="nav-parent {{ strpos(Request::url(), 'admin/users') ? 'nav-expanded' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="bx bx-user" aria-hidden="true"></i>
                                <span>User</span>
                            </a>
                            <ul class="nav nav-children">
                                <li class="{{ Request::is('admin/users') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/users') }}">
                                        <span>All Users<span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/users/create') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/users/create') }}">
                                        <span>New User<span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-parent {{ strpos(Request::url(), 'admin/customize') ? 'nav-expanded' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="bx bx-atom" aria-hidden="true"></i>
                                <span>Customize</span>
                            </a>
                            <ul class="nav nav-children">
                                <li class="{{ Request::is('admin/customize/menu') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/customize/menu') }}">
                                        <span>Menu</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('admin/theme-settings') }}">
                                <i class="bx bx-cog" aria-hidden="true"></i>
                                <span>Theme Settings</span>
                            </a>
                        </li>
                    @endcannot
                </ul>
            </nav>

            <nav id="search-menu" role="navigation">
                <ul style="list-style: none" class="pl-4"></ul>
            </nav>
        </div>
        
    </div>
</aside>

@push('scripts')
    <script>
        function menuSearch(event) {
            if(event.key === 'enter') event.preventDefault();

            var filter, items;
            filter = $('#menu-search').val().toUpperCase();
            items = $('#menu').find('a').filter(function(i, item) {
                if($(item).find('span')[0].innerText.toUpperCase().indexOf(filter) > -1) {
                    return item;
                }
            });

			if(filter !== ''){
				$("#menu").addClass('d-none');
				$("#search-menu ul").html('');
				if(items.length > 0) {
					for (i = 0; i < items.length; i++) {
						const text = $(items[i]).find("span")[0].innerText;
						const link = $(items[i]).attr('href');
                        
                        if(link !== '#') {
                            $("#search-menu ul").append(`<li><a href="${link}" class="nav-link text-white"><i class="fa-arrow-right fa mr-2"></i><span>${text}</span></a></li`);
                        }
                    }
				} else {
					$("#search-menu ul").html(`<li><span class="nav-link text-white">Nothing Found</span></li>`);
				}
			} else {
				$("#menu").removeClass('d-none');
				$("#search-menu ul").html('');
			}
        }
    </script>
@endpush