<template>
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<router-link to="/">
							<i class="icon-home"></i>
						</router-link>
					</li>
					<li class="breadcrumb-item">Store</li>
					<li class="breadcrumb-item active">alexp</li>
				</ol>
			</div>
		</nav>

		<div class="container d-md-flex skeleton-body skel-shop-products">
			<aside class="sidebar-store">
				<div class="widget widget-product-categories mb-4">
					<h4 class="widget-title">Store Product Category</h4>
					<div class="widget-body">
						<vue-tree-list
							:model="treeData"
							:default-expanded="false"
						>
							<template v-slot:leafNameDisplay="slotProps">
								<router-link
									:to="{
										path: $route.path,
										query: {
											category: slotProps.model.slug,
										},
									}"
									:class="{
										active: setActiveCategory(
											slotProps.model
										),
									}"
									>{{ slotProps.model.name }}</router-link
								>
							</template>
							<template v-slot:treeNodeIcon>
								<span></span>
							</template>
						</vue-tree-list>
					</div>
				</div>
				<div class="widget widget-contact">
					<h4 class="widget-title">Contact Vendor</h4>
					<form class="mb-0" action="#" method="get">
						<div class="form-group">
							<input
								type="text"
								class="form-control"
								placeholder="Your Name"
								name="contact-name"
								required
							/>
						</div>
						<div class="form-group">
							<input
								type="email"
								class="form-control"
								placeholder="you@example.com"
								name="contact-email"
								required
							/>
						</div>
						<div class="form-group">
							<textarea
								class="form-control"
								rows="6"
								name="contact-message"
								placeholder="Type your message..."
							></textarea>
						</div>
						<div class="form-footer my-0">
							<div class="form-footer-right">
								<button type="submit" class="btn btn-primary">
									Send Message
								</button>
							</div>
						</div>
					</form>
				</div>
			</aside>
			<div class="store-single">
				<component
					:is="storeHeaderComponent"
					v-bind="{ user: user }"
				></component>
				<div class="store-single-tabs mb-2">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a
								class="nav-link active"
								data-toggle="tab"
								href="#products-content"
								role="tab"
								>Products</a
							>
						</li>
					</ul>
				</div>
				<div class="store-tab-content tab-content">
					<div
						class="tab-pane fade show active"
						id="products-content"
						role="tabpanel"
					>
						<template v-if="products.length > 0">
							<div class="row">
								<div
									class="col-sm-6 col-lg-4 col-6"
									v-for="(product, index) in products"
									:key="index"
								>
									<div
										class="skel-pro skel-pro-grid skel-padding-161"
									></div>
									<product-one-component
										:product="product"
									></product-one-component>
								</div>
							</div>

							<nav class="toolbox toolbox-pagination w-100">
								<div class="toolbox-item toolbox-show"></div>
								<pagination-component
									:per-page="9"
									:total="totalCount"
								></pagination-component>
							</nav>
						</template>
						<div
							class="info-box with-icon py-3 px-1 skel-hide"
							v-else
						>
							<p class="porto-info">
								No product matching your selection.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mb-6"></div>
	</main>
</template>
<script>
import { mapGetters } from "vuex";
import { VueTreeList, Tree } from "vue-tree-list";
import ProductOneComponent from "../shared/products/ProductOneComponent";

import PaginationComponent from "../shared/PaginationComponent";

function loadStoreHeader(name) {
	return () =>
		import(`../shared/stores/${name}.vue`).then((m) => m.default || m);
}

export default {
	components: {
		VueTreeList,
		ProductOneComponent,
		PaginationComponent,
	},
	data: function () {
		return {
			products: [],
			user: {},
			totalCount: 0,
			categories: [],
		};
	},
	computed: {
		...mapGetters("setting", ["getSetting"]),
		storeHeaderComponent: function () {
			return (
				this.getSetting("vendor_header_type") &&
				loadStoreHeader(this.getSetting("vendor_header_type"))
			);
		},
		treeData: function () {
			return new Tree(this.categories);
		},
	},
	watch: {
		$route: function () {
			this.getVendorData();
		},
	},
	created: function () {
		this.getVendorData();
	},
	methods: {
		getVendorData: function () {
			if (document.querySelector(".skeleton-body"))
				document
					.querySelector(".skeleton-body")
					.classList.remove("loaded");
			window.axios
				.get("/web/vendors/" + this.$route.params.id, {
					params: {
						...this.$route.query,
					},
				})
				.then((response) => {
					this.user = response.data.vendor;
					this.products = response.data.products.data;
					this.totalCount = response.data.totalCount;
					this.categories = response.data.categories;

					if (document.querySelector(".skeleton-body"))
						document
							.querySelector(".skeleton-body")
							.classList.add("loaded");
				})
				.catch((error) => {
					this.$router.push("/pages/404");
				});
		},
		setActiveCategory: function (category) {
			if (
				this.$route.query.category &&
				this.$route.query.category == category.slug
			)
				return true;
			else return false;
		},
	},
};
</script>