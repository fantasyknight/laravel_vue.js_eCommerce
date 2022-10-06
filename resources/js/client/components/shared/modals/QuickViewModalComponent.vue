<template>
    <div class="product-single-container product-single-default product-quick-view mb-3">
        <div class="row">
            <div class="col-md-6 product-single-gallery">
                <div class="product-slider-container">
                    <div class="label-group">
                        <div
                            class="product-label label-hot"
                            v-if="product.featured"
                        >
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
                    <owl-carousel-component
                        class="product-single-carousel"
                        :options="{ dots: false, loop: false, margin: 0 }"
                    >
                        <div
                            class="product-item"
                            v-for="medium in product.media"
                            :key="medium.id"
                        >
                            <img
                                class="product-single-image"
                                v-lazy="
                                    $root.getUrl(medium.copy_link, true, 600)
                                "
                                :alt="
                                    medium.alt_text
                                        ? medium.alt_text
                                        : 'product'
                                "
                                width="600"
                                height="600"
                            />
                        </div>
                        <div
                            class="product-item"
                            v-if="product.media.length == 0"
                        >
                            <img
                                v-lazy="
                                    $root.getUrl(
                                        'server/images/placeholder-img.png'
                                    )
                                "
                                alt="product"
                                width="600"
                                height="600"
                            />
                        </div>
                    </owl-carousel-component>
                </div>
                <div
                    class="prod-thumbnail owl-dots"
                    id="carousel-custom-dots"
                >
                    <owl-carousel-component :options="{
                            dots: false,
                            loop: false,
                            margin: 5,
                            autoplay: false,
                            items: 4,
                        }">
                        <div
                            class="owl-dot"
                            :class="{ active: index == 0 }"
                            v-for="(medium, index) in product.media"
                            :key="medium.id"
                        >
                            <img
                                class="product-single-image"
                                v-lazy="
                                    $root.getUrl(medium.copy_link, true, 100)
                                "
                                alt="product"
                                width="100"
                                height="100"
                            />
                        </div>
                        <div
                            class="owl-dot"
                            v-if="product.media.length == 0"
                        >
                            <img
                                class="product-single-image"
                                :src="
                                    $root.getUrl(
                                        'server/images/placeholder-img-300x300.png'
                                    )
                                "
                                alt="product"
                                width="100"
                                height="100"
                            />
                        </div>
                    </owl-carousel-component>
                </div>
            </div>

            <div class="col-md-6 product-single-details mb-0">
                <h1 class="product-title">{{ product.name }}</h1>

                <div class="ratings-container mb-2 pb-2">
                    <div class="product-ratings">
                        <span
                            class="ratings"
                            :style="
                                'width:' + 20 * product.average_rating + '%'
                            "
                        ></span>
                    </div>

                    <a
                        href="#"
                        class="rating-link"
                        @click.prevent
                    >
                        {{ product.reviews_count }}
                        customer review
                    </a>
                    <span class="rating-link-separator">|</span>
                    <a
                        href="#"
                        class="rating-link"
                        @click.prevent
                    >Add a review</a>
                </div>

                <div
                    class="price-box"
                    v-if="product.type == 'simple'"
                >
                    <del
                        class="old-price"
                        v-if="
                            product.min_max_price[0] != product.min_max_price[1]
                        "
                    >
                        <span v-html="
                                formatPrice(product.min_max_price[1]) +
                                priceSuffix
                            "></span>
                    </del>
                    <span
                        class="product-price"
                        v-html="
                            formatPrice(product.min_max_price[0]) + priceSuffix
                        "
                    ></span>
                </div>
                <div
                    class="price-box"
                    v-if="product.type == 'variable'"
                >
                    <span
                        class="product-price"
                        v-html="
                            formatPrice(product.min_max_price[0]) + priceSuffix
                        "
                    ></span>
                    <span class="product-price">
                        –
                        <span v-html="
                                formatPrice(product.min_max_price[1]) +
                                priceSuffix
                            "></span>
                    </span>
                </div>

                <div class="product-desc mb-2">
                    <p v-html="product.short_desc"></p>
                </div>

                <ul class="single-info-list">
                    <li
                        v-if="
                            product.stock_status == 'out-of-stock' ||
                            product.manage_stock
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
                            v-for="(category, index) in product.categories"
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
                            >{{ category.name }}</router-link>

                            {{
                                index < product.categories.length - 1 ? "," : ""
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
                            {{ index < product.tags.length - 1 ? "," : "" }}
                        </strong>
                    </li>
                </ul>

                <div
                    class="product-filters-container"
                    v-if="product.type == 'variable'"
                >
                    <div
                        class="product-single-filter"
                        v-for="(attr, indexAttr) in attrFilters"
                        :key="attr.id"
                    >
                        <label class="mr-4">{{ attr.name }}:</label>
                        <ul class="config-size-list">
                            <li
                                :class="{ active: term.active }"
                                v-for="(term, indexTerm) in attr.options"
                                :key="term.id"
                            >
                                <template v-if="isColor(term.text)">
                                    <a
                                        href="#"
                                        :style="
                                            'background-color: ' + term.text
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
                                            'background-color: ' + term.text
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

                    <vue-slide-toggle :open="showPrice">
                        <div class="product-single-filter">
                            <label class="mr-4"></label>
                            <a
                                class="font1 text-uppercase clear-btn"
                                @click.prevent="clearFilter"
                                href="#"
                            >Clear</a>
                        </div>
                    </vue-slide-toggle>
                </div>

                <vue-slide-toggle :open="product.type == 'variable' && showPrice">
                    <div class="price-box mb-1">
                        <del
                            class="old-price"
                            v-if="
                                selectedProduct.min_max_price[0] !=
                                selectedProduct.min_max_price[1]
                            "
                        >
                            <span v-html="
                                    formatPrice(
                                        selectedProduct.min_max_price[1]
                                    ) + priceSuffix
                                "></span>
                        </del>
                        <span
                            class="product-price"
                            v-html="
                                formatPrice(selectedProduct.min_max_price[0]) +
                                priceSuffix
                            "
                        ></span>
                    </div>
                </vue-slide-toggle>
                <div
                    class="product-action"
                    v-if="
                        product.stock_status == 'on-backorder' ||
                        product.stock_status == 'in-stock' ||
                        product.stock_quantity > 0
                    "
                >
                    <div class="product-single-qty">
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
                <hr class="divider mb-1" />

                <div class="product-single-share">
                    <label class="sr-only">Share:</label>

                    <div class="social-icons mr-2">
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
                    <a
                        href="#"
                        class="add-wishlist browse-wishlist"
                        title="Remove from Wishlist"
                        v-if="isInWishlist(product)"
                        @click.prevent="
                            removeFromWishlist({ product: product })
                        "
                    >Remove from Wishlist</a>
                    <a
                        href="#"
                        class="add-wishlist"
                        title="Add to Wishlist"
                        v-else
                        :key="'out-wishlist'"
                        @click.prevent="addToWishlist({ product: product })"
                    >Add to Wishlist</a>
                </div>
            </div>
        </div>

        <button
            title="Close (Esc)"
            type="button"
            class="mfp-close"
            @click="$emit('close')"
        >
            ×
        </button>
    </div>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from "vuex";
import { VueSlideToggle } from 'vue-slide-toggle';

import OwlCarouselComponent from "../OwlCarouselComponent";
import HorizontalQuantityInputComponent from "../quantity-input/HorizontalQuantityInputComponent";

import { ADD_TO_CART } from "../../../store/modules/cart/mutation-types";
import {
    ADD_TO_WISHLIST,
    REMOVE_FROM_WISHLIST,
} from "../../../store/modules/wishlist/mutation-types";

export default {
    components: {
        OwlCarouselComponent,
        HorizontalQuantityInputComponent,
        VueSlideToggle
    },
    props: {
        product: Object,
        variations: Array,
        attributes: Array,
    },
    data: function () {
        return {
            qty: 1,
            attrFilters: [],
            showPrice: false,
            selectedProduct: {},
        };
    },
    computed: {
        ...mapGetters( "wishlist", [ "isInWishlist" ] ),
        ...mapGetters( "setting", [
            "getProductSettings",
            "formatPrice",
            "priceSuffix",
            "formatStock",
            "showNewBadge",
        ] ),
    },
    watch: {
        $route: function() {
            this.$modal.hideAll();
        }
    },
    created: function () {
        if ( this.product.type == "variable" ) {
            this.product.attributes = this.product.attributes.reduce(
                ( acc, cur ) => {
                    for ( let i = 0; i < this.attributes.length; i++ ) {
                        var termIds = cur.pivot.term_ids.split( "," );
                        if ( cur.id == this.attributes[ i ].id ) {
                            let termOpts = this.attributes[ i ].terms.reduce(
                                ( acc1, cur1 ) => {
                                    if ( termIds.includes( cur1.id.toString() ) ) {
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
                                },
                                []
                            );

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

            var attrOpts = [];
            this.product.attributes.map( ( attr ) => {
                if (
                    attr.pivot.used_for_variation &&
                    attr.pivot.term_ids.length > 0
                ) {
                    var options = [];
                    var activeTermId = null;
                    var activeTermName = null;
                    for ( var i = 0; i < attr.pivot.term_ids.length; i++ ) {
                        var result = attr.termOptions.find(
                            ( option ) => option.id == attr.pivot.term_ids[ i ]
                        );
                        if ( result ) {
                            if (
                                this.$route.query.termId &&
                                this.$route.query.termId.find(
                                    ( tr ) => tr == result.id
                                )
                            ) {
                                options.push( {
                                    ...result,
                                    active: true,
                                    enabled: true,
                                } );
                                activeTermName = this.isColor( result.text )
                                    ? result.slug
                                    : result.text;
                                activeTermId = result.id;
                            } else {
                                options.push( {
                                    ...result,
                                    active: false,
                                    enabled: false,
                                } );
                            }
                        }
                    }
                    attrOpts.push( {
                        name: attr.name,
                        id: attr.id,
                        activeTermId: activeTermId,
                        activeTermName: activeTermName,
                        options: options,
                    } );
                }
            } );

            this.attrFilters = [ ...attrOpts ];
            this.resetAttrFilter();
        } else if ( this.product.type == "simple" ) {
            this.selectedProduct = { ...this.product };
            this.showPrice = true;
        }
    },
    methods: {
        ...mapActions( "cart", [ "addToCart" ] ),
        ...mapMutations( "wishlist", {
            addToWishlist: ADD_TO_WISHLIST,
            removeFromWishlist: REMOVE_FROM_WISHLIST,
        } ),
        addCart: function () {
            if ( this.selectedProduct.media.length == 0 ) {
                this.selectedProduct.media = [ ...this.product.media ];
            }

            if ( this.product.type == "variable" ) {
                this.selectedProduct.sold_individually = this.product.sold_individually;
            }

            this.addToCart( { product: this.selectedProduct, qty: this.qty } );
        },
        changeQty: function ( id, qty ) {
            this.qty = qty;
        },
        getSaleRate: function ( salePrice, price ) {
            return ( ( 1 - salePrice / price ) * 100 ).toFixed();
        },
        isColor: function ( value ) {
            return value.includes( "#" );
        },

        clearFilter: function () {
            this.attrFilters = this.attrFilters.reduce( ( attrAcc, attrCur ) => {
                var options = attrCur.options.reduce( ( optAcc, optCur ) => {
                    return [
                        ...optAcc,
                        {
                            ...optCur,
                            enabled: false,
                            active: false,
                        },
                    ];
                }, [] );
                return [
                    ...attrAcc,
                    {
                        ...attrCur,
                        activeTermName: null,
                        activeTermId: null,
                        options: options,
                    },
                ];
            }, [] );
            this.resetAttrFilter();
        },

        changeAttrFilter: function ( attrIndex, termIndex ) {
            var activeTermId = null;
            var activeTermName = null;
            this.attrFilters[ attrIndex ].options = this.attrFilters[
                attrIndex
            ].options.reduce( ( acc, cur, index ) => {
                if ( termIndex == index ) {
                    if ( !cur.active ) {
                        activeTermId = cur.id;
                        activeTermName = this.isColor( cur.text )
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
            }, [] );
            this.attrFilters[ attrIndex ].activeTermId = activeTermId;
            this.attrFilters[ attrIndex ].activeTermName = activeTermName;
            this.resetAttrFilter();
        },

        resetAttrFilter: function () {
            var flag = true;
            var firstSelected = false;
            var tempAttrFilters = this.attrFilters.reduce(
                ( attrAcc, attrCur ) => {
                    var options = attrCur.options.reduce( ( optAcc, optCur ) => {
                        return [
                            ...optAcc,
                            {
                                ...optCur,
                                enabled: false,
                            },
                        ];
                    }, [] );
                    if ( !attrCur.activeTermId ) flag = false;
                    return [ ...attrAcc, { ...attrCur, options: [ ...options ] } ];
                },
                []
            );
            this.variations.map( ( variation, vIndex ) => {
                var excerpts = JSON.parse( variation.excerpt );
                var matchFlag = true;
                excerpts.map( ( excerpt ) => {
                    if ( excerpt.termId ) {
                        var attr = this.attrFilters.find(
                            ( item ) => item.id == excerpt.attrId
                        );

                        if (
                            attr &&
                            attr.activeTermId &&
                            attr.activeTermId !== excerpt.termId
                        )
                            matchFlag = false;
                    }
                } );

                if ( matchFlag ) {
                    if ( !firstSelected ) {
                        this.selectedProduct = variation;
                        firstSelected = true;
                    }
                    tempAttrFilters = tempAttrFilters.reduce(
                        ( attrAcc, attrCur ) => {
                            var excerpt = excerpts.find(
                                ( item ) => item.attrId == attrCur.id
                            );

                            var options;
                            if ( !excerpt.termId ) {
                                options = attrCur.options.reduce(
                                    ( optAcc, optCur ) => {
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
                                    ( optAcc, optCur ) => {
                                        if ( excerpt.termId == optCur.id ) {
                                            return [
                                                ...optAcc,
                                                {
                                                    ...optCur,
                                                    enabled: true,
                                                },
                                            ];
                                        } else {
                                            return [ ...optAcc, optCur ];
                                        }
                                    },
                                    []
                                );
                            }

                            return [
                                ...attrAcc,
                                {
                                    ...attrCur,
                                    options: [ ...options ],
                                },
                            ];
                        },
                        []
                    );
                }
            } );

            this.attrFilters = [ ...tempAttrFilters ];

            if ( flag ) {
                this.showPrice = true;
                this.selectedProduct.excerpts = tempAttrFilters.reduce(
                    ( attrAcc, attrCur ) => {
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
                var name = tempAttrFilters.reduce( ( attrAcc, attrCur ) => {
                    return (
                        attrAcc +
                        attrCur.activeTermName.replace(
                            attrCur.activeTermName[ 0 ],
                            attrCur.activeTermName[ 0 ].toUpperCase()
                        ) +
                        ", "
                    );
                }, this.product.name + " - " );

                this.selectedProduct.name = name.slice( 0, -2 );
            } else this.showPrice = false;
        },
    },
};
</script>