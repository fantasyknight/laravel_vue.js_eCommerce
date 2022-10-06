<template>
    <div class="header header-one">
        <transition name="fade">
            <div
                class="top-notice bg-primary text-white"
                v-if="topNoticeShow"
            >
                <div class="container text-center d-flex flex-wrap align-items-center justify-content-center">
                    <h5 class="d-inline-block mb-0 mr-2">
                        Get Up to
                        <b>40% OFF</b> New-Season Styles
                    </h5>
                    <router-link
                        to="/shop/horizontal-filter1"
                        class="category"
                    >MEN</router-link>
                    <router-link
                        to="/shop/horizontal-filter1"
                        class="category ml-2 mr-3"
                    >WOMEN</router-link>
                    <small class="d-inline-block">* Limited time only</small>
                    <button
                        title="Close (Esc)"
                        type="button"
                        class="mfp-close"
                        @click.prevent="topNoticeShow = !topNoticeShow"
                    >
                        ×
                    </button>
                </div>
            </div>
        </transition>
        <header>
            <div class="header-top">
                <div class="container">
                    <div class="header-left d-none d-sm-block">
                        <p class="top-message text-uppercase">
                            FREE Returns. Standard Shipping Orders $99+
                        </p>
                    </div>

                    <div class="header-right header-dropdowns ml-0 ml-sm-auto w-sm-100">
                        <div class="header-dropdown dropdown-expanded d-none d-lg-block">
                            <a href="#">Links</a>
                            <div class="header-menu">
                                <ul>
                                    <li>
                                        <router-link to="/pages/account">My Account</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/pages/contact-us">Contact Us</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/pages/blog">Blog</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/pages/wishlist">My Wishlist</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/pages/cart">Cart</router-link>
                                    </li>
                                    <li
                                        v-if="isCustomer"
                                        class="mr-3"
                                    >
                                        <router-link to="/pages/account">Log out</router-link>
                                    </li>
                                    <li
                                        v-else
                                        class="mr-3"
                                    >
                                        <a
                                            href="#"
                                            @click.prevent="showLoginModal"
                                        >Log In</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <span class="separator"></span>

                        <div class="header-dropdown">
                            <a href="#">
                                <i
                                    class="flag-us flags"
                                    v-lazy:background-image="
                                        $root.getUrl(
                                            'client/images/flags/flags.png'
                                        )
                                    "
                                ></i>
                                ENG</a>
                            <div class="header-menu">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <i
                                                class="flag-us flags mr-2"
                                                v-lazy:background-image="
                                                    $root.getUrl(
                                                        'client/images/flags/flags.png'
                                                    )
                                                "
                                            ></i>ENG
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i
                                                class="flag-fr flags mr-2"
                                                v-lazy:background-image="
                                                    $root.getUrl(
                                                        'client/images/flags/flags.png'
                                                    )
                                                "
                                            ></i>FRA
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="header-dropdown mr-auto mr-sm-3 mr-md-0">
                            <a href="#">USD</a>
                            <div class="header-menu">
                                <ul>
                                    <li>
                                        <a href="#">EUR</a>
                                    </li>
                                    <li>
                                        <a href="#">USD</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <span class="separator"></span>

                        <div class="social-icons d-flex">
                            <a
                                href="#"
                                class="social-icon social-facebook icon-facebook"
                                target="_blank"
                            ><label class="sr-only">Facebook</label></a>
                            <a
                                href="#"
                                class="social-icon social-twitter icon-twitter"
                                target="_blank"
                            ><label class="sr-only">Twitter</label></a>
                            <a
                                href="#"
                                class="social-icon social-instagram icon-instagram"
                                target="_blank"
                            ><label class="sr-only">Instagram</label></a>
                        </div>
                    </div>
                </div>
            </div>

            <sticky-header-component>
                <div class="header-middle sticky-header">
                    <div class="container">
                        <div class="header-left col-lg-2 w-auto pl-0">
                            <button
                                class="mobile-menu-toggler mr-4"
                                :class="getHeaderSettings.mmenuTogglerStyle"
                                type="button"
                                @click="showMobileMenu"
                            >
                                <i class="icon-menu"></i>
                                <label class="sr-only">Wishlist</label>
                            </button>
                            <router-link
                                to="/"
                                class="logo d-inline-block"
                            >
                                <img
                                    :src="
                                        $root.getUrl(
                                            getHeaderSettings.logoImage
                                        )
                                    "
                                    :alt="`${getHeaderSettings.siteTitle} Logo`"
                                    :width="getHeaderSettings.logoImageWidth"
                                    :height="getHeaderSettings.logoImageHeight"
                                    class="w-100 header-logo"
                                />
                            </router-link>
                        </div>

                        <div class="header-right w-lg-max">
                            <header-search-one-component
                                :categories="categories"
                                class="header-icon header-search-inline header-search-category w-lg-max text-right pl-3 pr-2"
                                :class="getHeaderSettings.searchFormStyle"
                                :show-category="
                                    getHeaderSettings.searchFormCategory
                                "
                            ></header-search-one-component>

                            <div class="header-contact d-none d-lg-flex pl-4 ml-3 mr-xl-5 pr-3">
                                <img
                                    alt="phone"
                                    :src="
                                        $root.getUrl('client/images/phone.png')
                                    "
                                    width="30"
                                    height="30"
                                    class="pb-1"
                                />
                                <h6>
                                    Call us now
                                    <a
                                        href="tel:#"
                                        class="text-dark font1"
                                    >+123 5678 890</a>
                                </h6>
                            </div>
                            <router-link
                                to="/pages/account"
                                class="header-icon login-link pl-1"
                                :class="getHeaderSettings.accountIconStyle"
                            >
                                <i class="icon-user-2"></i>
                            </router-link>

                            <router-link
                                to="/pages/wishlist"
                                class="header-icon wish-link"
                                title="Wishlist"
                            >
                                <i class="icon-wishlist-2"></i>
                            </router-link>
                            <transition
                                name="fade"
                                mode="out-in"
                            >
                                <keep-alive>
                                    <component :is="cartMenuComponent"></component>
                                </keep-alive>
                            </transition>
                        </div>
                    </div>
                </div>
            </sticky-header-component>

            <sticky-header-component>
                <div class="header-bottom sticky-header d-none d-lg-block">
                    <div class="container">
                        <main-menu-component class="w-100"></main-menu-component>
                    </div>
                </div>
            </sticky-header-component>
        </header>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

import HeaderSearchOneComponent from "./shared/header-search/HeaderSearchOneComponent";
import MainMenuComponent from "./shared/main-menu/MainMenuComponent";
import StickyHeaderComponent from "./shared/StickyHeaderComponent";

import LoginModalComponent from "../modals/LoginModalComponent";

function loadComponent ( name ) {
    return () =>
        import( `./shared/cart-menu/${ name }.vue` ).then( ( m ) => m.default || m );
}

export default {
    components: {
        HeaderSearchOneComponent,
        MainMenuComponent,
        StickyHeaderComponent,

        LoginModalComponent,
    },
    props: {
        categories: Array,
    },
    data: function () {
        return {
            topNoticeShow: true,
        };
    },
    computed: {
        ...mapGetters( "user", [ "isCustomer" ] ),
        ...mapGetters( "setting", [ "getHeaderSettings" ] ),
        cartMenuComponent: function () {
            return (
                this.getHeaderSettings.cartMenuType &&
                loadComponent( this.getHeaderSettings.cartMenuType )
            );
        },
    },
    methods: {
        showLoginModal: function () {
            this.$modal.show(
                LoginModalComponent,
                {},
                {
                    width: "525",
                    height: "auto",
                    adaptive: true,
                }
            );
        },

        showMobileMenu: function () {
            document.querySelector( "body" ).classList.add( "mmenu-active" );
        },
    },
};
</script>