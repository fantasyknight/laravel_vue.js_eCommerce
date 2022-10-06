<template>
    <main class="main">
        <div class="page-header">
            <div class="container d-flex flex-column align-items-center">
                <nav aria-label="breadcrumb" class="breadcrumb-nav">
                    <div class="container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/">Home</router-link>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                        </ol>
                    </div>
                </nav>
                <h1>Wishlist</h1>
            </div>
        </div>

        <div class="container">
            <div class="wishlist-title">
                <h2 class="p-2">My wishlist on Porto Shop</h2>
            </div>
            <div class="wishlist-table-container" v-if="wishlist.length > 0" key="not-empty">
                <table class="table table-wishlist mb-0">
                    <thead>
                        <tr>
                            <th class="thumbnail-col"></th>
                            <th class="product-col">Product</th>
                            <th class="price-col">Price</th>
                            <th class="status-col">Stock Status</th>
                            <th class="action-col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="product-row" v-for="product in wishlist" :key="product.id">
                            <td>
                                <figure class="product-image-container">
                                    <router-link :to="getPageUrl(product)" class="product-image">
                                        <img
                                            v-lazy="
												$root.getUrl(
													product.media[0].copy_link,
													true,
													100
												)
											"
                                            :alt="
												product.media[0].alt_text
													? product.media[0].alt_text
													: 'product'
											"
                                            width="80"
                                            height="80"
                                            v-if="product.media.length > 0"
                                            :key="'product-image'"
                                        />
                                        <img
                                            v-lazy="
												$root.getUrl(
													'server/images/placeholder-img-100x100.png'
												)
											"
                                            alt="product"
                                            width="80"
                                            height="80"
                                            v-else
                                            :key="'placeholder'"
                                        />
                                    </router-link>

                                    <a
                                        href="#"
                                        class="btn-remove icon-cancel"
                                        title="Remove Product"
                                        @click.prevent="
											removeFromWishlist({
												product: product,
											})
										"
                                    ></a>
                                </figure>
                            </td>
                            <td>
                                <h5 class="product-title">
                                    <router-link :to="getPageUrl(product)">
                                        {{
                                        product.name
                                        }}
                                    </router-link>
                                </h5>
                            </td>
                            <td class="price-box" v-if="product.type == 'simple'">
                                <del
                                    class="old-price"
                                    v-if="
										product.min_max_price[0] !=
										product.min_max_price[1]
									"
                                >${{ product.min_max_price[0] }}</del>
                                <span class="product-price">${{ product.min_max_price[1] }}</span>
                            </td>
                            <td class="price-box" v-if="product.type == 'variable'">
                                <span class="product-price">${{ product.min_max_price[0] }}</span>
                                <span class="product-price">- ${{ product.min_max_price[1] }}</span>
                            </td>
                            <td>
                                <span class="stock-status">
                                    {{
                                    stockStatus(product)
                                    }}
                                </span>
                            </td>
                            <td class="action">
                                <button
                                    class="btn btn-add-cart btn-shop"
                                    @click="moveToCart(product)"
                                    v-if="product.type == 'simple'"
                                >ADD TO CART</button>
                                <router-link
                                    class="btn btn-shop"
                                    v-if="product.type == 'variable'"
                                    :to="'/product/default/' + product.slug"
                                >Select Options</router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="wishlist-table-container border-0 shadow-none" v-else key="empty">
                <div class="text-center">
                    <i class="far fa-heart wishlist-empty d-block"></i>
                    <span class="d-block mt-2">No products added to wishlist</span>
                    <router-link to="/shop/default" class="btn btn-dark mt-2">Go Shop</router-link>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from "vuex";
import {
    ADD_TO_WISHLIST,
    REMOVE_FROM_WISHLIST,
} from "../../store/modules/wishlist/mutation-types";
import { ADD_TO_CART } from "../../store/modules/cart/mutation-types";

export default {
    computed: {
        ...mapGetters("wishlist", ["wishlist"]),
    },
    methods: {
        ...mapMutations("wishlist", {
            removeWishlist: REMOVE_FROM_WISHLIST,
        }),
        ...mapActions("cart", ["addToCart"]),
        ...mapActions("wishlist", ["removeFromWishlist"]),
        moveToCart(product) {
            this.removeWishlist({ product: product });
            this.addToCart({ product: product, qty: 1 });
        },
        stockStatus: function (product) {
            if (
                (product.enable_stock && product.stock_quantity <= 0) ||
                (product.enable_stock === 0 &&
                    product.stock_status === "out-of-stock")
            )
                return "Out Of Stock";
            return "In Stock";
        },
        getPageUrl: function (product) {
            if (!product.parent_id || product.id == product.parent_id) {
                return {
                    path: "/product/default/" + product.slug,
                };
            } else {
                return {
                    path: "/product/default/" + product.slug,
                    query: {
                        termId: product.excerpts.reduce((acc, cur) => {
                            return [...acc, cur.termId];
                        }, []),
                    },
                };
            }
        },
    },
};
</script>