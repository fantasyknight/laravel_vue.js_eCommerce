<template>
    <main class="main">
        <shop-banner-component></shop-banner-component>

        <div
            class="container skeleton-body skel-shop-products"
            :class="{loaded: loaded}"
        >
            <shop-breadcrumb-component :categories="parentCategories"></shop-breadcrumb-component>

            <div class="row">
                <div class="col-lg-12">
                    <div
                        class="row"
                        v-if="products.length == 0 && loaded"
                    >
                        <div class="info-box with-icon py-3 px-1 skel-hide">
                            <p class="porto-info">No product matching your selection.</p>
                        </div>
                    </div>
                    <template v-else>
                        <sticky-header-component
                            wrapperClass="toolbox-wrapper"
                            class="toolbox-wrapper"
                            :top="650"
                        >
                            <nav class="toolbox toolbox-sticky sticky-header">
                                <div class="toolbox-left">
                                    <a
                                        href="#"
                                        class="sidebar-toggle d-inline-flex d-lg-none"
                                        @click.prevent="toggleSidebar"
                                    >
                                        <svg
                                            data-name="Layer 3"
                                            id="Layer_3"
                                            viewBox="0 0 32 32"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <line
                                                class="cls-1"
                                                x1="15"
                                                x2="26"
                                                y1="9"
                                                y2="9"
                                            />
                                            <line
                                                class="cls-1"
                                                x1="6"
                                                x2="9"
                                                y1="9"
                                                y2="9"
                                            />
                                            <line
                                                class="cls-1"
                                                x1="23"
                                                x2="26"
                                                y1="16"
                                                y2="16"
                                            />
                                            <line
                                                class="cls-1"
                                                x1="6"
                                                x2="17"
                                                y1="16"
                                                y2="16"
                                            />
                                            <line
                                                class="cls-1"
                                                x1="17"
                                                x2="26"
                                                y1="23"
                                                y2="23"
                                            />
                                            <line
                                                class="cls-1"
                                                x1="6"
                                                x2="11"
                                                y1="23"
                                                y2="23"
                                            />
                                            <path
                                                class="cls-2"
                                                d="M14.5,8.92A2.6,2.6,0,0,1,12,11.5,2.6,2.6,0,0,1,9.5,8.92a2.5,2.5,0,0,1,5,0Z"
                                            />
                                            <path
                                                class="cls-2"
                                                d="M22.5,15.92a2.5,2.5,0,1,1-5,0,2.5,2.5,0,0,1,5,0Z"
                                            />
                                            <path
                                                class="cls-3"
                                                d="M21,16a1,1,0,1,1-2,0,1,1,0,0,1,2,0Z"
                                            />
                                            <path
                                                class="cls-2"
                                                d="M16.5,22.92A2.6,2.6,0,0,1,14,25.5a2.6,2.6,0,0,1-2.5-2.58,2.5,2.5,0,0,1,5,0Z"
                                            />
                                        </svg>
                                        <span>Filter</span>
                                    </a>
                                    <div class="toolbox-item toolbox-sort">
                                        <label>Sort By:</label>

                                        <div class="select-custom">
                                            <select
                                                name="orderby"
                                                class="form-control"
                                                v-model="orderBy"
                                                @change.prevent="getProducts"
                                            >
                                                <option value="default">Default sorting</option>
                                                <option value="popularity">Sort by popularity</option>
                                                <option value="rating">
                                                    Sort by average
                                                    rating
                                                </option>
                                                <option value="date">Sort by newness</option>
                                                <option value="price">
                                                    Sort by price: low to
                                                    high
                                                </option>
                                                <option value="price-desc">
                                                    Sort by price: high to
                                                    low
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="toolbox-right">
                                    <div
                                        class="toolbox-item toolbox-show"
                                        v-if="cols > 6"
                                    >
                                        <label>Show:</label>

                                        <div class="select-custom">
                                            <select
                                                name="count"
                                                class="form-control"
                                                v-model.number="perPage"
                                                @change="getProducts"
                                            >
                                                <option value="14">14</option>
                                                <option value="16">16</option>
                                                <option value="21">21</option>
                                                <option value="24">24</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="toolbox-item layout-modes">
                                        <router-link
                                            to="/shop/default"
                                            class="layout-btn btn-grid active"
                                            title="Grid"
                                        >
                                            <i class="icon-mode-grid"></i>
                                        </router-link>
                                        <router-link
                                            to="/shop/list"
                                            class="layout-btn btn-list"
                                            title="List"
                                        >
                                            <i class="icon-mode-list"></i>
                                        </router-link>
                                    </div>
                                </div>
                            </nav>
                        </sticky-header-component>
                        <div
                            class="row"
                            v-if="!loaded"
                        >
                            <div
                                class="col-6 col-sm-4 col-lg-3"
                                :class="{
                                    'col-xl-5col': cols === 5,
                                    'col-xl-2': cols === 6,
                                    'col-xl-7col': cols === 7,
                                    'col-xl-8col': cols === 8,
                                }"
                                v-for="fake in fakeData"
                                :key="fake"
                            >
                                <div class="skel-pro skel-pro-grid skel-padding-161 mb-2"></div>
                            </div>
                        </div>
                        <div
                            class="row"
                            v-else
                        >
                            <div
                                class="col-6 col-sm-4 col-lg-3"
                                :class="{
									'col-xl-5col': cols === 5,
									'col-xl-2': cols === 6,
									'col-xl-7col': cols === 7,
									'col-xl-8col': cols === 8,
								}"
                                v-for="product in products"
                                :key="product.id"
                            >
                                <transition
                                    name="fade"
                                    mode="out-in"
                                >
                                    <keep-alive>
                                        <component
                                            :is="productComponent"
                                            v-bind="{ product: product }"
                                        ></component>
                                    </keep-alive>
                                </transition>
                            </div>
                        </div>
                        <nav class="toolbox toolbox-pagination">
                            <div
                                class="toolbox-item toolbox-show"
                                v-if="cols > 6"
                            >
                                <label>Show:</label>

                                <div class="select-custom">
                                    <select
                                        name="count"
                                        class="form-control"
                                        v-model.number="perPage"
                                        @change="getProducts"
                                    >
                                        <option value="14">14</option>
                                        <option value="16">16</option>
                                        <option value="21">21</option>
                                        <option value="24">24</option>
                                    </select>
                                </div>
                            </div>
                            <pagination-component
                                :per-page="perPage"
                                :total="totalCount"
                            ></pagination-component>
                        </nav>
                    </template>
                </div>
                <div
                    class="sidebar-overlay"
                    @click="toggleSidebar"
                ></div>
                <aside class="sidebar-shop d-lg-none mobile-sidebar">
                    <shop-sidebar-one-component></shop-sidebar-one-component>
                </aside>
            </div>
        </div>

        <div class="mb-3"></div>
    </main>
</template>

<script>
import { mapGetters } from "vuex";

import PaginationComponent from "../shared/PaginationComponent";
import ShopBannerComponent from "./shared/ShopBannerComponent";
import ShopBreadcrumbComponent from "./shared/ShopBreadcrumbComponent";
import ShopSidebarOneComponent from "./shared/ShopSidebarOneComponent";
import StickyHeaderComponent from "../shared/headers/shared/StickyHeaderComponent";

function loadProduct ( name ) {
    return () =>
        import( `../shared/products/${ name }.vue` ).then( ( m ) => m.default || m );
}

export default {
    components: {
        PaginationComponent,
        ShopBannerComponent,
        ShopBreadcrumbComponent,
        ShopSidebarOneComponent,
        StickyHeaderComponent,
    },
    data: function () {
        return {
            loaded: false,
            products: [],
            parentCategories: [],
            orderBy: "default",
            perPage: 12,
            totalCount: 10,
            cols: 5,
            fakeData: [],
        };
    },
    computed: {
        ...mapGetters( "setting", [ "getShopSettings" ] ),
        productComponent: function () {
            return (
                this.getShopSettings.productType &&
                loadProduct( this.getShopSettings.productType )
            );
        },
        fakeArray: function () {
            let temp = [];
            for ( let i = 0; i < this.perPage; i++ ) {
                temp.push( i );
            }
            return temp;
        },
    },
    watch: {
        $route: function () {
            this.getProducts();
            if ( document.querySelector( ".skeleton-body" ) ) {
                window.scrollTo( {
                    top:
                        document.querySelector( ".skeleton-body" ).offsetTop - 58,
                    behavior: "smooth",
                } );
            }
        },
    },
    created: function () {
        this.getProducts();
    },
    methods: {
        getProducts: function () {
            this.loaded = false;
            this.cols = parseInt( this.$route.path.replace( /\D/g, "" ) );
            this.perPage = this.cols * 2;
            this.fakeData = [];

            for ( let i = 0; i < this.perPage; i++ ) {
                this.fakeData.push( i );
            }

            window.axios
                .get( "/web/shop/", {
                    params: {
                        ...this.$route.query,
                        orderBy: this.orderBy,
                        per_page: this.perPage,
                    },
                } )
                .then( ( response ) => {
                    this.products = response.data.products;
                    this.totalCount = response.data.totalCount;
                    this.parentCategories = response.data.parentCategories;

                    this.loaded = true;
                } )
                .catch( ( error ) => { } );
        },
        toggleSidebar: function () {
            document.querySelector( "body" ).classList.toggle( "sidebar-opened" );
        },
    },
};
</script>