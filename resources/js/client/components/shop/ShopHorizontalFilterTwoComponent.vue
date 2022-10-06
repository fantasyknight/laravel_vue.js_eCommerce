<template>
    <main class="main">
        <shop-banner-component></shop-banner-component>

        <div
            class="container products-body skeleton-body skel-shop-products"
            :class="{loaded: loaded}"
        >
            <shop-breadcrumb-component :categories="parentCategories"></shop-breadcrumb-component>
            <nav class="toolbox horizontal-filter filter-sorts pb-0 toolbox-sticky">
                <div class="toolbox-left flex-wrap mr-auto">
                    <div class="sidebar-overlay" @click="toggleSidebar"></div>
                    <a
                        href="javascript:;"
                        @click="toggleSidebar"
                        class="canvas-sidebar-toggle d-lg-none bg-white mr-3 mb-1"
                    >
                        <i class="fas fa-sliders-h"></i>
                        <span class="ml-2 pl-1">Filter</span>
                    </a>
                    <shop-sidebar-two-component></shop-sidebar-two-component>

                    <div class="toolbox-item toolbox-sort select-custom mr-auto">
                        <select
                            name="orderby"
                            class="form-control"
                            v-model="orderBy"
                            @change.prevent="getProducts"
                        >
                            <option value="default">Default sorting</option>
                            <option value="popularity">Sort by popularity</option>
                            <option value="rating">Sort by average rating</option>
                            <option value="date">Sort by newness</option>
                            <option value="price">Sort by price: low to high</option>
                            <option value="price-desc">Sort by price: high to low</option>
                        </select>
                    </div>
                </div>

                <div class="toolbox-item toolbox-show">
                    <label>Show:</label>

                    <div class="select-custom">
                        <select
                            name="count"
                            class="form-control"
                            v-model.number="perPage"
                            @change="getProducts"
                        >
                            <option value="8">8</option>
                            <option value="12">12</option>
                            <option value="24">24</option>
                            <option value="36">36</option>
                        </select>
                    </div>
                </div>

                <div class="toolbox-item layout-modes d-none d-sm-block">
                    <router-link to="/shop/default" class="layout-btn btn-grid active" title="Grid">
                        <i class="icon-mode-grid"></i>
                    </router-link>
                    <router-link to="/shop/list" class="layout-btn btn-list" title="List">
                        <i class="icon-mode-list"></i>
                    </router-link>
                </div>
            </nav>
            <div
                class="info-box with-icon py-3 px-1 skel-hide"
                v-if="products.length == 0 && loaded"
            >
                <p class="porto-info">No product matching your selection.</p>
            </div>
            <template v-else>
                <div class="row" v-if="!loaded">
                    <div
                        class="col-6 col-sm-4 col-md-4 col-lg-3"
                        v-for="item in fakeArray"
                        :key="item"
                    >
                        <div class="skel-pro skel-pro-grid"></div>
                    </div>
                </div>
                <div class="row" v-else>
                    <div
                        class="col-6 col-sm-4 col-md-4 col-lg-3"
                        v-for="product in products"
                        :key="product.id"
                    >
                        <transition name="fade" mode="out-in">
                            <keep-alive>
                                <component :is="productComponent" v-bind="{ product: product }"></component>
                            </keep-alive>
                        </transition>
                    </div>
                </div>
                <nav class="toolbox toolbox-pagination">
                    <div class="toolbox-item toolbox-show">
                        <label>Show:</label>

                        <div class="select-custom">
                            <select
                                name="count"
                                class="form-control"
                                v-model.number="perPage"
                                @change="getProducts"
                            >
                                <option value="8">8</option>
                                <option value="12">12</option>
                                <option value="24">24</option>
                                <option value="36">36</option>
                            </select>
                        </div>
                    </div>
                    <pagination-component :per-page="perPage" :total="totalCount"></pagination-component>
                </nav>
            </template>
        </div>
        <div class="mb-3"></div>
    </main>
</template>

<script>
import { mapGetters } from "vuex";

import PaginationComponent from "../shared/PaginationComponent";
import ShopBannerComponent from "./shared/ShopBannerComponent";
import ShopBreadcrumbComponent from "./shared/ShopBreadcrumbComponent";
import ShopSidebarTwoComponent from "./shared/ShopSidebarTwoComponent";

function loadProduct(name) {
    return () =>
        import(`../shared/products/${name}.vue`).then((m) => m.default || m);
}

export default {
    components: {
        PaginationComponent,
        ShopBannerComponent,
        ShopBreadcrumbComponent,
        ShopSidebarTwoComponent,
    },
    data: function () {
        return {
            loaded: false,
            products: [],
            parentCategories: [],
            orderBy: "default",
            perPage: 8,
            totalCount: 10,
            shouldSticky: true,
        };
    },
    computed: {
        ...mapGetters("setting", ["getShopSettings"]),
        productComponent: function () {
            return (
                this.getShopSettings.productType &&
                loadProduct(this.getShopSettings.productType)
            );
        },
        fakeArray: function () {
            let temp = [];
            for (let i = 0; i < this.perPage; i++) {
                temp.push(i);
            }
            return temp;
        },
    },
    watch: {
        $route: function () {
            this.getProducts();
            if (document.querySelector(".skeleton-body")) {
                window.scrollTo({
                    top:
                        document.querySelector(".skeleton-body").offsetTop - 58,
                    behavior: "smooth",
                });
            }
        },
    },
    created: function () {
        this.getProducts();
        this.stickyHandle();
        window.addEventListener("resize", this.stickyHandle, { passive: true });
    },
    destroyed: function () {
        window.removeEventListener("resize", this.stickyHandle);
    },
    methods: {
        getProducts: function () {
            this.loaded = false;
            window.axios
                .get("/web/shop/", {
                    params: {
                        ...this.$route.query,
                        orderBy: this.orderBy,
                        per_page: this.perPage,
                    },
                })
                .then((response) => {
                    this.products = response.data.products;
                    this.totalCount = response.data.totalCount;
                    this.parentCategories = response.data.parentCategories;

                    this.loaded = true;
                })
                .catch((error) => {});
        },
        toggleSidebar: function () {
            document.querySelector("body").classList.toggle("sidebar-opened");
        },
        stickyHandle: function () {
            if (window.innerWidth > 992) this.shouldSticky = true;
            else this.shouldSticky = false;
        },
    },
};
</script>