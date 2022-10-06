import VueRouter from "vue-router";

function page ( path ) {
    return () => import( `./components/${ path }` ).then( m => m.default || m );
}

const baseUrl = window.baseUrl.slice( window.origin.length );

const router = new VueRouter( {
    mode: 'history',
    base: baseUrl,
    routes: [
        {
            path: '/', component: page( 'IndexComponent.vue' )
        },
        {
            path: '/vendors',
            component: { template: '<router-view></router-view>' },
            children: [
                {
                    path: 'grid',
                    component: page( 'vendor/VendorGridComponent.vue' )
                },
                {
                    path: 'list',
                    component: page( 'vendor/VendorListComponent.vue' )
                },
                {
                    path: ':id',
                    component: page( 'vendor/VendorSingleComponent.vue' )
                }
            ]
        },
        {
            path: '/shop',
            component: { template: '<router-view></router-view>' },
            children: [
                {
                    path: 'default', component: page( 'shop/ShopDefaultComponent.vue' )
                },
                {
                    path: 'list', component: page( 'shop/ShopListComponent.vue' )
                },
                {
                    path: 'infinite-scroll', component: page( 'shop/ShopInfiniteScrollComponent.vue' )
                },
                {
                    path: 'horizontal-filter1', component: page( 'shop/ShopHorizontalFilterOneComponent.vue' )
                },
                {
                    path: 'horizontal-filter2', component: page( 'shop/ShopHorizontalFilterTwoComponent.vue' )
                },
                {
                    path: 'boxed-image', component: page( 'shop/ShopBoxedImageComponent.vue' )
                },
                {
                    path: 'boxed-slider', component: page( 'shop/ShopBoxedSliderComponent.vue' )
                },
                {
                    path: 'left-sidebar', component: page( 'shop/ShopDefaultComponent.vue' )
                },
                {
                    path: 'right-sidebar', component: page( 'shop/ShopRightSidebarComponent.vue' )
                },
                {
                    path: 'off-canvas', component: page( 'shop/ShopOffCanvasFilterComponent.vue' )
                },
                {
                    path: '3cols', component: page( 'shop/ShopDefaultComponent.vue' )
                },
                {
                    path: '4cols', component: page( 'shop/ShopBoxedSliderComponent.vue' )
                },
                {
                    path: '5cols', component: page( 'shop/ShopGridComponent.vue' )
                },
                {
                    path: '6cols', component: page( 'shop/ShopGridComponent.vue' )
                },
                {
                    path: '7cols', component: page( 'shop/ShopGridComponent.vue' )
                },
                {
                    path: '8cols', component: page( 'shop/ShopGridComponent.vue' )
                }
            ]
        },
        {
            path: '/product',
            component: { template: '<router-view></router-view>' },
            children: [
                {
                    path: 'default/:slug', component: page( 'products/ProductDefaultComponent.vue' )
                },
                {
                    path: 'custom-tab/:slug', component: page( 'products/ProductCustomTabComponent.vue' )
                },
                {
                    path: 'left-sidebar/:slug', component: page( 'products/ProductLeftSidebarComponent.vue' )
                },
                {
                    path: 'right-sidebar/:slug', component: page( 'products/ProductRightSidebarComponent.vue' )
                },
                {
                    path: 'cart-sticky/:slug', component: page( 'products/ProductAddCartStickyComponent.vue' )
                },
                {
                    path: 'grid/:slug', component: page( 'products/ProductGridImageComponent.vue' )
                },
                {
                    path: 'extended/:slug', component: page( 'products/ProductExtendedComponent.vue' )
                },
                {
                    path: 'fullwidth/:slug', component: page( 'products/ProductFullwidthComponent.vue' )
                },
                {
                    path: 'sticky-right/:slug', component: page( 'products/ProductStickyRightComponent.vue' )
                },
                {
                    path: 'sticky-both/:slug', component: page( 'products/ProductStickyBothComponent.vue' )
                },
                {
                    path: 'center-vertical/:slug', component: page( 'products/ProductCenterVerticalComponent.vue' )
                }
            ]
        },
        {
            path: '/pages',
            component: { template: '<router-view></router-view>' },
            children: [
                {
                    path: '/', component: page( 'pages/ShoppingCartComponent.vue' )
                },
                {
                    path: 'about-us', component: page( 'pages/AboutUsComponent.vue' )
                },
                {
                    path: 'cart', component: page( 'pages/ShoppingCartComponent.vue' )
                },
                {
                    path: 'wishlist', component: page( 'pages/WishlistComponent.vue' )
                },
                {
                    path: 'checkout', component: page( 'pages/CheckoutComponent.vue' )
                },
                {
                    path: 'order/:id', component: page( 'pages/OrderCompleteComponent.vue' )
                },
                {
                    path: 'contact-us', component: page( 'pages/ContactUsComponent.vue' )
                },
                {
                    path: 'login', component: page( 'pages/LoginComponent.vue' )
                },
                {
                    path: 'forgot-pwd', component: page( 'pages/ForgotPasswordComponent.vue' )
                },
                {
                    path: 'blog',
                    component: page( 'pages/blog/BlogLayoutComponent.vue' ),
                    children: [
                        {
                            path: 'single/:slug', component: page( 'pages/blog/BlogSingleComponent.vue' )
                        },
                        {
                            path: '/', component: page( 'pages/blog/BlogListComponent.vue' )
                        },
                    ]
                },
                {
                    path: 'account', component: page( 'pages/account/AccountLayoutComponent.vue' ),
                    children: [
                        {
                            path: '/', component: page( 'pages/account/AccountDashboardComponent.vue' )
                        },
                        {
                            path: 'details', component: page( 'pages/account/AccountDetailsComponent.vue' )
                        },
                        {
                            path: 'addresses', component: page( 'pages/account/address/AccountAddressesComponent.vue' )
                        },
                        {
                            path: 'addresses/billing', component: page( 'pages/account/address/AccountAddressBillingComponent.vue' )
                        },
                        {
                            path: 'addresses/shipping', component: page( 'pages/account/address/AccountAddressShippingComponent.vue' )
                        },
                        {
                            path: 'orders', component: page( 'pages/account/order/AccountOrdersComponent.vue' )
                        },
                        {
                            path: 'downloads', component: page( 'pages/account/AccountDownloadsComponent.vue' )
                        },
                        {
                            path: 'orders/:id', component: page( 'pages/account/order/AccountOrderDetailComponent.vue' )
                        }
                    ]
                },
                {
                    path: '404', component: page( 'pages/PageNotFoundComponent.vue' )
                }
            ]
        },
        {
            path: '*', component: page( 'pages/PageNotFoundComponent.vue' )
        }
    ],
    scrollBehavior: function ( from, to ) {
        if ( from.path == to.path ) return;
        return { x: 0, y: 0 };
    }
} );

router.beforeEach( function ( to, from, next ) {
    // Close Mobile Menu
    var overlay = document.querySelector( ".mobile-menu-overlay" );
    if ( overlay ) overlay.click();

    var body = document.querySelector( 'body' );

    if ( to.path != from.path ) {
        let flag = true;
        if ( ( to.path.indexOf( '/product' ) > -1 && from.path.indexOf( '/product' ) > -1 ) || to.path.indexOf( '/blog' ) > -1 && from.path.indexOf( '/blog' ) > -1 ) {
            let toOriginPath = to.path.replace( /\d/g, '' );
            let fromOriginPath = from.path.replace( /\d/g, '' );
            flag = toOriginPath !== fromOriginPath;
        }
        if ( flag ) {
            body.classList.remove( "loaded" );
        }
    }
    if ( to.path.includes( '/pages/account' ) && !router.app.$store.getters[ 'user/isCustomer' ] ) {
        if ( from.path === '/pages/login' ) return body.classList.add( "loaded" );
        return router.push( '/pages/login' );
    }

    if ( to.path === '/pages/login' && router.app.$store.getters[ 'user/isCustomer' ] ) {
        if ( from.path === '/pages/account' ) return router.back();
        return router.push( '/pages/account' );
    }

    if ( to.path === '/pages/checkout' && router.app.$store.getters[ 'cart/qtyTotal' ] === 0 ) {
        if ( from.path === '/pages/cart' ) return body.classList.add( "loaded" );
        return router.push( '/pages/cart' );
    }
    return next();
} );

router.afterEach( function ( to, from ) {
    var body = document.querySelector( "body" );
    setTimeout( () => {
        body.classList.add( 'loaded' );
    }, 100 );
} );

export default router;