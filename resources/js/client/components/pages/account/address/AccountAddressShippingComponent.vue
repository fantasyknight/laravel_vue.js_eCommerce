<template>
	<div class="address account-content">
		<h4 class="title mb-3">Shipping Address</h4>

		<form class="mb-2" action="#" @submit.prevent="changeShippingAddress">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label
							>First Name <span class="required">*</span></label
						>
						<input
							type="text"
							class="form-control"
							v-model="firstName"
							required
						/>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Last Name <span class="required">*</span></label>
						<input
							type="text"
							class="form-control"
							v-model="lastName"
							required
						/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>Company </label>
				<input type="text" class="form-control" v-model="company" />
			</div>

			<div class="form-group">
				<label>Street Address <span class="required">*</span></label>
				<input
					type="text"
					class="form-control"
					v-model="streetAddress1"
					placeholder="House number and street name"
					required
				/>
				<input
					type="text"
					class="form-control"
					v-model="streetAddress2"
					placeholder="Apartment, suite, unite, etc. (optional)"
					requireds
				/>
			</div>

			<div class="form-group">
				<label>City <span class="required">*</span></label>
				<input
					type="text"
					class="form-control"
					v-model="city"
					required
				/>
			</div>

			<div class="form-group">
				<label>State/Province <span class="required">*</span></label>
				<Select2
					v-if="states.length"
					key="state-select2"
					id="state-select"
					v-model="state"
					:required="true"
					:options="states"
				>
				</Select2>
				<input
					v-else
					key="state-input"
					type="text"
					class="form-control"
					required
					v-model="state"
				/>
			</div>

			<div class="form-group">
				<label>Zip/Postal Code <span class="required">*</span></label>
				<input
					v-model="zip"
					type="text"
					class="form-control"
					required
				/>
			</div>

			<div class="form-group mb-3">
				<label>Country <span class="required">*</span></label>
				<Select2
					id="country-select"
					v-model="country"
					:required="true"
					:options="countries"
				>
				</Select2>
			</div>

			<div class="form-footer mb-0">
				<div class="form-footer-right">
					<button type="submit" class="btn btn-dark py-4">
						Save Address
					</button>
				</div>
			</div>
		</form>
	</div>
</template>
<script>
import { mapGetters, mapMutations } from "vuex";
import Select2 from "v-select2-component";
import { COUNTRIES, STATES } from "../../../../../data/constant";

export default {
	components: {
		Select2,
	},
	data() {
		return {
			firstName: "",
			lastName: "",
			company: "",
			streetAddress1: "",
			streetAddress2: "",
			city: "",
			state: "",
			country: "",
			zip: "",
			countries: COUNTRIES,
		};
	},
	computed: {
		...mapGetters("user", ["getUser"]),
		states: function () {
			return this.country && STATES[this.country]
				? STATES[this.country]
				: [];
		},
	},
	created: function () {
		this.firstName = this.getUser.shipping_first_name;
		this.lastName = this.getUser.shipping_last_name;
		this.company = this.getUser.shipping_company;
		this.streetAddress1 = this.getUser.shipping_address_1;
		this.streetAddress2 = this.getUser.shipping_address_2;
		this.city = this.getUser.shipping_city;
		this.state = this.getUser.shipping_state;
		this.country = this.getUser.shipping_country;
		this.zip = this.getUser.shipping_postcode;
	},
	methods: {
		...mapMutations("user", {
			setUser: "SET_USER",
		}),
		changeShippingAddress: async function () {
			await window.axios
				.put("/web/account-shipping-address", {
					id: this.getUser.id,
					shipping_first_name: this.firstName,
					shipping_last_name: this.lastName,
					shipping_company: this.company,
					shipping_address_1: this.streetAddress1,
					shipping_address_2: this.streetAddress2,
					shipping_city: this.city,
					shipping_state: this.state,
					shipping_country: this.country,
					shipping_postcode: this.zip,
				})
				.then((response) => {
					this.setUser({ user: response.data });
					this.$vToastify.success("Address changed successfully.");
					this.$router.push("./");
				})
				.catch((error) => {
					this.$vToastify.error(error.response.data.message);
				});
		},
	},
};
</script>