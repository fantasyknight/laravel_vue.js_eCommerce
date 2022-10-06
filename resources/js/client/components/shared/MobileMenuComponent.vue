<template>
    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span
                class="mobile-menu-close"
                @click="closeMobileMenu"
            >
                <i class="fa fa-times"></i>
            </span>
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li>
                        <router-link to="/">Home</router-link>
                    </li>
                    <li>
                        <a
                            href="#"
                            @click.prevent="categoryOpen = !categoryOpen"
                            :class="{ open: categoryOpen }"
                        >
                            Categories
                            <span class="mmenu-btn"></span>
                        </a>
                        <ul
                            is="vue-slide-toggle"
                            :open="categoryOpen"
                            :duration="200"
                            tag="ul"
                        >
                            <li :class="{ open: categoryVariation1Open }">
                                <a
                                    href="javascript:;"
                                    @click="
										categoryVariation1Open = !categoryVariation1Open
									"
                                >Variations 1<span class="mmenu-btn"></span></a>
                                <ul
                                    is="vue-slide-toggle"
                                    :open="categoryVariation1Open"
                                    :duration="200"
                                    tag="ul"
                                >
                                    <li>
                                        <router-link to="/shop/default">Fullwidth Banner</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/boxed-slider">Boxed slider banner</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/boxed-image">boxed image banner</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/left-sidebar">Left sidebar</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/right-sidebar">Right sidebar</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/off-canvas">Off canvas filter</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/horizontal-filter1">
                                            Horizontal Filter1
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/horizontal-filter2">
                                            Horizontal Filter2
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                            <li :class="{ open: categoryVariation2Open }">
                                <a
                                    href="javascript:;"
                                    @click="
										categoryVariation2Open = !categoryVariation2Open
									"
                                >Variations 2<span class="mmenu-btn"></span></a>
                                <ul
                                    is="vue-slide-toggle"
                                    :open="categoryVariation2Open"
                                    :duration="200"
                                    tag="ul"
                                >
                                    <li>
                                        <router-link to="/shop/list">List types Banner</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/infinite-scroll">Ajax infinite scroll</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/3cols">3 columns Products</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/4cols">4 columns Products</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/5cols">5 columns Products</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/6cols">6 columns Products</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/7cols">7 columns Products</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/shop/8cols">8 columns Products</router-link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a
                            href="#"
                            @click.prevent="productOpen = !productOpen"
                            :class="{ open: productOpen }"
                        >
                            Products
                            <span class="mmenu-btn"></span>
                        </a>
                        <ul
                            is="vue-slide-toggle"
                            :open="productOpen"
                            :duration="200"
                            tag="ul"
                            @click.prevent="closeMobileMenu"
                        >
                            <li :class="{ open: productPageOpen }">
                                <a
                                    href="javascript:;"
                                    @click="productPageOpen = !productPageOpen"
                                >
                                    Product Pages<span class="mmenu-btn"></span>
                                </a>
                                <ul
                                    is="vue-slide-toggle"
                                    :open="productPageOpen"
                                    :duration="200"
                                    tag="ul"
                                >
                                    <li>
                                        <router-link to="/product/default/43">Simple Product</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/product/default/10">
                                            Variable Product
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/product/default/57">
                                            Sale Product
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/product/default/51">
                                            Featured &amp; On Sale
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/product/custom-tab/10">
                                            With Custom Tab
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/product/left-sidebar/10">
                                            With Left Sidebar
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/product/right-sidebar/10">
                                            With Right Sidebar
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/product/cart-sticky/10">
                                            Add Cart Sticky
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                            <li :class="{ open: productLayoutOpen }">
                                <a
                                    href="javascript:;"
                                    @click="
										productLayoutOpen = !productLayoutOpen
									"
                                >
                                    Product Layouts<span class="mmenu-btn"></span>
                                </a>
                                <ul
                                    is="vue-slide-toggle"
                                    :open="productLayoutOpen"
                                    :duration="200"
                                    tag="ul"
                                >
                                    <li>
                                        <router-link to="/product/extended/10">
                                            Extended Layout
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/product/grid/10">
                                            Grid Image
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/product/fullwidth/10">
                                            Full Width Layout
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/product/sticky-right/10">
                                            Sticky Info
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/product/sticky-both/10">
                                            Left &amp; Right Sticky
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/product/left-sidebar/10">
                                            Left Sidebar
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/product/center-vertical/10">
                                            Center Vertical
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="#">
                                            Build Your Own
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a
                            href="#"
                            @click.prevent="pageOpen = !pageOpen"
                            :class="{ open: pageOpen }"
                        >
                            Pages
                            <span class="mmenu-btn"></span>
                        </a>
                        <ul
                            is="vue-slide-toggle"
                            :open="pageOpen"
                            :duration="200"
                            tag="ul"
                        >
                            <li>
                                <router-link to="/pages/wishlist">Wishlist</router-link>
                            </li>
                            <li>
                                <router-link to="/pages/cart">Shopping Cart</router-link>
                            </li>
                            <li>
                                <router-link to="/pages/checkout">Checkout</router-link>
                            </li>
                            <li>
                                <router-link to="/pages/account">Dashboard</router-link>
                            </li>
                            <li>
                                <router-link to="/pages/login">Login</router-link>
                            </li>
                            <li>
                                <router-link to="/pages/forgot-pwd">Forgot Password</router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <router-link to="/pages/blog">Blog</router-link>
                    </li>
                    <li>
                        <router-link to="/pages/about-us">About Us</router-link>
                    </li>
                </ul>
                <ul class="mobile-menu mt-2 mb-2">
                    <li class="border-0">
                        <a href="#">
                            Special Offer!
                        </a>
                    </li>
                    <li class="border-0">
                        <a
                            href="#"
                            target="_blank"
                        >
                            Buy Porto!
                            <span class="tip tip-hot">Hot</span>
                        </a>
                    </li>
                </ul>
                <ul class="mobile-menu">
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
            </nav>

            <form
                class="search-wrapper mb-2"
                action="#"
                method="get"
                @submit.prevent="submitSearchForm"
            >
                <input
                    type="text"
                    class="form-control mb-0"
                    autocomplete="false"
                    placeholder="Search..."
                    required
                    v-model="searchTerm"
                />
                <button
                    class="btn icon-search text-white bg-transparent p-0"
                    type="submit"
                ><label class="sr-only">mobile button</label></button>
            </form>

            <div class="social-icons">
                <a
                    href="#"
                    class="social-icon social-facebook icon-facebook"
                    target="_blank"
                >
                </a>
                <a
                    href="#"
                    class="social-icon social-twitter icon-twitter"
                    target="_blank"
                >
                </a>
                <a
                    href="#"
                    class="social-icon social-instagram icon-instagram"
                    target="_blank"
                >
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

import { VueSlideToggle } from "vue-slide-toggle";

import LoginModalComponent from "../shared/modals/LoginModalComponent";

export default {
    components: {
        VueSlideToggle,

        LoginModalComponent,
    },
    data: function () {
        return {
            currencyOpen: false,
            langOpen: false,
            productOpen: false,
            productPageOpen: false,
            productLayoutOpen: false,
            categoryOpen: false,
            categoryVariation1Open: false,
            categoryVariation2Open: false,
            pageOpen: false,
            searchTerm: "",
        };
    },
    computed: {
        ...mapGetters( "user", [ "isCustomer" ] ),
    },
    methods: {
        closeMobileMenu: function () {
            var overlay = document.querySelector( ".mobile-menu-overlay" );
            if ( overlay ) overlay.click();
        },

        showLoginModal: function () {
            this.$modal.show(
                LoginModalComponent,
                {},
                {
                    width: "872",
                    height: "auto",
                    adaptive: true,
                }
            );
        },

        submitSearchForm: function () {
            this.$router.push( {
                path: "/shop/default",
                query: {
                    search_term: this.searchTerm,
                },
            } );
        },
    },
};
</script>