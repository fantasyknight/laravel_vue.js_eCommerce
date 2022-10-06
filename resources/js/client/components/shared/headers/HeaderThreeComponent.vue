<template>
	<div>
		<div class="top-notice text-white bg-primary" v-if="topNoticeShow">
			<div class="container text-center">
				<h5 class="d-inline-block mb-0">
					Get Up to <b>40% OFF</b> New-Season Styles
				</h5>
				<small>* Limited time only.</small>
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

		<header class="header header-three">
			<div class="header-top">
				<div class="container">
					<div class="header-left header-dropdowns">
						<div class="header-dropdown">
							<a href="#">
								<i
									class="flag-us flags"
									v-lazy:background-image="
										$root.getUrl(
											'client/images/flags/flags.png'
										)
									"
								></i>
								ENG
							</a>
							<div class="header-menu">
								<ul>
									<li>
										<a href="#">
											<i
												class="flag-us flags mr-2"
												v-lazy:background-image="
													$root.getUrl(
														'client/images/flags/flags.png'
													)
												"
											></i
											>ENG
										</a>
									</li>
									<li>
										<a href="#">
											<i
												class="flag-fr flags mr-2"
												v-lazy:background-image="
													$root.getUrl(
														'client/images/flags/flags.png'
													)
												"
											></i
											>FRA
										</a>
									</li>
								</ul>
							</div>
						</div>

						<div class="header-dropdown ml-4">
							<a href="#">USD</a>
							<div class="header-menu">
								<ul>
									<li>
										<a href="#">EUR</a>
									</li>
									<li>
										<a href="#">USD</a>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="header-right">
						<p
							class="top-message text-uppercase d-none d-sm-block mr-4"
						>
							FREE Returns. Standard Shipping Orders $99+
						</p>

						<span class="separator"></span>

						<div
							class="header-dropdown dropdown-expanded mx-2 px-1"
						>
							<a href="#">Links</a>
							<div class="header-menu">
								<ul>
									<li>
										<router-link to="/pages/about-us"
											>About</router-link
										>
									</li>
									<li>
										<router-link to="/shop/default"
											>Our Stores</router-link
										>
									</li>
									<li>
										<router-link to="/pages/blog"
											>Blog</router-link
										>
									</li>
									<li>
										<router-link to="/pages/contact-us"
											>Contact</router-link
										>
									</li>
									<li v-if="isCustomer">
										<router-link to="/pages/account"
											>Log out</router-link
										>
									</li>
								</ul>
							</div>
						</div>

						<span class="separator"></span>

						<div class="social-icons">
							<a
								href="#"
								class="social-icon social-instagram icon-instagram"
								target="_blank"
							></a>
							<a
								href="#"
								class="social-icon social-twitter icon-twitter"
								target="_blank"
							></a>
							<a
								href="#"
								class="social-icon social-facebook icon-facebook"
								target="_blank"
							></a>
						</div>
					</div>
				</div>
			</div>

			<sticky-header-component>
				<div class="header-middle sticky-header">
					<div class="container">
						<div class="header-left w-lg-max ml-auto ml-lg-0">
							<header-search-one-component
								:categories="categories"
								class="header-icon header-search-inline header-search-category"
								:class="getHeaderSettings.searchFormStyle"
								:show-category="getHeaderSettings.searchFormCategory"
							></header-search-one-component>
						</div>

						<div
							class="header-center order-first order-lg-0 ml-0 ml-lg-auto"
						>
							<button
								class="mobile-menu-toggler mr-4"
								:class="getHeaderSettings.mmenuTogglerStyle"
								type="button"
								@click="showMobileMenu"
							>
								<i class="icon-menu"></i>
							</button>
							<router-link to="/" class="logo">
								<img
									:src="
										$root.getUrl(
											getHeaderSettings.logoImage
										)
									"
									:alt="`${getHeaderSettings.siteTitle} Logo`"
									:width="getHeaderSettings.logoImageWidth"
									:height="getHeaderSettings.logoImageHeight"
								/>
							</router-link>
						</div>

						<div class="header-right w-lg-max ml-0 ml-lg-auto">
							<div
								class="header-contact d-none d-lg-flex align-items-center ml-auto pr-xl-4 mr-4"
							>
								<i class="icon-phone-2"></i>
								<h6 class="pt-1 line-height-1 pr-2">
									Call us now
									<a
										href="tel:#"
										class="d-block text-dark pt-1 font1"
										>+123 5678 890</a
									>
								</h6>
							</div>

							<a
								href="#"
								class="header-icon login-link pl-1"
								:class="getHeaderSettings.accountIconStyle"
								@click.prevent="showLoginModal"
								v-if="!isCustomer"
							>
								<i class="icon-user-2"></i>
							</a>
							<router-link
								to="/pages/account"
								class="header-icon login-link pl-1"
								:class="getHeaderSettings.accountIconStyle"
								v-else
							>
								<i class="icon-user-2"></i>
							</router-link>

							<router-link
								to="/pages/wishlist"
								class="header-icon pl-1 pr-2"
							>
								<i class="icon-wishlist-2"></i>
							</router-link>

							<transition name="fade" mode="out-in">
								<keep-alive>
									<component
										:is="cartMenuComponent"
									></component>
								</keep-alive>
							</transition>
						</div>
					</div>
				</div>
			</sticky-header-component>

			<sticky-header-component>
				<div class="header-bottom sticky-header d-none d-lg-block">
					<div class="container">
						<main-menu-component
							class="d-flex w-lg-max justify-content-center"
							:align-stretch="false"
						></main-menu-component>
					</div>
				</div>
			</sticky-header-component>
		</header>
	</div>
</template>

<script>
import { mapGetters } from "vuex";

import HeaderSearchOneComponent from "./shared/header-search/HeaderSearchOneComponent";
import MainMenuComponent from "./shared/main-menu/MainMenuComponent";
import StickyHeaderComponent from "./shared/StickyHeaderComponent";

import LoginModalComponent from "../modals/LoginModalComponent";

function loadComponent(name) {
    return () =>
        import(`./shared/cart-menu/${name}.vue`).then((m) => m.default || m);
}

export default {
	components: {
		HeaderSearchOneComponent,
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