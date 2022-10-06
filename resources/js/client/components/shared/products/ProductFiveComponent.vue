<template>
    <div class="product-default">
        <figure>
            <div
                class="d-loading-container"
                :class="{ 'd-none': !modalLoading }"
            >
                <div class="d-loading small"></div>
            </div>
            <router-link
                :to="'/product/default/' + product.slug"
                v-if="product.media.length > 0"
                :key="'media-0'"
            >
                <img
                    v-for="(medium, index) in media"
                    v-lazy="$root.getUrl(medium.copy_link, true, 300)"
                    :key="index"
                    width="300"
                    height="300"
                    :alt="medium.alt_text ? medium.alt_text : 'product'"
                />
            </router-link>
            <router-link
                :to="'/product/default/' + product.slug"
                v-else
                :key="'media-1'"
            >
                <img
                    v-lazy="
                        $root.getUrl(
                            'server/images/placeholder-img-300x300.png'
                        )
                    "
                    width="300"
                    height="300"
                    alt="product"
                />
            </router-link>
            <div class="label-group">
                <div class="product-label label-hot" v-if="product.featured">
                    HOT
                </div>
                <div
                    class="product-label label-new"
                    v-if="showNewBadge(product)"
                >
                    NEW
                </div>
                <div
                    class="product-label label-sale"
                    v-if="
                        product.type == 'simple' &&
                        product.min_max_price[0] != product.min_max_price[1]
                    "
                >
                    -{{
                        getSaleRate(
                            product.min_max_price[0],
                            product.min_max_price[1]
                        )
                    }}%
                </div>
            </div>

            <div
                class="out-of-stock-label"
                v-if="product.stock_status == 'out-of-stock'"
            >
                OUT OF STOCK
            </div>
            <count-down-component
                v-if="isCountdown"
                :sale-end="product.sale_end"
            ></count-down-component>
        </figure>
        <div class="product-details">
            <div class="category-list" v-if="getProductSettings.showCategory">
                <span
                    v-for="(category, index) in product.categories"
                    :key="index"
                >
                    <router-link
                        :to="{
                            path: '/shop/default',
                            query: { category: category.slug },
                        }"
                        class="product-category"
                        >{{ category.name }}</router-link
                    >{{ index < product.categories.length - 1 ? "," : "" }}
                </span>
            </div>
            <h3 class="product-title">
                <router-link :to="'/product/default/' + product.slug">
                    {{ product.name }}
                </router-link>
            </h3>
            <div
                class="ratings-container"
                v-if="getProductSettings.showRatings"
            >
                <div class="product-ratings">
                    <span
                        class="ratings"
                        :style="'width:' + 20 * product.average_rating + '%'"
                    ></span>
                    <span class="tooltiptext tooltip-top">{{
                        product.average_rating.toFixed(2)
                    }}</span>
                </div>
            </div>

            <div class="price-box" v-if="product.type == 'simple'">
                <del
                    class="old-price"
                    v-if="product.min_max_price[0] != product.min_max_price[1]"
                >
                    <span
                        v-html="
                            formatPrice(product.min_max_price[1]) + priceSuffix
                        "
                    >
                    </span>
                </del>
                <span
                    class="product-price"
                    v-html="formatPrice(product.min_max_price[0]) + priceSuffix"
                ></span>
            </div>
            <div class="price-box" v-if="product.type == 'variable'">
                <span
                    class="product-price"
                    v-html="formatPrice(product.min_max_price[0]) + priceSuffix"
                ></span>
                <span
                    class="product-price"
                    v-if="product.min_max_price[0] !== product.min_max_price[1]"
                >
                    –
                    <span
                        v-html="
                            formatPrice(product.min_max_price[1]) + priceSuffix
                        "
                    ></span>
                </span>
            </div>

            <div class="product-action">
                <router-link
                    to="/pages/wishlist"
                    class="btn-icon-wish text-primary"
                    v-if="isInWishlist(product)"
                    :key="'in-wishlist'"
                >
                    <i class="icon-heart-1"></i>
                    <label class="sr-only">Wishlist</label>
                </router-link>
                <a
                    href="#"
                    class="btn-icon-wish"
                    v-else
                    :key="'out-wishlist'"
                    @click.prevent="addWishlist()"
                >
                    <i class="icon-heart"></i>
                    <label class="sr-only">Wishlist</label>
                    <div
                        class="d-loading small"
                        :class="{ 'd-none': !wishLoading }"
                    ></div>
                </a>
                <button
                    class="btn-icon btn-add-cart"
                    @click="addCart"
                    v-if="product.type == 'simple' && canAddToCart(product)"
                    key="can-cart"
                >
                    ADD TO CART
                </button>
                <router-link
                    :to="'/product/default/' + product.slug"
                    class="btn btn-icon btn-add-cart"
                    v-else-if="product.type == 'simple'"
                    key="cannot-cart"
                >
                    READ MORE
                </router-link>
                <router-link
                    :to="'/product/default/' + product.slug"
                    class="btn btn-icon btn-add-cart"
                    v-if="product.type == 'variable'"
                    >Select Options</router-link
                >
                <a
                    href="#"
                    class="btn-quickview"
                    title="Quick View"
                    @click.prevent="quickView"
                >
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";

import CountDownComponent from "../CountDownComponent";

import { ADD_TO_CART } from "../../../store/modules/cart/mutation-types";
import { ADD_TO_WISHLIST } from "../../../store/modules/wishlist/mutation-types";

export default {
    components: {
        CountDownComponent,
    },
    props: {
        product: {
            type: Object,
            default: function () {
                return {
                    type: "simple",
                    sale_schedule: false,
                    virtual: false,
                    downloadable: false,
                    tax_status: "taxable",
                    tax_type_id: 1,
                    allow_backorder: "no",
                    stock_status: "in-stock",
                    manage_stock: false,
                    media: [],
                    tags: [],
                    files: [],
                };
            },
        },
    },
    data: function () {
        return {
            wishLoading: false,
            modalLoading: false,
        };
    },
    computed: {
        ...mapGetters( "wishlist", [ "isInWishlist" ] ),
        ...mapGetters( "cart", [ "canAddToCart" ] ),
        ...mapGetters( "setting", [
            "getSetting",
            "getProductSettings",
            "priceSuffix",
            "formatPrice",
            "showNewBadge",
        ] ),
        media: function () {
            return this.product.media.slice( 0, 2 );
        },
        isCountdown: function () {
            return (
                this.getProductSettings.showProductCountDown &&
                this.product.type == "simple" &&
                this.product.sale_price &&
                this.product.sale_schedule &&
                new Date( this.product.sale_end ) > new Date()
            );
        },
    },
    methods: {
        ...mapMutations( "cart", {
            addToCart: ADD_TO_CART,
        } ),

        ...mapMutations( "wishlist", {
            addToWishlist: ADD_TO_WISHLIST,
        } ),

        getSaleRate: function ( salePrice, price ) {
            return ( ( 1 - salePrice / price ) * 100 ).toFixed();
        },

        addCart: function () {
            if ( this.getSetting( "cart_popup_type" ) === 'CartModalOneComponent' ) {
                if ( this.modalLoading == false ) {
                    this.modalLoading = true;

                    setTimeout( () => {
                        this.addToCart( { product: this.product, qty: 1 } );
                        this.modalLoading = false;
                        this.$modal.show(
                            () => import( "../modals/" + this.getSetting( "cart_popup_type" ) ),
                            { product: this.product },
                            { width: "320", height: "auto", adaptive: true }
                        );
                    }, 300 );
                }
            } else {
                this.addToCart( { product: this.product, qty: 1 } );
                this.$root.$notify( {
                    group: 'addCartSuccess',
                    text: `has been added to your cart!`,
                    data: this.product
                } );
            }
        },

        addWishlist: function () {
            this.wishLoading = true;
            setTimeout( () => {
                this.wishLoading = false;
                this.addToWishlist( { product: this.product } );
            }, 1000 );
        },

        quickView: function () {
            this.modalLoading = true;
            window.axios
                .get( "/web/products/quick/" + this.product.slug )
                .then( ( response ) => {
                    setTimeout( () => {
                        this.modalLoading = false;
                        this.$modal.show(
                            () => import( "../modals/QuickViewModalComponent" ),
                            {
                                product: response.data.product,
                                variations: response.data.variations,
                                attributes: response.data.attributes
                            },
                            { width: "930", height: "auto", adaptive: true }
                        );
                    }, 300 );
                } )
                .catch( ( error ) => { } );
        },
    },
};
</script>