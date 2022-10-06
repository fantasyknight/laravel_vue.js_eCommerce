<template>
    <div class="header-search">
        <a
            href="#"
            class="search-toggle"
            @click="searchToggle"
            role="button"
        >
            <i class="icon-magnifier"></i>
        </a>
        <form
            action="#"
            method="get"
            @click.stop="showSearchForm"
            @submit.prevent="searchProducts"
        >
            <div class="header-search-wrapper">
                <input
                    type="text"
                    class="form-control"
                    autocomplete="false"
                    placeholder="Search..."
                    required
                    v-model="searchTerm"
                    @input="searchProducts"
                />
                <div
                    class="select-custom"
                    v-if="showCategory"
                >
                    <select
                        id="cat"
                        name="cat"
                        v-model="category"
                        @change="searchProducts"
                    >
                        <option value="*">All Categories</option>
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >{{ category.name }}</option>
                    </select>
                </div>
                <button
                    class="btn icon-search-3"
                    type="submit"
                ></button>

                <div class="live-search-list">
                    <div
                        class="autocomplete-suggestions"
                        v-if="suggestions.length > 0"
                        @click="goProductPage"
                    >
                        <router-link
                            :to="'/product/default/' + product.slug"
                            class="autocomplete-suggestion"
                            data-index="0"
                            v-for="product in suggestions"
                            :key="product.id"
                        >
                            <img
                                v-lazy="
									$root.getUrl(
										product.media[0].copy_link,
										true,
										100
									)
								"
                                v-if="product.media.length > 0"
                                :alt="
									product.media[0].alt_text
										? product.media[0].alt_text
										: 'product'
								"
                                width="40"
                                height="40"
                            />
                            <img
                                :src="
									$root.getUrl(
										'server/images/placeholder-img-100x100'
									)
								"
                                alt="product"
                                width="40"
                                height="40"
                                v-else
                            />
                            <div
                                class="search-name"
                                v-html="matchEmphasize(product.name)"
                            ></div>
                            <span class="search-price">
                                <template v-if="product.type == 'simple'">
                                    <del
                                        class="old-price"
                                        v-if="
											product.min_max_price[0] !=
											product.min_max_price[1]
										"
                                    >${{ product.min_max_price[0] }}</del>
                                    <span class="product-price">${{ product.min_max_price[1] }}</span>
                                </template>
                                <template v-if="(product.type = 'variable')">
                                    <span class="product-price">${{ product.min_max_price[0] }}</span>
                                    <span class="product-price">- ${{ product.min_max_price[1] }}</span>
                                </template>
                            </span>
                        </router-link>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        categories: Array,
        showCategory: Number
    },
    data: function () {
        return {
            searchTerm: "",
            category: "*",
            suggestions: [],
            timeouts: [],
        };
    },
    mounted: function () {
        document
            .querySelector( "body" )
            .addEventListener( "click", this.closeSearchForm );
    },
    methods: {
        searchProducts: function () {
            if ( this.searchTerm.length > 2 ) {
                var searchTerm = this.searchTerm;
                this.timeouts.map( ( timeout ) => {
                    window.clearTimeout( timeout );
                } );
                this.timeouts.push(
                    setTimeout( () => {
                        window.axios
                            .get( "/web/products-search", {
                                params: {
                                    search_term: searchTerm,
                                    category: this.category,
                                },
                            } )
                            .then( ( response ) => {
                                this.suggestions = [ ...response.data.products ];
                            } )
                            .catch( ( error ) => { } );
                    }, 500 )
                );
            } else {
                this.timeouts.map( ( timeout ) => {
                    window.clearTimeout( timeout );
                } );
                this.suggestions = [];
            }
        },
        matchEmphasize: function ( name ) {
            var regExp = new RegExp( this.searchTerm, "i" );
            return name.replace(
                regExp,
                ( match ) => "<strong>" + match + "</strong>"
            );
        },
        goProductPage: function () {
            this.searchTerm = "";
            this.suggestions = [];
            this.category = "*";
        },
        searchToggle: function ( e ) {
            document.querySelector( ".header-search" ).classList.toggle( "show" );
            e.stopPropagation();
        },

        showSearchForm: function () {
            document
                .querySelector( ".header .header-search" )
                .classList.add( "show" );
        },
        closeSearchForm: function ( e ) {
            document
                .querySelector( ".header .header-search" )
                .classList.remove( "show" );
        },
    },
};
</script>