<template>
	<main class="main">
		<div class="container">
			<ul
				class="checkout-progress-bar d-flex justify-content-center flex-wrap"
			>
				<li>
					<router-link to="/pages/cart" exact-active-class="active"
						>Shopping Cart</router-link
					>
				</li>
				<li>
					<router-link
						to="/pages/checkout"
						exact-active-class="active"
						>Checkout</router-link
					>
				</li>
				<li>
					<a href="#" class="disabled">Order Complete</a>
				</li>
			</ul>
			<template v-if="cartList.length > 0">
				<error-boxes-component
					:errorMsg="errorMsg"
				></error-boxes-component>
				<div class="row">
					<div class="col-lg-8">
						<form
							class="cart-table-container"
							@submit.prevent="updateCartItems"
						>
							<table class="table table-cart">
								<thead>
									<tr>
										<th class="thumbnail-col"></th>
										<th class="product-col">Product</th>
										<th class="price-col">Price</th>
										<th class="qty-col">Quantity</th>
										<th class="text-right">Subtotal</th>
									</tr>
								</thead>
								<tbody>
									<tr
										v-for="(product, index) in cartItems"
										class="product-row"
										:key="index + '01'"
									>
										<td>
											<figure
												class="product-image-container"
											>
												<router-link
													:to="getPageUrl(product)"
													class="product-image"
												>
													<img
														v-lazy="
															$root.getUrl(
																product.media[0]
																	.copy_link,
																true,
																100
															)
														"
														:alt="
															product.media[0]
																.alt_text
																? product
																		.media[0]
																		.alt_text
																: 'product'
														"
														width="80"
														height="80"
														v-if="
															product.media
																.length > 0
														"
														:key="'product-image'"
													/>
													<img
														v-lazy="
															$root.getUrl(
																'server/images/placeholder-img-100x100.png'
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
														removeFromCart({
															product: product,
														})
													"
												></a>
											</figure>
										</td>
										<td class="product-col">
											<h5 class="product-title">
												<router-link
													:to="getPageUrl(product)"
													>{{
														product.name
													}}</router-link
												>
											</h5>
										</td>
										<td>
											<span
												v-html="
													formatPrice(
														product
															.min_max_price[0] +
															(showTax &&
																product.tax_amount /
																	product.qty)
													)
												"
											></span>
										</td>
										<td>
											<horizontal-quantity-input-component
												:product="product"
												@change-qty="changeQty"
											></horizontal-quantity-input-component>
										</td>
										<td class="text-right">
											<span
												class="subtotal-price"
												v-html="
													formatPrice(
														product.qty *
															product
																.min_max_price[0] +
															(showTax &&
																product.tax_amount)
													)
												"
											></span>
											<small
												v-if="
													showTax &&
													product.tax_amount
												"
												>(incl.VAT)</small
											>
										</td>
									</tr>
								</tbody>

								<tfoot>
									<tr>
										<td colspan="5" class="clearfix">
											<div class="float-left">
												<div
													class="cart-discount"
													v-if="
														getSetting(
															'enable_coupon'
														) !== '0'
													"
												>
													<form
														action="#"
														@submit.prevent="
															couponAdd(coupon)
														"
													>
														<div
															class="input-group"
														>
															<input
																type="text"
																v-model="coupon"
																class="form-control form-control-sm"
																placeholder="Coupon Code"
																required
															/>
															<div
																class="input-group-append"
															>
																<button
																	class="btn btn-shop"
																	type="submit"
																>
																	Apply Coupon
																</button>
															</div>
														</div>
													</form>
												</div>
											</div>

											<div class="float-right">
												<button
													class="btn btn-shop btn-update-cart"
													type="submit"
												>
													Update Cart
												</button>
											</div>
										</td>
									</tr>
								</tfoot>
							</table>
						</form>
					</div>

					<div class="col-lg-4">
						<div class="cart-summary" :class="{ loading: loading }">
							<h3 class="ls-n-10 text-uppercase">Cart Totals</h3>

							<table class="table table-totals">
								<tbody>
									<tr>
										<td>
											<h4>Subtotal</h4>
										</td>
										<td>
											<span
												v-html="
													formatPrice(
														priceTotal +
															(showTax
																? taxTotal
																: 0)
													)
												"
											></span>
											<small v-if="showTax && taxTotal"
												>(incl.VAT)</small
											>
										</td>
									</tr>
									<tr
										v-for="(coupon,
										index) in appliedCoupons"
										:key="'coupon-' + index"
									>
										<td>
											<h4>Coupon:</h4>
											{{ coupon.code }}
										</td>
										<td>
											<span
												v-html="
													formatPrice(
														-coupon.amount -
															(showTax &&
															coupon.tax
																? coupon.tax
																: 0)
													)
												"
											></span>
											<a
												href="javascript:;"
												@click="
													couponRemove(coupon.code)
												"
												>[Remove]</a
											>
										</td>
									</tr>
									<tr
										v-if="
											getSetting(
												'enable_shipping_calc_on_cartpage'
											) > 0 && shippingMethods !== null
										"
									>
										<td class="text-left" colspan="2">
											<template
												v-if="
													shippingMethods.length > 0
												"
											>
												<h4 class="mb-1">Shipping</h4>
												<div
													v-for="(availableShippingMethod,
													index) in shippingMethods"
													:key="
														'shipping-methods-' +
														index
													"
													class="form-group form-group-custom-control"
												>
													<div
														class="custom-control custom-radio"
													>
														<input
															v-model="
																shippingMethod
															"
															type="radio"
															class="custom-control-input"
															name="shipping-method"
															:id="
																'shipping-method-' +
																index
															"
															:value="index"
														/>
														<label
															:for="
																'shipping-method-' +
																index
															"
															class="custom-control-label text-body"
														>
															{{
																availableShippingMethod.name
															}}
															<span class="price">
																<span
																	v-html="
																		formatPrice(
																			availableShippingMethod.cost *
																				1.0 +
																				(showTax &&
																				availableShippingMethod.tax
																					? availableShippingMethod.tax *
																					  1.0
																					: 0)
																		)
																	"
																></span>
																<small
																	v-if="
																		showTax &&
																		availableShippingMethod.tax
																	"
																	>(incl.VAT)</small
																>
															</span>
														</label>
													</div>
												</div>
											</template>
											<form
												class="mb-2"
												action="#"
												@submit.prevent="
													getCalculatedItems()
												"
											>
												<p
													class="mb-1"
													v-html="
														shippingNotification
													"
												></p>
												<div
													class="form-group form-group-sm"
												>
													<Select2
														id="shipping-country-select"
														v-model="
															shipping.country
														"
														placeholder="Country"
														:options="countries"
													></Select2>
												</div>

												<div
													class="form-group form-group-sm"
												>
													<Select2
														v-if="
															shippingStates.length
														"
														key="shipping-state-select2"
														id="shipping-state-select"
														v-model="shipping.state"
														:options="
															shippingStates
														"
														placeholder="State"
													></Select2>
													<input
														v-else
														key="shipping-state-input"
														type="text"
														class="form-control"
														required
														v-model="shipping.state"
														placeholder="State"
													/>
												</div>

												<div
													class="form-group form-group-sm"
												>
													<input
														type="text"
														class="form-control"
														v-model="shipping.city"
														required
														placeholder="City"
													/>
												</div>

												<div
													class="form-group form-group-sm"
												>
													<input
														type="text"
														class="form-control"
														v-model="shipping.zip"
														required
														placeholder="Zip / Potcode"
													/>
												</div>

												<div class="form-footer my-0">
													<button
														type="submit"
														class="btn btn-shop"
														:class="{
															disabled: !shippingInfoAllEntered,
														}"
													>
														Update Totals
													</button>
												</div>
											</form>
										</td>
									</tr>
									<tr
										v-if="
											!showTax &&
											getSetting(
												'enable_shipping_calc_on_cartpage'
											) > 0
										"
									>
										<td>
											<h4>Tax</h4>
										</td>
										<td
											v-html="formatPrice(taxAmount)"
										></td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td>Total</td>
										<td>
											<b class="total-price">
												<span
													v-html="
														formatPrice(totalPrice)
													"
												></span>
												<small
													v-if="
														showTax && taxAmount > 0
													"
													v-html="
														'(incl ' +
														formatPrice(taxAmount) +
														' tax)'
													"
												></small>
											</b>
										</td>
									</tr>
								</tfoot>
							</table>

							<div class="checkout-methods">
								<router-link
									to="/pages/checkout"
									class="btn btn-block btn-dark"
								>
									Proceed to Checkout
									<i class="fa fa-arrow-right ml-3"></i>
								</router-link>
							</div>
						</div>
					</div>
				</div>
			</template>

			<div class="cart-empty-page text-center" v-else>
				<i class="cart-empty icon-bag-2 line-height-1"></i>
				<p class="px-3 py-2 cart-empty mt-1 mb-3">
					No products added to the cart
				</p>
				<p class="return-to-shop mb-0">
					<router-link to="/shop/default" class="btn btn-dark"
						>RETURN TO SHOP</router-link
					>
				</p>
			</div>
		</div>

		<div class="mb-6"></div>
	</main>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import Select2 from "v-select2-component";
import { VueSlideToggle } from "vue-slide-toggle";

import ErrorBoxesComponent from "../shared/ErrorBoxesComponent";
import HorizontalQuantityInputComponent from "../shared/quantity-input/HorizontalQuantityInputComponent";

import { COUNTRIES, STATES } from "../../../data/constant";

import {
	REMOVE_FROM_CART,
	CLEAR_CART,
	UPDATE_CART,
	UPDATE_SHIPPING_ADDRESS,
} from "../../store/modules/cart/mutation-types";
import { ADD_TO_WISHLIST } from "../../store/modules/wishlist/mutation-types";

export default {
	components: {
		Select2,
		VueSlideToggle,

		ErrorBoxesComponent,
		HorizontalQuantityInputComponent,
	},
	data: function () {
		return {
			cartItems: [],
			showTax: false,
			errorMsg: [],

			// Form data
			coupon: "",
			shipping: {
				country: "",
				state: "",
				zip: "",
				city: "",
			},
			calculatedZone: {
				country: "",
				state: "",
			},
			shippingMethods: [],
			shippingMethod: null,

			// Loading
			loading: false,
		};
	},
	computed: {
		...mapGetters("cart", [
			"cartList",
			"priceTotal",
			"taxTotal",
			"qtyTotal",
			"appliedCoupons",
			"appliedCartCoupons",
			"couponAmount",
			"couponTax",
			"shippingAddress",
		]),
		...mapGetters("setting", ["formatPrice", "getSetting"]),
		...mapGetters("user", ["getUser", "isCustomer"]),
		countries: function () {
			return COUNTRIES.filter((country) => {
				return window.shippableCountries.indexOf(country.id) > -1;
			});
		},
		shippingStates: function () {
			return this.shipping.country && STATES[this.shipping.country]
				? STATES[this.shipping.country]
				: [];
		},
		shippingInfoAllEntered: function () {
			return (
				this.shipping.city &&
				this.shipping.state &&
				this.shipping.zip &&
				this.shipping.country
			);
		},
		shippingNotification: function () {
			if (
				this.calculatedZone.country === "" ||
				this.calculatedZone.state === ""
			) {
				return "Enter your address to view shipping options.";
			}
			return `Shipping to <strong>${this.calculatedZone.state}, ${this.calculatedZone.country}</strong>.`;
		},
		taxAmount: function () {
			let sum = this.taxTotal - this.couponTax;
			if (this.shippingMethod !== null)
				sum += this.shippingMethods[this.shippingMethod].tax * 1.0;
			if (this.getSetting("tax_round_at_subtotal") !== '0') {
				sum = sum.toFixed(this.getSetting("number_of_decimal"));
			}
			return sum * 1.0;
		},
		totalPrice: function () {
			let total =
				this.priceTotal -
				this.couponAmount +
				(this.getSetting("enable_shipping_calc_on_cartpage") === "1"
					? this.taxAmount
					: 0);
			if (this.shippingMethod != null)
				total += this.shippingMethods[this.shippingMethod].cost * 1.0;
			if (this.getSetting("tax_round_at_subtotal") !== "0")
				total = total.toFixed(this.getSetting("number_of_decimal"));
			return total * 1.0;
		},
	},
	watch: {
		cartList: function () {
			this.cartItems = [...this.cartList];
		},
	},
	created: function () {
		if (this.isCustomer) {
			this.shipping = {
				country: this.getUser.shipping_country,
				state: this.getUser.shipping_state,
				zip: this.getUser.shipping_postcode,
				city: this.getUser.shipping_city,
			};
		} else if (this.getSetting("default_customer_location") === "base") {
			if (this.getSetting("store_country")) {
				let values = this.getSetting("store_country").split(":");
				this.shipping.country = values[1];
				if (values[0] === "state") this.shipping.state = values[2];
			}
			this.shipping.city = this.getSetting("store_city");
			this.shipping.zip = this.getSetting("store_postcode");
		}
		this.shipping = {
			country: this.shippingAddress.country
				? this.shippingAddress.country
				: this.shipping.country,
			state: this.shippingAddress.state
				? this.shippingAddress.state
				: this.shipping.state,
			zip: this.shippingAddress.zip
				? this.shippingAddress.zip
				: this.shipping.zip,
			city: this.shippingAddress.city
				? this.shippingAddress.city
				: this.shipping.city,
		};
		this.showTax =
			this.getSetting("tax_display_in_cart_checkout") === "include";
		this.getCalculatedItems();
	},
	methods: {
		...mapActions("cart", [
			"applyCoupon",
			"addCoupon",
			"removeCoupon",
			"removeFromCart",
			"calcCartItems",
		]),
		...mapMutations("cart", {
			updateCart: UPDATE_CART,
			updateShippingAddress: UPDATE_SHIPPING_ADDRESS,
		}),
		...mapMutations("wishlist", {
			addToWishlist: ADD_TO_WISHLIST,
		}),
		changeQty: function (id, qty, excerpts) {
			var findIndex = this.cartItems.findIndex((item) => item.id === id);
			if (findIndex !== -1 && excerpts !== null) {
				findIndex = this.cartItems.findIndex((item) => {
					return (
						item.id == id &&
						JSON.stringify(item.excerpts) ==
							JSON.stringify(excerpts)
					);
				});
			}
			if (findIndex !== -1) {
				this.cartItems = this.cartItems.reduce(
					(acc, product, index) => {
						if (findIndex == index) {
							acc.push({
								...product,
								qty: qty,
								sum: product.min_max_price[0] * qty,
							});
						} else {
							acc.push(product);
						}
						return acc;
					},
					[]
				);
			}
		},
		updateCartItems: function () {
			this.updateCart({ cartItems: this.cartItems });
			window.Vue.$vToastify.setSettings({
				withBackdrop: false,
				position: "top-right",
				successDuration: 1500,
			});
			window.Vue.$vToastify.success("Shopping cart updated");
		},
		couponAdd: async function () {
			this.loading = true;
			const results = await this.addCoupon(this.coupon);
			this.loading = false;

			if (results) {
				this.errorMsg = results.errorMsg;
				this.shippingMethods = results.shipping;
				this.coupon = "";
			}
		},
		couponRemove: async function (coupon) {
			this.loading = true;
			const results = await this.removeCoupon(coupon);
			this.loading = false;

			if (results) {
				this.shippingMethods = results.shipping;
			}
		},
		getCalculatedItems: async function (coupon = null) {
			this.updateShippingAddress({
				shippingInfo: this.shipping,
			});
			this.shippingMethod = null;
			this.loading = true;
			const results = await this.calcCartItems(coupon);
			this.loading = false;

			let country = COUNTRIES.find(
				(country) => country.id === this.shipping.country
			);
			if (country) {
				this.calculatedZone.country = country.text;
			}
			this.calculatedZone.state = this.shipping.state;
			this.errorMsg = results.errorMsg;
			this.shippingMethods = results.shipping;
		},
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