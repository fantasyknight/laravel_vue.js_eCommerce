<template>
	<div class="product-default left-details product-widget">
		<figure>
			<router-link
				:to="getPageUrl()"
				v-if="product.media.length > 0"
				:key="'media-0'"
			>
				<img
					v-for="(medium, index) in media"
					v-lazy="$root.getUrl(medium.copy_link, true, 300)"
					width="300"
					height="300"
					:key="index"
					:alt="medium.alt_text ? medium.alt_text : 'product'"
				/>
			</router-link>
			<router-link :to="getPageUrl()" v-else :key="'media-1'">
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
		</figure>
		<div class="product-details">
			<h3 class="product-title">
				<router-link :to="getPageUrl()">{{ product.name }}</router-link>
			</h3>
			<div class="ratings-container">
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
				<span class="product-price" v-if="product.min_max_price[0] !== product.min_max_price[1]">
					–
					<span
						v-html="
							formatPrice(product.min_max_price[1]) + priceSuffix
						"
					></span
				></span>
			</div>
		</div>
	</div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
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
	computed: {
		...mapGetters("setting", ["formatPrice", "priceSuffix"]),
		media: function () {
			return this.product.media.slice(0, 2);
		},
	},
	methods: {
		getPageUrl: function () {
			if (this.product.parent == 0) {
				return {
					path: "/product/default/" + this.product.slug,
				};
			} else {
				return {
					path: "/product/default/" + this.product.slug,
					query: {
						termId: JSON.parse(this.product.excerpt).reduce(
							(acc, cur) => {
								return [...acc, cur.termId];
							},
							[]
						),
					},
				};
			}
		},
	},
};
</script>