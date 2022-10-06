<template>
    <main class="main">
        <owl-carousel-component
            class="home-slider show-nav-hover nav-big mb-2 text-uppercase slide-animate"
            :options="{
                items: 1,
                dots: false,
                autoplay: false,
                nav: true,
            }"
            v-animate
        >
            <div class="home-slide1 banner">
                <img
                    class="slide-bg"
                    v-lazy="$root.getUrl('client/images/slider/slide-1.jpg')"
                    alt="slider"
                    width="1920"
                    height="500"
                />
                <div class="container">
                    <div
                        class="banner-layer banner-layer-middle appear-animate"
                        data-animation-name="fadeInUpShorter"
                    >
                        <h4 class="text-transform-none">
                            Find the Boundaries. Push Through!
                        </h4>
                        <h2 class="text-transform-none mb-0">Summer Sale</h2>
                        <h3 class="m-b-3">70% Off</h3>
                        <h5 class="d-inline-block mb-0">
                            <span>Starting At</span>
                            <b class="coupon-sale-text text-white bg-secondary align-middle">
                                <sup>$</sup>199
                                <sup>99</sup>
                            </b>
                        </h5>
                        <router-link
                            to="/shop/default"
                            class="btn btn-dark btn-lg ls-10"
                        >Shop Now!</router-link>
                    </div>
                </div>
            </div>

            <div
                class="home-slide2 banner banner-md-vw"
                data-animation-name="fadeInUpShorter"
            >
                <img
                    class="slide-bg"
                    v-lazy="$root.getUrl('client/images/slider/slide-2.jpg')"
                    alt="slider"
                    width="1920"
                    height="500"
                />
                <div class="container">
                    <div
                        class="banner-layer banner-layer-middle d-flex appear-animate"
                        data-animation-name="fadeInUpShorter"
                    >
                        <div class="mx-auto">
                            <h4 class="m-b-1">Extra</h4>
                            <h3 class="m-b-2">20% off</h3>
                            <h3 class="m-b-3 heading-border">Accessories</h3>
                            <h2 class="text-transform-none m-b-4">
                                Summer Sale
                            </h2>
                            <router-link
                                to="/shop/default"
                                class="btn btn-block btn-dark"
                            >Shop All Sale</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </owl-carousel-component>

        <animated-fade-in>
            <div
                class="container mb-2 appear-animate"
                v-animate
            >
                <owl-carousel-component
                    class="info-boxes-slider mb-2"
                    :options="{
                        dots: false,
                        items: 1,
                        margin: 0,
                        responsive: {
                            576: {
                                items: 2,
                            },
                            992: {
                                items: 3,
                            },
                        },
                    }"
                >
                    <div class="info-box info-box-icon-left">
                        <i class="icon-shipping"></i>

                        <div class="info-box-content">
                            <h4>FREE SHIPPING &amp; RETURN</h4>
                            <p class="text-body">
                                Free shipping on all orders over $99.
                            </p>
                        </div>
                    </div>

                    <div class="info-box info-box-icon-left">
                        <i class="icon-money"></i>

                        <div class="info-box-content">
                            <h4>MONEY BACK GUARANTEE</h4>
                            <p class="text-body">100% money back guarantee</p>
                        </div>
                    </div>

                    <div class="info-box info-box-icon-left">
                        <i class="icon-support"></i>

                        <div class="info-box-content">
                            <h4>ONLINE SUPPORT 24/7</h4>
                            <p class="text-body">Lorem ipsum dolor sit amet.</p>
                        </div>
                    </div>
                </owl-carousel-component>

                <div class="banners-container">
                    <owl-carousel-component
                        class="banners-slider"
                        :options="{
                            dots: false,
                            loop: false,
                            margin: 20,
                            autoplay: false,
                            items: 1,
                            responsive: {
                                576: {
                                    items: 2,
                                },
                                992: {
                                    items: 3,
                                },
                            },
                        }"
                    >
                        <div
                            class="banner banner1 banner-sm-vw appear-animate"
                            data-animation-name="fadeInLeftShorter"
                            data-animation-delay="1000"
                            v-animate
                        >
                            <figure>
                                <img
                                    v-lazy="
                                        $root.getUrl(
                                            'client/images/banners/banner-1.jpg'
                                        )
                                    "
                                    alt="banner"
                                    width="360"
                                    height="175"
                                />
                            </figure>
                            <div class="banner-layer banner-layer-middle">
                                <h3 class="m-b-2">Porto Watches</h3>
                                <h4 class="m-b-3 text-primary">
                                    <sup class="text-dark"> <del>20%</del> </sup>30%
                                    <sup>OFF</sup>
                                </h4>
                                <router-link
                                    to="/shop/default"
                                    class="btn btn-sm btn-dark ls-10"
                                >Shop Now</router-link>
                            </div>
                        </div>

                        <div
                            class="banner banner2 banner-sm-vw text-uppercase appear-animate"
                            v-animate
                            data-animation-name="fadeInUpShorter"
                            data-animation-delay="800"
                        >
                            <figure>
                                <img
                                    v-lazy="
                                        $root.getUrl(
                                            'client/images/banners/banner-2.jpg'
                                        )
                                    "
                                    alt="banner"
                                    width="360"
                                    height="175"
                                />
                            </figure>
                            <div class="banner-layer banner-layer-middle text-center pr-4">
                                <div class="row align-items-lg-center">
                                    <div class="col-lg-7 text-lg-right">
                                        <h3>Deal Promos</h3>
                                        <h4 class="pb-4 pb-lg-0 mb-0 text-body">
                                            Starting at $99
                                        </h4>
                                    </div>
                                    <div class="col-lg-5 text-lg-left px-0 px-xl-3">
                                        <router-link
                                            to="/shop/default"
                                            class="btn btn-sm btn-dark ls-10"
                                        >Shop Now</router-link>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="banner banner3 banner-sm-vw appear-animate"
                            data-animation-name="fadeInRightShorter"
                            data-animation-delay="1000"
                            v-animate
                        >
                            <figure>
                                <img
                                    v-lazy="
                                        $root.getUrl(
                                            'client/images/banners/banner-3.jpg'
                                        )
                                    "
                                    alt="banner"
                                    width="360"
                                    height="175"
                                />
                            </figure>
                            <div class="banner-layer banner-layer-middle text-right">
                                <h3>Handbags</h3>
                                <h4 class="text-secondary text-uppercase">
                                    Starting at $99
                                </h4>
                                <router-link
                                    to="/shop/default"
                                    class="btn btn-sm btn-dark ls-10"
                                >Shop Now</router-link>
                            </div>
                        </div>
                    </owl-carousel-component>
                </div>
            </div>
        </animated-fade-in>

        <section
            class="featured-products-section appear-animate"
            data-animation-name="fadeInUpShorter"
            v-animate
        >
            <div class="container">
                <h2 class="section-title heading-border ls-20 border-0">
                    Featured Products
                </h2>
                <owl-carousel-component
                    :options="{
                        items: 2,
                        dots: false,
                        nav: true,
                        autoplay: false,
                        responsive: {
                            0: {
                                items: 2,
                            },
                            700: {
                                items: 3,
                            },
                            1200: {
                                items: 4,
                            },
                        },
                    }"
                    v-if="featuredProducts.length > 0"
                    class="products-slider nav-outer show-nav-hover nav-image-center"
                    key="featured-slider"
                >
                    <product-one-component
                        v-for="product in featuredProducts"
                        :key="product.id"
                        :product="product"
                    ></product-one-component>
                </owl-carousel-component>

                <owl-carousel-component
                    :options="{
                        items: 2,
                        dots: false,
                        nav: true,
                        autoplay: false,
                        responsive: {
                            0: {
                                items: 2,
                            },
                            700: {
                                items: 3,
                            },
                            1200: {
                                items: 4,
                            },
                        },
                    }"
                    v-else
                    class="products-slider nav-outer show-nav-hover nav-image-center"
                >
                    <div
                        class="product-loading-overlay"
                        v-for="item in [1, 2, 3, 4]"
                        :key="'featured-skel-' + item"
                    ></div>
                </owl-carousel-component>
            </div>
        </section>

        <section
            class="new-products-section mb-3 pb-2 appear-animate"
            data-animation-name="fadeInLeftShorter"
            v-animate
        >
            <div class="container">
                <h2 class="section-title heading-border ls-20 border-0">
                    New Arrivals
                </h2>

                <owl-carousel-component
                    class="products-slider nav-outer show-nav-hover nav-image-center"
                    :options="{
                        items: 2,
                        dots: false,
                        nav: true,
                        autoplay: false,
                        responsive: {
                            0: {
                                items: 2,
                            },
                            700: {
                                items: 3,
                            },
                            900: {
                                items: 4,
                            },
                            1200: {
                                items: 5,
                            },
                        },
                    }"
                    v-if="newArrivals.length > 0"
                    key="new-slider"
                >
                    <product-one-component
                        v-for="product in newArrivals"
                        :key="product.id"
                        :product="product"
                    ></product-one-component>
                </owl-carousel-component>

                <owl-carousel-component
                    class="products-slider nav-outer show-nav-hover nav-image-center"
                    :options="{
                        items: 2,
                        dots: false,
                        nav: true,
                        autoplay: false,
                        responsive: {
                            0: {
                                items: 2,
                            },
                            700: {
                                items: 3,
                            },
                            900: {
                                items: 4,
                            },
                            1200: {
                                items: 5,
                            },
                        },
                    }"
                    v-else
                >
                    <div
                        class="product-loading-overlay"
                        v-for="item in [1, 2, 3, 4, 5]"
                        :key="'new-skel-' + item"
                    ></div>
                </owl-carousel-component>

                <div
                    class="banner banner-big-sale appear-animate"
                    v-animate
                    data-animation-delay="200"
                    data-animation-name="fadeInUpShorter"
                    :style="
                        'background: #2A95CB center/cover url(' +
                        $root.getUrl('client/images/banners/banner-4.jpg') +
                        ')'
                    "
                >
                    <div class="banner-content row align-items-center mx-0">
                        <div class="col-md-9 text-center text-md-left">
                            <h2 class="text-white text-uppercase ls-n-20 mb-md-0 px-4">
                                <b class="d-inline-block mb-1 mb-md-0">Big Sale</b>
                                All new fashion brands items up to 70% off
                                <small class="text-transform-none align-middle">Online Purchases Only</small>
                            </h2>
                        </div>
                        <div class="col-md-3 text-center text-md-right">
                            <router-link
                                class="btn btn-light btn-white btn-lg"
                                to="/shop/horizontal-filter1"
                            >View Sale</router-link>
                        </div>
                    </div>
                </div>

                <h2
                    class="section-title heading-border border-0 mb-5 ls-0 appear-animate"
                    data-animation-name="fadeInUpShorter"
                    v-animate
                >
                    Browse Our Categories
                </h2>

                <div v-if="categories.length > 0">
                    <owl-carousel-component
                        class="categories-slider show-nav-hover nav-outer appear-animate"
                        :options="{
                            nav: true,
                            dots: false,
                            items: 2,
                            responsive: {
                                576: {
                                    items: 3,
                                },
                                992: {
                                    items: 5,
                                },
                            },
                        }"
                        data-animation-name="fadeInUpShorter"
                        v-animate
                    >
                        <div
                            class="product-category"
                            v-for="category in categories"
                            :key="category.id"
                        >
                            <router-link :to="{
                                    path: '/shop/default',
                                    query: { category: category.slug },
                                }">
                                <figure>
                                    <img
                                        v-lazy="
                                            $root.getUrl(
                                                category.media.copy_link,
                                                true,
                                                300
                                            )
                                        "
                                        width="300"
                                        height="300"
                                        v-if="category.media"
                                        :alt="
                                            category.media.alt_text
                                                ? category.media.alt_text
                                                : 'category'
                                        "
                                    />
                                    <img
                                        v-lazy="
                                            $root.getUrl(
                                                'server/images/placeholder-img-300x300.png'
                                            )
                                        "
                                        width="300"
                                        height="300"
                                        alt="category"
                                        v-else
                                    />
                                </figure>
                                <div class="category-content">
                                    <h3>{{ category.name }}</h3>
                                    <span>
                                        <mark class="count">
                                            {{ category.count }}
                                        </mark>
                                        products
                                    </span>
                                </div>
                            </router-link>
                        </div>
                    </owl-carousel-component>
                </div>
            </div>
        </section>

        <section
            class="feature-boxes-container appear-animate"
            data-animation-name="fadeInUpShorter"
            v-animate
        >
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="feature-box px-sm-4 feature-box-simple text-center mb-0">
                            <i class="icon-earphones-alt"></i>

                            <div class="feature-box-content">
                                <h3>Customer Support</h3>
                                <h5>You Won't Be Alone</h5>

                                <p>
                                    We really care about you and your website as
                                    much as you do. Purchasing Porto or any
                                    other theme from us you get 100% free
                                    support.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="feature-box px-sm-4 feature-box-simple text-center mb-0">
                            <i class="icon-credit-card"></i>

                            <div class="feature-box-content">
                                <h3>Fully Customizable</h3>
                                <h5>Tons Of Options</h5>

                                <p>
                                    With Porto you can customize the layout,
                                    colors and styles within only a few minutes.
                                    Start creating an amazing website right now!
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="feature-box px-sm-4 feature-box-simple text-center mb-0">
                            <i class="icon-action-undo"></i>

                            <div class="feature-box-content">
                                <h3>Powerful Admin</h3>
                                <h5>Made To Help You</h5>

                                <p>
                                    Porto has very powerful admin features to
                                    help customer to build their own shop in
                                    minutes without any special skills in web
                                    development.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <parallax-component :bg-image="$root.getUrl('client/images/banners/banner-5.jpg')">
            <div class="promo-banner banner container text-uppercase">
                <div class="banner-content row align-items-center text-center">
                    <div
                        class="col-md-4 ml-xl-auto text-md-right appear-animate"
                        data-animation-name="fadeInRightShorter"
                        v-animate
                    >
                        <h2 class="mb-3 mb-md-0 text-white">
                            Top Fashion
                            <br />Deals
                        </h2>
                    </div>
                    <div
                        class="col-md-4 col-xl-3 pb-5 pb-md-0 appear-animate"
                        data-animation-name="fadeUpShorter"
                        v-animate
                    >
                        <router-link
                            to="/shop/horizontal-filter1"
                            class="btn btn-dark btn-black ls-10"
                        >View Sale</router-link>
                    </div>
                    <div
                        class="col-md-4 mr-xl-auto text-md-left appear-animate"
                        data-animation-name="fadeInLeftShorter"
                        v-animate
                    >
                        <h4 class="mb-1 coupon-sale-text p-0 d-block ls-10 text-transform-none">
                            <b>Exclusive COUPON</b>
                        </h4>
                        <h5 class="coupon-sale-text text-white ls-10 p-0 mb-0">
                            <i class="ls-0">UP TO</i>
                            <b class="text-white bg-secondary">$100</b> OFF
                        </h5>
                    </div>
                </div>
            </div>
        </parallax-component>

        <section class="blog-section">
            <div class="container">
                <h2
                    class="section-title heading-border border-0 mb-2 ls-0 appear-animate"
                    data-animation-name="fadeInUp"
                    v-animate
                >
                    Latest News
                </h2>

                <owl-carousel-component
                    :options="{
                        dots: false,
                        items: 1,
                        responsive: {
                            '480': {
                                items: 2,
                            },
                            '576': {
                                items: 3,
                            },
                            '992': {
                                items: 4,
                            },
                        },
                    }"
                    v-if="posts.length > 0"
                    key="home-blog"
                    class="appear-animate"
                    v-animate
                >
                    <div
                        v-for="post in posts"
                        :key="post.id"
                    >
                        <keep-alive>
                            <component
                                :is="postComponent"
                                v-bind="{post: post}"
                            >
                            </component>
                        </keep-alive>
                    </div>
                </owl-carousel-component>

                <owl-carousel-component
                    :options="{
                        dots: false,
                        items: 1,
                        responsive: {
                            '480': {
                                items: 2,
                            },
                            '576': {
                                items: 3,
                            },
                            '992': {
                                items: 4,
                            },
                        },
                    }"
                    v-else
                    class="appear-animate"
                    v-animate
                >
                    <div
                        class="product-loading-overlay"
                        v-for="item in [1, 2, 3, 4]"
                        :key="'media-skel-' + item"
                    ></div>
                </owl-carousel-component>

                <hr class="mt-0 mb-4" />

                <owl-carousel-component
                    class="brands-slider images-center appear-animate"
                    v-animate
                    :options="{
                        items: 2,
                        margin: 0,
                        dots: false,
                        responsive: {
                            576: {
                                items: 4,
                            },
                            992: {
                                items: 5,
                            },
                            1200: {
                                items: 6,
                            },
                        },
                    }"
                >
                    <img
                        v-lazy="$root.getUrl('client/images/brands/brand1.png')"
                        width="140"
                        height="60"
                        alt="brand"
                    />
                    <img
                        v-lazy="$root.getUrl('client/images/brands/brand2.png')"
                        width="140"
                        height="60"
                        alt="brand"
                    />
                    <img
                        v-lazy="$root.getUrl('client/images/brands/brand3.png')"
                        width="140"
                        height="60"
                        alt="brand"
                    />
                    <img
                        v-lazy="$root.getUrl('client/images/brands/brand4.png')"
                        width="140"
                        height="60"
                        alt="brand"
                    />
                    <img
                        v-lazy="$root.getUrl('client/images/brands/brand5.png')"
                        width="140"
                        height="60"
                        alt="brand"
                    />
                    <img
                        v-lazy="$root.getUrl('client/images/brands/brand6.png')"
                        width="140"
                        height="60"
                        alt="brand"
                    />
                </owl-carousel-component>

                <hr class="mt-4 m-b-5" />

                <div
                    class="product-widgets-container row pb-2 skeleton-body"
                    :class="{ loaded: featuredProducts.length > 0 }"
                >
                    <div
                        class="col-lg-3 col-sm-6 pb-5 pb-md-0 appear-animate"
                        data-animation-name="fadeInRightShorter"
                        data-animation-delay="200"
                        v-animate
                    >
                        <h4 class="section-sub-title m-b-3">
                            Featured Products
                        </h4>

                        <div
                            class="skel-pro-list small-pro"
                            v-for="item in [1, 2, 3]"
                            :key="'featured-skel-' + item"
                        ></div>

                        <product-two-component
                            v-for="product in featuredProducts.slice(0, 3)"
                            :key="product.id"
                            :product="product"
                        ></product-two-component>
                    </div>
                    <div
                        class="col-lg-3 col-sm-6 pb-5 pb-md-0 appear-animate"
                        data-animation-name="fadeInRightShorter"
                        data-animation-delay="500"
                        v-animate
                    >
                        <h4 class="section-sub-title m-b-3">
                            Best Selling Products
                        </h4>

                        <div
                            class="skel-pro-list small-pro"
                            v-for="item in [1, 2, 3]"
                            :key="'best-skel-' + item"
                        ></div>

                        <product-two-component
                            v-for="product in bestSellings.slice(0, 3)"
                            :key="product.id"
                            :product="product"
                        ></product-two-component>
                    </div>
                    <div
                        class="col-lg-3 col-sm-6 pb-5 pb-md-0 appear-animate"
                        data-animation-name="fadeInRightShorter"
                        data-animation-delay="800"
                        v-animate
                    >
                        <h4 class="section-sub-title m-b-3">Latest Products</h4>

                        <div
                            class="skel-pro-list small-pro"
                            v-for="item in [1, 2, 3]"
                            :key="'latest-skel-' + item"
                        ></div>

                        <product-two-component
                            v-for="product in newArrivals.slice(0, 3)"
                            :key="product.id"
                            :product="product"
                        ></product-two-component>
                    </div>
                    <div
                        class="col-lg-3 col-sm-6 pb-5 pb-md-0 appear-animate"
                        data-animation-name="fadeInRightShorter"
                        data-animation-delay="1100"
                        v-animate
                    >
                        <h4 class="section-sub-title m-b-3">
                            Top Rated Products
                        </h4>

                        <div
                            class="skel-pro-list small-pro"
                            v-for="item in [1, 2, 3]"
                            :key="'top-skel-' + item"
                        ></div>

                        <product-two-component
                            v-for="product in topRates.slice(0, 3)"
                            :key="product.id"
                            :product="product"
                        ></product-two-component>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";

import { NEWSLETTER_NOT_SHOW } from "../store/modules/setting/mutation-types";

import ProductOneComponent from "./shared/products/ProductOneComponent";
import ProductTwoComponent from "./shared/products/ProductTwoComponent";
import OwlCarouselComponent from "./shared/OwlCarouselComponent";
import ParallaxComponent from "./shared/ParallaxComponent";

function loadPost ( name ) {
    return () =>
        import( `./shared/posts/${ name }.vue` ).then( ( m ) => m.default || m );
}

export default {
    components: {
        ProductOneComponent,
        ProductTwoComponent,
        OwlCarouselComponent,
        ParallaxComponent
    },
    data: function () {
        return {
            featuredProducts: [],
            newArrivals: [],
            topRates: [],
            bestSellings: [],
            categories: [],
            posts: [],
            newsLetter: null,
        };
    },
    computed: {
        ...mapGetters( "setting", [ "getNewsletterStatus" ] ),
        ...mapGetters( "setting", [ "getBlogSettings" ] ),
        postComponent: function () {
            return (
                this.getBlogSettings.postType &&
                loadPost( this.getBlogSettings.postType )
            );
        }
    },
    methods: {
        ...mapMutations( "setting", {
            notShowAgain: NEWSLETTER_NOT_SHOW,
        } ),
        beforeNewsletterClose: function ( event ) {
            if (
                event.ref.querySelector( "#show-again" ) &&
                event.ref.querySelector( "#show-again" ).checked
            ) {
                this.notShowAgain();
            }
        },
    },
    beforeCreate: function () {
        window.axios
            .get( "/web" )
            .then( ( response ) => {
                this.featuredProducts = [ ...response.data.featuredProducts ];
                this.newArrivals = [ ...response.data.newArrivals ];
                this.topRates = [ ...response.data.topRates ];
                this.bestSellings = [ ...response.data.bestSellings ];
                this.categories = [ ...response.data.categories ];
                this.posts = [ ...response.data.posts ];
            } )
            .catch( ( error ) => { } );
    },
    mounted: function () {
        if ( this.getNewsletterStatus ) {
            this.newsLetter = setTimeout( () => {
                this.$modal.show(
                    () => import( "./shared/modals/NewsletterModalComponent" ),
                    {},
                    {
                        width: "740",
                        height: "auto",
                        adaptive: true,
                    },
                    {
                        "before-close": this.beforeNewsletterClose,
                    }
                );
            }, 5000 );
        }
    },
    destroyed: function () {
        window.clearTimeout( this.newsLetter );
    },
};
</script>