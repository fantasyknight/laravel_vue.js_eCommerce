<template>
	<div class="sidebar-wrapper">
		<div class="widget widget-product-categories">
			<h3 class="widget-title">
				<a
					href="#"
					@click.prevent="categorySlideOpen = !categorySlideOpen"
					:class="{ collapsed: !categorySlideOpen }"
					>Categories</a
				>
			</h3>

			<vue-slide-toggle
				:open="categorySlideOpen"
				:duration="200"
				class="show"
			>
				<div class="widget-body">
					<vue-tree-list :model="treeData">
						<template v-slot:leafNameDisplay="slotProps">
							<router-link
								:to="{
									path: $route.path,
									query: {
										category: slotProps.model.slug,
									},
								}"
								:class="{
									active: setActiveCategory(slotProps.model),
								}"
								>{{ slotProps.model.name }}
							</router-link>
							({{ slotProps.model.count }})
						</template>
						<template v-slot:treeNodeIcon>
							<span></span>
						</template>
					</vue-tree-list>
				</div>
			</vue-slide-toggle>
		</div>

		<div class="widget" v-if="isResetFilterShow">
			<router-link
				class="btn btn-primary reset-filter-btn"
				:to="$route.path"
				>Reset All Filters</router-link
			>
		</div>

		<div class="widget">
			<h3 class="widget-title">
				<a
					href="#"
					@click.prevent="priceSlideOpen = !priceSlideOpen"
					:class="{ collapsed: !priceSlideOpen }"
					>Price</a
				>
			</h3>

			<vue-slide-toggle
				:open="priceSlideOpen"
				:duration="200"
				class="show"
			>
				<div class="widget-body">
					<div class="price-slider-wrapper">
						<vue-nouislider
							:config="priceSliderConfig"
							:values="priceValues"
							id="price-slider"
							v-if="loaded"
						></vue-nouislider>
					</div>

					<div
						class="filter-price-action d-flex align-items-center justify-content-between flex-wrap"
					>
						<div class="filter-price-text">
							Price:
							<span id="filter-price-range">{{
								priceRangeText
							}}</span>
						</div>

						<router-link
							:to="setFilterRoute()"
							class="btn btn-primary"
							>Filter</router-link
						>
					</div>
				</div>
			</vue-slide-toggle>
		</div>

		<div
			class="widget"
			v-for="(attr, index) in attributes"
			:key="'attr' + attr.id"
		>
			<h3 class="widget-title">
				<a
					href="#"
					@click.prevent="attrSlideChange(index)"
					:class="{ collapsed: !attributeSlideOpen[index] }"
					>{{ attr.name }}</a
				>
			</h3>

			<vue-slide-toggle
				:open="attributeSlideOpen[index]"
				:duration="200"
				class="show"
			>
				<div class="product-single-filter mb-0">
					<div class="widget-body config-size-list">
						<ul class="mb-0">
							<li
								v-for="term in attr.terms"
								:key="'term' + term.id"
								:class="{ active: setActiveTerm(term) }"
							>
								<router-link
									:to="setFilterRouteQuery(term)"
									:style="'background-color: ' + term.name"
									class="filter-color border-0"
									key="is-color-1"
									v-if="isColor(term.name)"
								></router-link>
								<router-link
									:to="setFilterRouteQuery(term)"
									key="not-color-1"
									v-else
									>{{ term.name }}</router-link
								>
							</li>
						</ul>
					</div>
				</div>
			</vue-slide-toggle>
		</div>

		<div
			class="widget widget-featured-products"
			v-if="$route.path !== '/shop/horizontal-filter1'"
		>
			<h3 class="widget-title">
				<a
					href="#"
					@click.prevent="featuredSlideOpen = !featuredSlideOpen"
					:class="{ collapsed: !featuredSlideOpen }"
					>Featured Products</a
				>
			</h3>

			<vue-slide-toggle
				:open="featuredSlideOpen"
				:duration="200"
				class="show"
			>
				<div class="widget-body">
					<product-two-component
						v-for="product in featuredProducts.slice(0, 3)"
						:key="'sidebar-featured' + product.id"
						:product="product"
					></product-two-component>
				</div>
			</vue-slide-toggle>
		</div>
	</div>
</template>

<script>
import { mapGetters } from "vuex";
import { VueTreeList, Tree, TreeNode } from "vue-tree-list";
import { VueSlideToggle } from "vue-slide-toggle";

import ProductTwoComponent from "../../shared/products/ProductTwoComponent";

export default {
	components: {
		VueTreeList,
		VueSlideToggle,
		ProductTwoComponent,
	},
	data: function () {
		return {
			loaded: true,
			attributes: [],
			categories: [],
			featuredProducts: [],
			categorySlideOpen: true,
			priceSlideOpen: true,
			attributeSlideOpen: [],
			priceValues: [0, 1000],
			featuredSlideOpen: true,
			priceSliderConfig: {
				// start: [0, 1000],
				connect: true,
				step: 50,
				margin: 100,
				range: {
					min: 0,
					max: 1000,
				},
			},
			isResetFilterShow: false,
			shouldSticky: true,
		};
	},
	computed: {
		...mapGetters("setting", ["getSetting"]),
		treeData: function () {
			return new Tree(this.categories);
		},
		priceRangeText: function () {
			return (
				"$" +
				parseInt(this.priceValues[0]) +
				" — $" +
				parseInt(this.priceValues[1])
			);
		},
	},
	watch: {
		$route: function () {
			if (this.$route.query.min_price && this.$route.query.max_price) {
				this.loaded = false;
				this.priceValues = [
					this.$route.query.min_price,
					this.$route.query.max_price,
				];
				this.$nextTick(function () {
					this.loaded = true;
				});
			} else {
				this.loaded = false;
				this.priceValues = [
					parseInt(this.getSetting("filter_min_price")),
					parseInt(this.getSetting("filter_max_price")),
				];
				this.$nextTick(function () {
					this.loaded = true;
				});
			}

			if (Object.values(this.$route.query).length > 0) {
				this.isResetFilterShow = true;
			} else {
				this.isResetFilterShow = false;
			}
		},
	},
	methods: {
		isColor: function (value) {
			return value.includes("#");
		},
		changeAttrFilter: function (attr, term, event) {
			event.target.parentNode.classList.toggle("active");
		},
		setFilterRouteQuery: function (term) {
			if (!this.$route.query.attributes) {
				return {
					path: this.$route.fullPath,
					query: {
						...this.$route.query,
						attributes: term.slug,
					},
				};
			} else if (
				this.$route.query.attributes
					.split(",")
					.findIndex((attrSlug) => attrSlug == term.slug) == -1
			) {
				return {
					path: this.$route.fullPath,
					query: {
						...this.$route.query,
						attributes: [
							...this.$route.query.attributes.split(","),
							term.slug,
						].join(","),
					},
				};
			} else {
				return {
					path: this.$route.fullPath,
					query: {
						...this.$route.query,
						attributes: this.$route.query.attributes
							.split(",")
							.filter((attrSlug) => attrSlug !== term.slug)
							.join(","),
					},
				};
			}
		},
		setActiveTerm: function (term) {
			if (
				!this.$route.query.attributes ||
				this.$route.query.attributes
					.split(",")
					.findIndex((item) => item == term.slug) == -1
			)
				return false;
			return true;
		},
		setActiveCategory: function (category) {
			if (
				this.$route.query.category &&
				this.$route.query.category == category.slug
			)
				return true;
			else return false;
		},
		attrSlideChange: function (index) {
			this.attributeSlideOpen = this.attributeSlideOpen.reduce(
				(acc, cur, ind) => {
					if (index == ind) return [...acc, !cur];
					else return [...acc, cur];
				},
				[]
			);
		},
		setFilterRoute: function () {
			return {
				path: this.$route.path,
				query: {
					...this.$route.query,
					min_price: parseInt(this.priceValues[0]),
					max_price: parseInt(this.priceValues[1]),
				},
			};
		},
	},
	created: function () {
		if (this.$route.query.min_price && this.$route.query.max_price) {
			this.priceValues = [
				this.$route.query.min_price,
				this.$route.query.max_price,
			];
		} else {
			this.priceValues = [
				parseInt(this.getSetting("filter_min_price")),
				parseInt(this.getSetting("filter_max_price")),
			];
		}

		this.priceSliderConfig = {
			...this.priceSliderConfig,
			range: {
				min: parseInt(this.getSetting('filter_min_price')),
				max: parseInt(this.getSetting('filter_max_price'))
			}
		}

		if (Object.values(this.$route.query).length > 0) {
			this.isResetFilterShow = true;
		} else {
			this.isResetFilterShow = false;
		}

		window.axios
			.get("/web/shop/sidebar")
			.then((response) => {
				this.attributes = response.data.attributes;
				this.categories = response.data.categories;
				this.featuredProducts = response.data.featuredProducts;
				this.attributeSlideOpen = this.attributes.reduce((acc, cur) => {
					return [...acc, true];
				}, []);
			})
			.catch((error) => {});
	},
};
</script>