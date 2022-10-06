<template>
	<div class="dropdown cart-dropdown">
		<a
			href="#"
			class="dropdown-toggle dropdown-arrow"
			role="button"
			data-toggle="dropdown"
			aria-haspopup="true"
			aria-expanded="false"
			data-display="static"
			:class="getHeaderSettings.cartIconStyle"
		>
			<i class="minicart-icon"></i>
			<span class="cart-count badge-circle">{{ qtyTotal }}</span>
		</a>

		<div class="dropdown-menu">
			<div class="dropdownmenu-wrapper px-0">
				<div class="dropdown-cart-header">
					<span>{{ qtyTotal }} Items</span>

					<router-link :to="'/pages/cart'" class="float-right">View Cart</router-link>
				</div>

				<div class="dropdown-cart-products">
					<div
						class="product"
						v-for="(product, index) in cartList"
						:key="index"
					>
						<div class="product-details">
							<h4 class="product-title">
								<router-link :to="getPageUrl(product)">{{ product.name }}</router-link>
							</h4>

							<span class="cart-product-info">
								<span class="cart-product-qty">{{
									product.qty
								}}</span>
								x
								<span
									v-html="
										formatPrice(product.min_max_price[0]) +
										priceSuffix
									"
								>
								</span>
							</span>
						</div>

						<figure class="product-image-container">
							<router-link
								:to="getPageUrl(product)"
								class="product-image"
							>
								<img
									v-lazy="
										$root.getUrl(
											product.media[0].copy_link,
											true,
											100
										)
									"
									:alt="
										product.media[0].alt_text
											? product.media[0].alt_text
											: 'product'
									"
									width="100"
									height="100"
									v-if="product.media.length > 0"
									:key="'product-image'"
								/>
								<img
									:src="
										$root.getUrl(
											'server/images/placeholder-img-300x300.png'
										)
									"
									alt="product"
									width="80"
									height="80"
									v-else
									:key="'placeholder'"
								/>
							</router-link>
							<a
								href="#"
								class="btn-remove icon-cancel"
								title="Remove Product"
								@click.prevent="
									removeFromCart({ product: product })
								"
							></a>
						</figure>
					</div>
				</div>
				<template v-if="cartList.length > 0">
					<div class="dropdown-cart-total">
						<span>Subtotal</span>

						<span
							class="cart-total-price float-right"
							v-html="formatPrice(priceTotal) + priceSuffix"
						></span>
					</div>

					<div class="dropdown-cart-action">
						<router-link
							to="/pages/checkout"
							class="btn btn-dark btn-block"
							>Checkout</router-link
						>
					</div>
				</template>
				<div class="empty-cart-products text-center" v-else>
					<h6 class="font-weight-light py-4 mb-0">
						No products in the cart
					</h6>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { REMOVE_FROM_CART } from "../../../../../store/modules/cart/mutation-types";

export default {
	computed: {
		...mapGetters("cart", ["cartList", "priceTotal", "qtyTotal"]),
		...mapGetters("setting", [
			"getHeaderSettings",
			"formatPrice",
			"priceSuffix",
		]),
	},
	methods: {
		...mapActions("cart", ["removeFromCart"]),
		getPageUrl: function (product) {
			if (product.id == product.parent_id) {
				return {
					path: "/product/default/" + product.slug,
				};
			} else {
				return {
					path: "/product/default/" + product.slug,
					query: {
						termId: product.excerpts.reduce((acc, cur) => {
							return [...acc, cur.termId];
						}, []),
					},
				};
			}
		},
	},
};
</script>