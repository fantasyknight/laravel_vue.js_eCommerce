<template>
	<div>
		<div class="sidebar-overlay" @click="toggleSidebar"></div>
		<a class="sidebar-toggle" @click.prevent="toggleSidebar"
			><i class="fas fa-sliders-h"></i
		></a>
		<aside class="mobile-sidebar h-100" sticky-container>
			<div
				class="sidebar-wrapper"
				v-sticky="shouldSticky"
				sticky-offset="{ top: 69 }"
			>
				<div class="widget widget-product-categories">
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
									>{{ slotProps.model.name }}
								</router-link>
							</template>
							<template v-slot:treeNodeIcon>
								<span></span>
							</template>
						</vue-tree-list>
					</div>
				</div>

				<div class="widget">
					<div class="maga-sale-container">
						<figure class="mega-image">
							<img
								v-lazy="
									$root.getUrl(
										'client/images/banners/banner_sidebar_right.jpg'
									)
								"
								width="228"
								height="290"
								class="w-100"
								alt="Banner Desc"
							/>
						</figure>
						<div class="mega-content">
							<div class="mega-price-box">
								<span class="price-big">50</span>
								<span class="price-desc"><em>%</em>OFF</span>
							</div>
							<div class="mega-desc">
								<h3 class="mega-title mb-0">MEGA SALE</h3>
								<span class="mega-subtitle">MANY ITEM</span>
							</div>
						</div>
					</div>
				</div>

				<div class="widget widget-featured mb-5">
					<h3 class="widget-title">Featured Product</h3>

					<div class="widget-body">
						<product-two-component
							v-for="product in featuredProducts.slice(0, 3)"
							:key="product.id"
							:product="product"
						></product-two-component>
					</div>
				</div>
			</div>
		</aside>
	</div>
</template>
<script>
import Sticky from "vue-sticky-directive";
import { VueTreeList, Tree, TreeNode } from "vue-tree-list";

import ProductTwoComponent from "../../shared/products/ProductTwoComponent";

export default {
	components: {
		VueTreeList,

		ProductTwoComponent,
	},
	directives: {
		Sticky,
	},
	props: {
		categories: Array,
		featuredProducts: Array,
	},
	data() {
		return {
			shouldSticky: window.innerWidth >= 992,
		};
	},
	computed: {
		treeData: function () {
			return new Tree(this.categories);
		},
	},
	created: function () {
		window.addEventListener("resize", this.resizeHandler, {
			passive: true,
		});
	},
	beforeDestroy: function () {
		window.removeEventListener("resize", this.resizeHandler);
	},
	methods: {
		resizeHandler: function () {
			this.shouldSticky = window.innerWidth >= 992;
		},
		toggleSidebar: function () {
			document.querySelector("body").classList.toggle("sidebar-opened");
		},
	},
};
</script>