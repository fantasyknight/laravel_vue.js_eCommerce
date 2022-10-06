<template>
	<main class="main">
		<div class="page-header">
			<div class="container d-flex flex-column align-items-center">
				<nav aria-label="breadcrumb" class="breadcrumb-nav">
					<div class="container">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<router-link to="/">Home</router-link>
							</li>
							<li class="breadcrumb-item">
								<router-link to="/">Shop</router-link>
							</li>
							<li
								class="breadcrumb-item active"
								aria-current="page"
							>
								My Account
							</li>
						</ol>
					</div>
				</nav>
				<h1>My Account</h1>
			</div>
		</div>

		<div class="container account-container">
			<div class="row">
				<aside class="col-lg-3 mb-2 mb-lg-0">
					<div class="widget widget-dashboard">
						<h2 class="text-uppercase">My Account</h2>
						<ul class="list mb-0">
							<li>
								<router-link
									to="/pages/account"
									exact-active-class="active"
									>Dashboard</router-link
								>
							</li>
							<li>
								<router-link
									to="/pages/account/orders"
									active-class="active"
									>Orders</router-link
								>
							</li>
							<li>
								<router-link
									to="/pages/account/downloads"
									exact-active-class="active"
									>Downloads</router-link
								>
							</li>
							<li>
								<router-link
									to="/pages/account/addresses"
									active-class="active"
									>Addresses</router-link
								>
							</li>
							<li>
								<router-link
									to="/pages/account/details"
									exact-active-class="active"
									>Account details</router-link
								>
							</li>
							<li>
								<router-link
									to="/pages/wishlist"
									exact-active-class="active"
									>Wishlist</router-link
								>
							</li>
							<li>
								<a href="javascript:;" @click="logOut"
									>Logout</a
								>
							</li>
						</ul>
					</div>
				</aside>

				<div class="col-lg-9">
					<router-view></router-view>
				</div>
			</div>
		</div>
	</main>
</template>
<script>
import { mapMutations, mapActions } from "vuex";

export default {
	methods: {
		...mapActions("user", ["logout"]),

		logOut: async function () {
			const result = await this.logout();
			if (result) {
				this.$nextTick(() => {
					window.location.reload();
				});
			}
		},
	},
};
</script>