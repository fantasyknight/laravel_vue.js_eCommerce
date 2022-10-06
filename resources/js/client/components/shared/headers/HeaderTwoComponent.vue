<template>
	<div>
		<div class="top-notice text-white bg-dark" v-if="topNoticeShow">
			<div class="container text-center">
				<h5 class="ls-n-10 mb-0">
					Get 10% extra OFF on Porto Summer Sale - Use
					<b>PORTOSUMMER</b> coupon -
					<a href="category.html">Shop Now!</a>
				</h5>
				<button
					title="Close (Esc)"
					type="button"
					class="mfp-close"
					@click.prevent="topNoticeShow = !topNoticeShow"
				>
					×
				</button>
			</div>
		</div>

		<header
			class="header header-two"
			:class="{ 'header-transparent': isIndex }"
		>
			<sticky-header-component>
				<div class="header-middle sticky-header">
					<transition name="slide">
						<div class="container">
							<div class="header-left">
								<a href="index.html" class="logo">
									<img
										:src="
											$root.getUrl(
												getHeaderSettings.logoImage
											)
										"
										:alt="`${getHeaderSettings.siteTitle} Logo`"
										:width="
											getHeaderSettings.logoImageWidth
										"
										:height="
											getHeaderSettings.logoImageHeight
										"
									/>
								</a>

								<main-menu-component
									class="font2"
									:is-short="true"
									:align-stretch="false"
								></main-menu-component>
							</div>

							<div class="header-right">
								<button
									class="mobile-menu-toggler mr-4"
									:class="getHeaderSettings.mmenuTogglerStyle"
									type="button"
									@click="showMobileMenu"
								>
									<i class="icon-menu"></i>
								</button>

								<a
									href="#"
									class="header-icon login-link"
									:class="getHeaderSettings.accountIconStyle"
									@click.prevent="showLoginModal"
									v-if="!isCustomer"
								>
									<i class="icon-user-2"></i>
								</a>
								<router-link
									:to="'/pages/account'"
									class="header-icon login-link"
									:class="getHeaderSettings.accountIconStyle"
									v-else
								>
									<i class="icon-user-2"></i>
								</router-link>

								<router-link
									to="/pages/wishlist"
									class="header-icon"
								>
									<i class="icon-wishlist-2"></i>
								</router-link>

								<header-search-two-component
									:categories="categories"
									class="header-search-popup header-search-category d-none d-sm-block"
									:class="getHeaderSettings.searchFormStyle"
									:show-category="getHeaderSettings.searchFormCategory"
								></header-search-two-component>

								<transition name="fade" mode="out-in">
									<keep-alive>
										<component
											:is="cartMenuComponent"
										></component>
									</keep-alive>
								</transition>
							</div>
						</div>
					</transition>
				</div>
			</sticky-header-component>
		</header>
	</div>
</template>

<script>
import { mapGetters } from "vuex";

import HeaderSearchTwoComponent from "./shared/header-search/HeaderSearchTwoComponent";
import MainMenuComponent from "./shared/main-menu/MainMenuComponent";
import StickyHeaderComponent from "./shared/StickyHeaderComponent";

import LoginModalComponent from "../modals/LoginModalComponent";

function loadComponent(name) {
    return () =>
        import(`./shared/cart-menu/${name}.vue`).then((m) => m.default || m);
}

export default {
	components: {
		HeaderSearchTwoComponent,
		MainMenuComponent,
		StickyHeaderComponent,

		LoginModalComponent,
	},
	props: {
		categories: Array,
	},
	data: function () {
		return {
			topNoticeShow: true,
		};
	},
	computed: {
		...mapGetters("user", ["isCustomer"]),
		...mapGetters("setting", ["getHeaderSettings"]),
		cartMenuComponent: function () {
            return (
                this.getHeaderSettings.cartMenuType &&
                loadComponent(this.getHeaderSettings.cartMenuType)
            );
        },
		isIndex: function () {
			return this.$route.path === "/";
		},
	},
	methods: {
		showLoginModal: function () {
			this.$modal.show(
				LoginModalComponent,
				{},
				{
					width: "872",
					height: "auto",
					adaptive: true,
				}
			);
		},

		showMobileMenu: function () {
			document.querySelector("body").classList.add("mmenu-active");
		},
	},
};
</script>
<style lang="scss">
.slide-appear-active {
	transition: all 0.5s ease;
}

.slide-appear {
	transform: translateY(10px);
	opacity: 0;
	visibility: hidden;
}
</style>