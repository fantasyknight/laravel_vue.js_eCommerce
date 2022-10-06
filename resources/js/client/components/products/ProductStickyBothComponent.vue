<template>
    <main class="main">
        <div class="container skeleton-body skel-shop-products">
            <product-breadcrumb-component :categories="product.categories" :name="product.name"></product-breadcrumb-component>
            <div class="product-single-container product-both-info">
                <div class="skel-pro skel-both-title"></div>
                <div class="product-single-details">
                    <div class="d-sm-flex">
                        <h1 class="product-title w-auto">{{ product.name }}</h1>

                        <product-nav-component class="pt-2 ml-5 position-relative top-0 float-right" :prev-product="prevProduct" :next-product="nextProduct"></product-nav-component>

                        <div class="product-single-share ml-sm-auto">
                            <label class="sr-only">Share:</label>

                            <div class="social-icons mr-2 pb-5 pb-md-0">
                                <a
                                    href="#"
                                    class="social-icon social-facebook icon-facebook"
                                    target="_blank"
                                    title="Facebook"
                                ></a>
                                <a
                                    href="#"
                                    class="social-icon social-twitter icon-twitter"
                                    target="_blank"
                                    title="Twitter"
                                ></a>
                                <a
                                    href="#"
                                    class="social-icon social-linkedin fab fa-linkedin-in"
                                    target="_blank"
                                    title="Linkedin"
                                ></a>
                                <a
                                    href="#"
                                    class="social-icon social-mail icon-mail-alt"
                                    target="_blank"
                                    title="Mail"
                                ></a>
                            </div>
                        </div>
                    </div>
                    <div class="ratings-container product-default">
                        <div class="product-ratings">
                            <span
                                class="ratings"
                                :style="
									'width:' + 20 * product.average_rating + '%'
								"
                            ></span>
                            <span
                                class="tooltiptext tooltip-top"
                            >{{ product.average_rating.toFixed(2) }}</span>
                        </div>

                        <a
                            href="#"
                            class="rating-link"
                            @click.prevent="toReviewTab"
                        >{{ approvedReviewsCount }} customer review</a>
                        <span class="rating-link-separator">|</span>
                        <a href="#" class="rating-link" @click.prevent="toReviewTab">Add a review</a>
                    </div>

                    <hr class="short-divider" />
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3" sticky-container>
                        <div class="sidebar-wrapper" v-sticky sticky-offset="{ top: 69 }">
                            <div class="skel-pro skel-sticky"></div>
                            <div class="product-single-details">
                                <div class="price-box" v-if="product.type == 'simple'">
                                    <del
                                        class="old-price"
                                        v-if="
											product.min_max_price[0] !=
											product.min_max_price[1]
										"
                                    >
                                        <span
                                            v-html="
												formatPrice(
													product.min_max_price[1]
												) + priceSuffix
											"
                                        ></span>
                                    </del>
                                    <span
                                        class="product-price"
                                        v-html="
											formatPrice(
												product.min_max_price[0]
											) + priceSuffix
										"
                                    ></span>
                                </div>
                                <div class="price-box" v-if="product.type == 'variable'">
                                    <span
                                        class="product-price"
                                        v-html="
											formatPrice(
												product.min_max_price[0]
											) + priceSuffix
										"
                                    ></span>
                                    <span
                                        class="product-price"
                                        v-if="product.min_max_price[0] !== product.min_max_price[1]"
                                    >
                                        –
                                        <span
                                            v-html="
												formatPrice(
													product.min_max_price[1]
												) + priceSuffix
											"
                                        ></span>
                                    </span>
                                </div>

                                <div class="product-desc mb-2">
                                    <p>
                                        <span v-html="product.short_desc"></span>
                                    </p>
                                </div>
                                <ul class="single-info-list">
                                    <li
                                        v-if="
											product.type == 'simple' &&
											(product.stock_status ==
												'out-of-stock' ||
												product.manage_stock)
										"
                                        v-html="formatStock(product)"
                                    ></li>
                                    <li v-if="product.sku">
                                        SKU:
                                        <strong>{{ product.sku }}</strong>
                                    </li>
                                    <li v-if="product.categories.length > 0">
                                        CATEGORIES:
                                        <strong
                                            v-for="(category,
											index) in product.categories"
                                            :key="category.id"
                                        >
                                            <router-link
                                                :to="{
													path: '/shop/default',
													query: {
														category: category.slug,
													},
												}"
                                                class="product-category"
                                            >
                                                {{
                                                category.name
                                                }}
                                            </router-link>
                                            {{
                                            index <
                                            product.categories.length - 1
                                            ? ","
                                            : ""
                                            }}
                                        </strong>
                                    </li>
                                    <li v-if="product.tags.length > 0">
                                        TAGs:
                                        <strong
                                            v-for="(tag, index) in product.tags"
                                            :key="tag.id"
                                        >
                                            <router-link
                                                :to="{
													path: '/shop/default',
													query: { tag: tag.slug },
												}"
                                                class="product-category"
                                            >{{ tag.name }}</router-link>
                                            {{
                                            index < product.tags.length - 1
                                            ? ","
                                            : ""
                                            }}
                                        </strong>
                                    </li>
                                </ul>

                                <router-link
                                    :to="'/pages/wishlist'"
                                    class="add-wishlist browse-wishlist pl-0"
                                    title="Browse Wishlist"
                                    v-if="isInWishlist(product)"
                                >Browse Wishlist</router-link>
                                <a
                                    href="#"
                                    class="add-wishlist pl-0"
                                    title="Add to Wishlist"
                                    v-else
                                    :key="'out-wishlist'"
                                    @click.prevent="
										addToWishlist({ product: product })
									"
                                >Add to Wishlist</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 product-single-gallery mb-lg-0">
                        <div class="skel-pro skel-magnifier-both"></div>
                        <div class="label-group">
                            <div class="product-label label-hot" v-if="product.featured">HOT</div>
                            <div class="product-label label-new" v-if="showNewBadge(product)">NEW</div>
                            <div
                                class="product-label label-sale"
                                v-if="
									product.type == 'simple' &&
									product.min_max_price[0] !=
										product.min_max_price[1]
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
                            class="product-item"
                            v-for="(medium, index) in product.media"
                            :key="medium.id"
                        >
                            <div class="inner">
                                <img
                                    class="product-single-image"
                                    :src="
										$root.getUrl(
											medium.copy_link,
											true,
											600
										)
									"
                                    width="600"
                                    height="600"
                                    :alt="
										medium.alt_text
											? medium.alt_text
											: 'product'
									"
                                />
                                <span class="prod-full-screen" @click="openGallery(index)">
                                    <i class="icon-plus"></i>
                                </span>
                            </div>
                        </div>
                        <div class="product-item" v-if="product.media.length == 0">
                            <img
                                :src="
									$root.getUrl(
										'server/images/placeholder-img-300x300.png'
									)
								"
                                width="300"
                                height="300"
                                alt="product"
                            />
                        </div>
                    </div>

                    <div class="col-lg-3" sticky-container>
                        <div
                            class="product-single-details sidebar-wrapper mb-3"
                            v-sticky
                            sticky-offset="{ top: 69 }"
                        >
                            <div class="skel-pro skel-sticky"></div>
                            <div class="product-single-details mb-lg-0">
                                <div
                                    class="product-filters-container"
                                    v-if="product.type == 'variable'"
                                >
                                    <div
                                        class="product-single-filter"
                                        v-for="(attr, indexAttr) in attrFilters"
                                        :key="attr.id"
                                    >
                                        <label>{{ attr.name }}:</label>
                                        <ul class="config-size-list">
                                            <li
                                                :class="{ active: term.active }"
                                                v-for="(term,
												indexTerm) in attr.options"
                                                :key="term.id"
                                            >
                                                <template v-if="isColor(term.text)">
                                                    <a
                                                        href="#"
                                                        :style="
															'background-color: ' +
															term.text
														"
                                                        class="filter-color border-0"
                                                        v-if="term.enabled"
                                                        :key="'is-color-1'"
                                                        @click.prevent="
															changeAttrFilter(
																indexAttr,
																indexTerm
															)
														"
                                                    ></a>
                                                    <a
                                                        href="javascript:;"
                                                        :style="
															'background-color: ' +
															term.text
														"
                                                        class="filter-color border-0 disabled"
                                                        v-else
                                                        :key="'is-color-2'"
                                                    ></a>
                                                </template>
                                                <template v-else>
                                                    <a
                                                        href="#"
                                                        v-if="term.enabled"
                                                        :key="'not-color-1'"
                                                        @click.prevent="
															changeAttrFilter(
																indexAttr,
																indexTerm
															)
														"
                                                    >{{ term.text }}</a>
                                                    <a
                                                        href="javascript:;"
                                                        class="disabled"
                                                        v-else
                                                        :key="'not-color-2'"
                                                    >{{ term.text }}</a>
                                                </template>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product-single-filter" v-if="showPrice">
                                        <label></label>
                                        <a
                                            class="font1 text-uppercase clear-btn"
                                            @click.prevent="clearFilter"
                                            href="#"
                                        >Clear</a>
                                    </div>
                                </div>

                                <div
                                    class="price-box"
                                    v-if="
										product.type == 'variable' && showPrice
									"
                                >
                                    <del
                                        class="old-price"
                                        v-if="
											selectedProduct.min_max_price[0] !=
											selectedProduct.min_max_price[1]
										"
                                    >
                                        <span
                                            v-html="
												formatPrice(
													selectedProduct
														.min_max_price[1]
												) + priceSuffix
											"
                                        ></span>
                                    </del>
                                    <span
                                        class="product-price"
                                        v-html="
											formatPrice(
												selectedProduct.min_max_price[0]
											) + priceSuffix
										"
                                    ></span>
                                </div>
                                <div
                                    class="variation-availability"
                                    v-if="
										product.type == 'variable' &&
										showPrice &&
										(selectedProduct.stock_status ==
											'out-of-stock' ||
											selectedProduct.manage_stock)
									"
                                    v-html="formatStock(selectedProduct)"
                                ></div>
                                <div
                                    class="product-action"
                                    v-if="
										product.stock_status == 'in-stock' ||
										product.stock_quantity > 0
									"
                                >
                                    <div class="product-single-qty d-flex align-items-center mb-1">
                                        <label for class="mr-4">QTY:</label>
                                        <horizontal-quantity-input-component
                                            :product="product"
                                            @change-qty="changeQty"
                                        ></horizontal-quantity-input-component>
                                    </div>

                                    <a
                                        href="#"
                                        class="btn btn-dark add-cart"
                                        title="Add to Cart"
                                        :class="{ disabled: !showPrice }"
                                        @click.prevent="addCart"
                                    >Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="skel-pro skel-tab skel-padding-20"></div>
            <div class="product-single-tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a
                            class="nav-link active"
                            id="product-tab-desc"
                            data-toggle="tab"
                            href="#product-desc-content"
                            role="tab"
                            aria-controls="product-desc-content"
                            aria-selected="true"
                        >Description</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="product-tab-more-info"
                            data-toggle="tab"
                            href="#product-more-info-content"
                            role="tab"
                            aria-controls="product-more-info-content"
                            aria-selected="false"
                        >Additional Info</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="product-tab-reviews"
                            data-toggle="tab"
                            href="#product-reviews-content"
                            role="tab"
                            aria-controls="product-reviews-content"
                            aria-selected="false"
                            v-if="getProductSettings.enableReview"
                        >Reviews ({{ approvedReviewsCount }})</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div
                        class="tab-pane fade show active"
                        id="product-desc-content"
                        role="tabpanel"
                        aria-labelledby="product-tab-desc"
                    >
                        <div class="product-desc-content" v-html="product.description"></div>
                        <div
                            class="product-desc-content"
                            v-if="!product.description"
                        >No description for the product</div>
                    </div>

                    <div
                        class="tab-pane fade fade"
                        id="product-more-info-content"
                        role="tabpanel"
                        aria-labelledby="product-tab-more-info"
                    >
                        <div class="product-desc-content">
                            <p class="mb-0" v-if="product.weight || selectedProduct.weight">
                                Weight: &nbsp;&nbsp;{{ selectedProduct.weight ? selectedProduct.weight : product.weight
                                }}{{ getProductSettings.weightUnit }}
                            </p>
                            <p
                                class="mb-0"
                                v-if="
									(product.length &&
									product.width &&
									product.height) ||
									(selectedProduct.length && selectedProduct.width && selectedProduct.height)
								"
                            >
                                Dimensions: &nbsp;&nbsp;
                                {{ selectedProduct.length ? selectedProduct.length : product.length }}
                                {{ getProductSettings.dimentionsUnit }} x
                                {{ selectedProduct.width ? selectedProduct.width : product.width }}
                                {{ getProductSettings.dimentionsUnit }} x
                                {{ selectedProduct.height ? selectedProduct.height : product.height }}
                                {{ getProductSettings.dimentionsUnit }}
                            </p>
                            <p
                                class="mb-0"
                                v-for="attr in product.attributes"
                                :key="attr.id"
                            >{{ attr.name }}: &nbsp;&nbsp;{{ termNames(attr) }}</p>
                        </div>
                    </div>

                    <div
                        class="tab-pane fade"
                        id="product-reviews-content"
                        role="tabpanel"
                        aria-labelledby="product-tab-reviews"
                        v-if="getProductSettings.enableReview"
                    >
                        <product-reviews-component
                            :product-id="product.id"
                            :product-name="product.name"
                            :approved-reviews-count="approvedReviewsCount"
                            :reviews="product.reviews"
                            @new-approved-review="incApprovedReviewsCount"
                        ></product-reviews-component>
                    </div>
                </div>
            </div>

            <div class="products-section pt-0" v-if="relatedProducts.length > 0 && this.loaded">
                <h2 class="section-title">Related Products</h2>
                <owl-carousel-component
                    class="products-slider dots-top"
                    :options="{
						loop: false,
						autoplay: false,
						dots: true,
						items: 2,
						responsive: { 576: { items: 3 }, 992: { items: 4 } },
					}"
                >
                    <product-one-component
                        :product="prod"
                        v-for="prod in relatedProducts"
                        :key="prod.id"
                    ></product-one-component>
                </owl-carousel-component>
            </div>
            <div class="products-section pt-0" v-if="upsells.length > 0 && this.loaded">
                <h2 class="section-title">You May Also Like</h2>

                <owl-carousel-component
                    class="products-slider dots-top"
                    :options="{
						loop: false,
						autoplay: false,
						dots: true,
						items: 2,
						responsive: { 576: { items: 3 }, 992: { items: 4 } },
					}"
                >
                    <product-one-component :product="prod" v-for="prod in upsells" :key="prod.id"></product-one-component>
                </owl-carousel-component>
            </div>
            <hr class="mt-0 m-b-5" />
            <div class="product-widgets-container row pb-2 mb-4">
                <div class="col-lg-3 col-sm-6 pb-5 pb-md-0">
                    <h4 class="section-sub-title m-b-3">Featured Products</h4>
                    <product-two-component
                        v-for="product in featuredProducts"
                        :key="product.id"
                        :product="product"
                    ></product-two-component>
                </div>
                <div class="col-lg-3 col-sm-6 pb-5 pb-md-0">
                    <h4 class="section-sub-title m-b-3">Best Selling Products</h4>
                    <product-two-component
                        v-for="product in bestSellings"
                        :key="product.id"
                        :product="product"
                    ></product-two-component>
                </div>
                <div class="col-lg-3 col-sm-6 pb-5 pb-md-0">
                    <h4 class="section-sub-title m-b-3">Latest Products</h4>
                    <product-two-component
                        v-for="product in newArrivals"
                        :key="product.id"
                        :product="product"
                    ></product-two-component>
                </div>
                <div class="col-lg-3 col-sm-6 pb-5 pb-md-0">
                    <h4 class="section-sub-title m-b-3">Top Rated Products</h4>
                    <product-two-component
                        v-for="product in topRates"
                        :key="product.id"
                        :product="product"
                    ></product-two-component>
                </div>
            </div>

            <LightBox
                ref="lightbox"
                class="porto-light-box"
                :media="lightBoxMedia"
                :show-caption="true"
                :show-light-box="false"
            />
        </div>
    </main>
</template>
<script>
import Sticky from "vue-sticky-directive";
import { mapGetters, mapActions, mapMutations } from "vuex";
import LightBox from "vue-image-lightbox";
import "vue-image-lightbox/dist/vue-image-lightbox.min.css";

import HorizontalQuantityInputComponent from "../shared/quantity-input/HorizontalQuantityInputComponent";
import OwlCarouselComponent from "../shared/OwlCarouselComponent";
import ProductOneComponent from "../shared/products/ProductOneComponent";
import ProductTwoComponent from "../shared/products/ProductTwoComponent";

import ProductBreadcrumbComponent from "./shared/ProductBreadcrumbComponent";
import ProductReviewsComponent from "./shared/ProductReviewsComponent";
import ProductNavComponent from './shared/ProductNavComponent';

import { ADD_TO_CART } from "../../store/modules/cart/mutation-types";
import {
    ADD_TO_WISHLIST,
    REMOVE_FROM_WISHLIST,
} from "../../store/modules/wishlist/mutation-types";

export default {
    components: {
        LightBox,

        HorizontalQuantityInputComponent,
        OwlCarouselComponent,
        ProductOneComponent,
        ProductTwoComponent,
        ProductBreadcrumbComponent,
        ProductReviewsComponent,
        ProductNavComponent
    },
    directives: {
        Sticky,
    },
    data: function () {
        return {
            loaded: false,
            product: {
                media: [],
                reviews: [],
                categories: [],
                tags: [],
                average_rating: 0,
            },
            prevProduct: null,
            nextProduct: null,
            variations: [],
            selectedProduct: {},
            showPrice: false,
            attrFilters: [],
            qty: 1,
            relatedProducts: [],
            upsells: [],
            approvedReviewsCount: 0,

            // Product Widget
            featuredProducts: [],
            bestSellings: [],
            newArrivals: [],
            topRates: [],
        };
    },
    computed: {
        ...mapGetters("wishlist", ["isInWishlist"]),
        ...mapGetters("setting", [
            "getProductSettings",
            "formatPrice",
            "formatStock",
            "priceSuffix",
            "showNewBadge",
        ]),
        ...mapGetters("user", ["isCustomer", "getUser", "userName"]),
        lightBoxMedia: function () {
            return this.product.media.reduce((acc, cur) => {
                return [
                    ...acc,
                    {
                        thumb: window.baseUrl + "/storage/" + cur.copy_link,
                        src: window.baseUrl + "/storage/" + cur.copy_link,
                        caption: this.product.name,
                    },
                ];
            }, []);
        },
    },
    watch: {
        $route: function () {
            this.getProduct();
        },
    },
    created: function () {
        this.getProduct();
    },
    methods: {
        ...mapActions("cart", ["addToCart"]),
        ...mapMutations("wishlist", {
            addToWishlist: ADD_TO_WISHLIST,
        }),

        addCart: function () {
            if (this.selectedProduct.media.length == 0) {
                this.selectedProduct.media = [...this.product.media];
            }

            if (this.product.type == "variable") {
                this.selectedProduct.sold_individually = this.product.sold_individually;
            }

            this.addToCart({ product: this.selectedProduct, qty: this.qty });
        },

        getSaleRate: function (salePrice, Price) {
            return ((1 - salePrice / Price) * 100).toFixed();
        },

        changeQty: function (id, qty) {
            this.qty = qty;
        },

        isColor: function (value) {
            return value.includes("#");
        },

        openGallery: function (index) {
            this.$refs.lightbox.showImage(index);
        },

        getProduct: function () {
            let savedInfo = JSON.parse(window.localStorage.getItem("product"));
            let email;
            if (this.isCustomer) {
                email = this.getUser.email;
            } else if (savedInfo) {
                email = savedInfo.email;
            }
            this.loaded = false;
            if (document.querySelector(".skeleton-body"))
                document
                    .querySelector(".skeleton-body")
                    .classList.remove("loaded");
            window.axios
                .get("/web/products/" + this.$route.params.slug, {
                    params: { author_email: email },
                })
                .then((response) => {
                    this.loaded = true;
                    this.product = { ...response.data.product };
                    this.relatedProducts = [...response.data.relatedProducts];
                    this.upsells = [...response.data.upsells];
                    this.featuredProducts = response.data.featuredProducts;
                    this.bestSellings = response.data.bestSellings;
                    this.newArrivals = response.data.newArrivals;
                    this.topRates = response.data.topRates;

                    var curIndex = -1;
                    this.relatedProducts.map((item, index) => {
                        if (item.id < this.product.id) curIndex = index;
                    });

                    if (curIndex >= 0)
                        this.prevProduct = this.relatedProducts[curIndex];
                    else this.prevProduct = null;

                    if (curIndex < this.relatedProducts.length - 1)
                        this.nextProduct = this.relatedProducts[curIndex + 1];
                    else this.nextProduct = null;

                    this.product.attributes = this.product.attributes.reduce(
                        (acc, cur) => {
                            for (
                                let i = 0;
                                i < response.data.attributes.length;
                                i++
                            ) {
                                var termIds = cur.pivot.term_ids.split(",");
                                if (cur.id == response.data.attributes[i].id) {
                                    let termOpts = response.data.attributes[
                                        i
                                    ].terms.reduce((acc1, cur1) => {
                                        if (
                                            termIds.includes(cur1.id.toString())
                                        ) {
                                            return [
                                                ...acc1,
                                                {
                                                    id: cur1.id,
                                                    text: cur1.name,
                                                    slug: cur1.slug,
                                                },
                                            ];
                                        } else {
                                            return acc1;
                                        }
                                    }, []);

                                    return [
                                        ...acc,
                                        {
                                            ...cur,
                                            pivot: {
                                                ...cur.pivot,
                                                term_ids: termIds,
                                            },
                                            termOptions: termOpts,
                                        },
                                    ];
                                }
                            }

                            return acc;
                        },
                        []
                    );

                    if (response.data.product.type == "variable") {
                        this.variations = [...response.data.variations];

                        var attrOpts = [];
                        this.product.attributes.map((attr) => {
                            if (
                                attr.pivot.used_for_variation &&
                                attr.pivot.term_ids.length > 0
                            ) {
                                var options = [];
                                var activeTermId = null;
                                var activeTermName = null;
                                for (
                                    var i = 0;
                                    i < attr.pivot.term_ids.length;
                                    i++
                                ) {
                                    var result = attr.termOptions.find(
                                        (option) =>
                                            option.id == attr.pivot.term_ids[i]
                                    );
                                    if (result) {
                                        if (
                                            this.$route.query.termId &&
                                            this.$route.query.termId.find(
                                                (tr) => tr == result.id
                                            )
                                        ) {
                                            options.push({
                                                ...result,
                                                active: true,
                                                enabled: true,
                                            });
                                            activeTermName = this.isColor(
                                                result.text
                                            )
                                                ? result.slug
                                                : result.text;
                                            activeTermId = result.id;
                                        } else {
                                            options.push({
                                                ...result,
                                                active: false,
                                                enabled: false,
                                            });
                                        }
                                    }
                                }
                                attrOpts.push({
                                    name: attr.name,
                                    id: attr.id,
                                    activeTermId: activeTermId,
                                    activeTermName: activeTermName,
                                    options: options,
                                });
                            }
                        });

                        this.attrFilters = [...attrOpts];
                        this.resetAttrFilter();
                    } else if (response.data.product.type == "simple") {
                        this.selectedProduct = { ...this.product };
                        this.showPrice = true;
                    }

                    this.approvedReviewsCount = this.product.approved_reviews_count;

                    if (document.querySelector(".skeleton-body"))
                        document
                            .querySelector(".skeleton-body")
                            .classList.add("loaded");
                })
                .catch((error) => {
                    this.$router.push("/pages/404");
                });
        },

        clearFilter: function () {
            this.attrFilters = this.attrFilters.reduce((attrAcc, attrCur) => {
                var options = attrCur.options.reduce((optAcc, optCur) => {
                    return [
                        ...optAcc,
                        {
                            ...optCur,
                            enabled: false,
                            active: false,
                        },
                    ];
                }, []);
                return [
                    ...attrAcc,
                    {
                        ...attrCur,
                        activeTermName: null,
                        activeTermId: null,
                        options: options,
                    },
                ];
            }, []);
            this.resetAttrFilter();
        },

        changeAttrFilter: function (attrIndex, termIndex) {
            var activeTermId = null;
            var activeTermName = null;
            this.attrFilters[attrIndex].options = this.attrFilters[
                attrIndex
            ].options.reduce((acc, cur, index) => {
                if (termIndex == index) {
                    if (!cur.active) {
                        activeTermId = cur.id;
                        activeTermName = this.isColor(cur.text)
                            ? cur.slug
                            : cur.text;
                    }
                    return [
                        ...acc,
                        {
                            ...cur,
                            active: !cur.active,
                        },
                    ];
                } else {
                    return [
                        ...acc,
                        {
                            ...cur,
                            active: false,
                        },
                    ];
                }
            }, []);
            this.attrFilters[attrIndex].activeTermId = activeTermId;
            this.attrFilters[attrIndex].activeTermName = activeTermName;
            this.resetAttrFilter();
        },

        resetAttrFilter: function () {
            var flag = true;
            var firstSelected = false;
            var tempAttrFilters = this.attrFilters.reduce(
                (attrAcc, attrCur) => {
                    var options = attrCur.options.reduce((optAcc, optCur) => {
                        return [
                            ...optAcc,
                            {
                                ...optCur,
                                enabled: false,
                            },
                        ];
                    }, []);
                    if (!attrCur.activeTermId) flag = false;
                    return [...attrAcc, { ...attrCur, options: [...options] }];
                },
                []
            );
            this.variations.map((variation, vIndex) => {
                var excerpts = JSON.parse(variation.excerpt);
                var matchFlag = true;
                excerpts.map((excerpt) => {
                    if (excerpt.termId) {
                        var attr = this.attrFilters.find(
                            (item) => item.id == excerpt.attrId
                        );

                        if (
                            attr &&
                            attr.activeTermId &&
                            attr.activeTermId !== excerpt.termId
                        )
                            matchFlag = false;
                    }
                });

                if (matchFlag) {
                    if (!firstSelected) {
                        this.selectedProduct = variation;
                        firstSelected = true;
                    }
                    tempAttrFilters = tempAttrFilters.reduce(
                        (attrAcc, attrCur) => {
                            var excerpt = excerpts.find(
                                (item) => item.attrId == attrCur.id
                            );

                            var options;
                            if (!excerpt.termId) {
                                options = attrCur.options.reduce(
                                    (optAcc, optCur) => {
                                        return [
                                            ...optAcc,
                                            {
                                                ...optCur,
                                                enabled: true,
                                            },
                                        ];
                                    },
                                    []
                                );
                            } else {
                                var options = attrCur.options.reduce(
                                    (optAcc, optCur) => {
                                        if (excerpt.termId == optCur.id) {
                                            return [
                                                ...optAcc,
                                                {
                                                    ...optCur,
                                                    enabled: true,
                                                },
                                            ];
                                        } else {
                                            return [...optAcc, optCur];
                                        }
                                    },
                                    []
                                );
                            }

                            return [
                                ...attrAcc,
                                {
                                    ...attrCur,
                                    options: [...options],
                                },
                            ];
                        },
                        []
                    );
                }
            });

            this.attrFilters = [...tempAttrFilters];

            if (flag) {
                this.showPrice = true;
                this.selectedProduct.excerpts = tempAttrFilters.reduce(
                    (attrAcc, attrCur) => {
                        return [
                            ...attrAcc,
                            {
                                attrId: attrCur.id,
                                termId: attrCur.activeTermId,
                            },
                        ];
                    },
                    []
                );
                var name = tempAttrFilters.reduce((attrAcc, attrCur) => {
                    return (
                        attrAcc +
                        attrCur.activeTermName.replace(
                            attrCur.activeTermName[0],
                            attrCur.activeTermName[0].toUpperCase()
                        ) +
                        ", "
                    );
                }, this.product.name + " - ");

                this.selectedProduct.name = name.slice(0, -2);
            } else this.showPrice = false;
        },

        termNames: function (attribute) {
            var names = "";
            attribute.termOptions.map((term, index) => {
                if (index == 0)
                    names += this.isColor(term.text) ? term.slug : term.text;
                else
                    names +=
                        ",  " +
                        (this.isColor(term.text) ? term.slug : term.text);
            });

            return names;
        },

        toReviewTab: function () {
            var reviewLink = document.querySelector("#product-tab-reviews");
            reviewLink.click();
            reviewLink.scrollIntoView({ behavior: "smooth" });
        },

        incApprovedReviewsCount: function () {
            this.approvedReviewsCount++;
        },
    },
};
</script>