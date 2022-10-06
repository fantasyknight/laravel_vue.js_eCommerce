<template>
	<aside class="toolbox-left sidebar-shop mobile-sidebar sidebar-shop-2">
		<div
			class="toolbox-item toolbox-sort select-custom"
			v-for="attr in attributes"
			:key="attr.id"
		>
			<a
				class="sort-menu-trigger"
				href="#"
				@click.prevent="setOpenAttribute"
				>{{ attr.name }}</a
			>
			<ul class="sort-list">
				<li
					v-for="term in attr.terms"
					:key="term.id"
					:class="{ active: setActiveTerm(term) }"
				>
					<router-link :to="setFilterRouteQuery(term)">{{
						attr.slug === "color" ? term.slug : term.name
					}}</router-link>
				</li>
			</ul>
		</div>

		<div class="toolbox-item toolbox-sort price-sort select-custom">
			<a
				class="sort-menu-trigger"
				href="#"
				@click.prevent="setOpenAttribute"
				>Price</a
			>
			<div class="sort-list" @click.stop>
				<form
					class="filter-price-form d-flex align-items-center m-0"
					@submit.prevent
				>
					<input
						class="input-price mr-2"
						name="min_price"
						placeholder="0"
						v-model="min_price"
					/>
					-
					<input
						class="input-price mx-2"
						name="max_price"
						placeholder="10000"
						v-model="max_price"
					/>
					<router-link
						:to="setPriceFilterRouteQuery()"
						class="btn btn-primary ml-3"
						>Filter</router-link
					>
				</form>
			</div>
		</div>
	</aside>
</template>

<script>
import { mapGetters } from "vuex";

export default {
	data: function () {
		return {
			attributes: [],
			min_price: 0,
			max_price: 9999,
		};
	},
	computed: {
		...mapGetters("setting", ["getSetting"])
	},
	watch: {
		$route: function () {
			if (this.$route.query.min_price && this.$route.query.max_price) {
				this.min_price = this.$route.query.min_price;
				this.max_price = this.$route.query.max_price;
			} else {
				this.min_price = parseInt(this.getSetting("filter_min_price"));
				this.max_price = parseInt(this.getSetting("filter_max_price"));
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
		setPriceFilterRouteQuery: function () {
			return {
				path: this.$route.fullPath,
				query: {
					...this.$route.query,
					min_price: this.min_price,
					max_price: this.max_price,
				},
			};
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
		setOpenAttribute: function (e) {
			document.querySelector("body").click();
			e.target.parentNode.classList.add("opened");
			e.stopPropagation();
		},
		removeActive: function () {
			var sorts = document.querySelectorAll(".toolbox-sort");
			for (var i = 0; i < sorts.length; i++) {
				sorts[i].classList.remove("opened");
			}
		},
	},
	created: function () {
		window.axios
			.get("/web/shop/sidebar")
			.then((response) => {
				this.attributes = response.data.attributes;
			})
			.catch((error) => {});
	},
	mounted: function () {
		document
			.querySelector("body")
			.addEventListener("click", this.removeActive);

		if (this.$route.query.min_price && this.$route.query.max_price) {
			this.min_price = this.$route.query.min_price;
			this.max_price = this.$route.query.max_price;
		} else {
			this.min_price = parseInt(this.getSetting("filter_min_price"));
			this.max_price = parseInt(this.getSetting("filter_max_price"));
		}
	},
	destroyed: function () {
		document
			.querySelector("body")
			.removeEventListener("click", this.removeActive);
	},
};
</script>