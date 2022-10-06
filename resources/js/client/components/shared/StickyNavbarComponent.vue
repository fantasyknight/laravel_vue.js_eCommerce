<template>
	<div class="sticky-navbar">
		<div class="sticky-icon">
			<router-link to="/"><i class="icon-home"></i>Home</router-link>
		</div>
		<div class="sticky-icon">
			<router-link to="/shop/default"
				><i class="icon-bars"></i>Categories</router-link
			>
		</div>
		<div class="sticky-icon">
			<router-link to="/pages/wishlist"
				><i class="icon-wishlist-2"></i>Wishlist</router-link
			>
		</div>
		<div class="sticky-icon">
			<router-link to="/pages/account"
				><i class="icon-user-2"></i>Account</router-link
			>
		</div>
		<div class="sticky-icon">
			<router-link to="/pages/cart"
				><i class="icon-shopping-cart position-relative">
					<span class="cart-count badge-circle">{{
						qtyTotal
					}}</span></i
				>Cart</router-link
			>
		</div>
	</div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
	computed: {
		...mapGetters("cart", ["qtyTotal"]),
	},
};
</script>