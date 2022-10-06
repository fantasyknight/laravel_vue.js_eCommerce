<template>
	<div class="addresses-content">
		<p class="mb-3">
			The following addresses will be used on the checkout page by
			default.
		</p>
		<div class="row">
			<div class="address col-md-6">
				<div class="heading d-flex mb-1">
					<h4 class="text-dark mb-0">Billing address</h4>
				</div>
				<div class="address-box mb-2">
					<address v-html="billingAddress"></address>
				</div>

				<router-link
					to="/pages/account/addresses/billing"
					class="btn btn-default address-action"
					>{{
						billingAddressExists ? "Edit Address" : "Add Address"
					}}</router-link
				>
			</div>
			<div class="address col-md-6">
				<div class="heading d-flex mb-1">
					<h4 class="text-dark mb-0">
						Shipping address
					</h4>
				</div>
				<div class="address-box mb-2">
					<address v-html="shippingAddress"></address>
				</div>
				<router-link
					to="/pages/account/addresses/shipping"
					class="btn btn-default address-action"
					>{{
						shippingAddressExists ? "Edit Address" : "Add Address"
					}}</router-link
				>
			</div>
		</div>
	</div>
</template>
<script>
import { mapGetters } from "vuex";
import { COUNTRIES } from "../../../../../data/constant";

export default {
	computed: {
		...mapGetters("user", [
			"getUser",
			"billingAddressExists",
			"shippingAddressExists",
		]),
		billingAddress: function () {
			if (!this.billingAddressExists) {
				return "You have not set up this type of address yet. <br />";
			}
			let html =
				this.getUser.billing_first_name +
				" " +
				this.getUser.billing_last_name +
				"<br />";
			if (this.getUser.billing_company) {
				html += this.getUser.billing_company + "<br />";
			}
			html += this.getUser.billing_address_1;
			if (this.getUser.billing_address_2) {
				html += ", " + this.getUser.billing_address_2;
			}
			html += "<br />";
			html +=
				this.getUser.billing_city +
				", " +
				this.getUser.billing_state +
				" " +
				this.getUser.billing_postcode +
				"<br />";
			html +=
				this.countryFullName(this.getUser.billing_country) + "<br />";
			html += "<p>" + this.getUser.billing_phone + "</p>";
			html += "<p>" + this.getUser.billing_email + "</p>";
			return html;
		},
		shippingAddress: function () {
			if (!this.shippingAddressExists) {
				return "You have not set this type of address yet. <br />";
			}
			let html =
				this.getUser.shipping_first_name +
				" " +
				this.getUser.shipping_last_name +
				"<br />";
			if (this.getUser.shipping_company) {
				html += this.getUser.shipping_company + "<br />";
			}
			html += this.getUser.shipping_address_1;
			if (this.getUser.shipping_address_2) {
				html += ", " + this.getUser.shipping_address_2;
			}
			html += "<br />";
			html +=
				this.getUser.shipping_city +
				", " +
				this.getUser.shipping_state +
				" " +
				this.getUser.shipping_postcode +
				"<br />";
			html +=
				this.countryFullName(this.getUser.shipping_country) + "<br />";
			return html;
		},
	},
	methods: {
		countryFullName: function (countryCode) {
			return COUNTRIES.filter((country) => country.id === countryCode)[0]
				.text;
		},
	},
};
</script>