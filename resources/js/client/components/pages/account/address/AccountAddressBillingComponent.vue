<template>
	<div class="address account-content">
		<h4 class="title mb-3">Billing Address</h4>

		<form class="mb-2" action="#" @submit.prevent="changeBillingAddress">
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

			<div class="form-group">
				<label>Country <span class="required">*</span></label>
				<Select2
					id="country-select"
					v-model="country"
					:options="countries"
					:required="true"
				>
				</Select2>
			</div>

			<div class="form-group">
				<label>Phone Number <span class="required">*</span></label>
				<input
					type="tel"
					class="form-control"
					v-model="phone"
					required
				/>
			</div>

			<div class="form-group mb-3">
				<label>Email address <span class="required">*</span></label>
				<input
					type="email"
					class="form-control"
					v-model="email"
					required
				/>
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
			phone: "",
			email: "",
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
		this.firstName = this.getUser.billing_first_name
			? this.getUser.billing_first_name
			: this.getUser.first_name;
		this.lastName = this.getUser.billing_last_name
			? this.getUser.billing_last_name
			: this.getUser.last_name;
		this.company = this.getUser.billing_company;
		this.streetAddress1 = this.getUser.billing_address_1;
		this.streetAddress2 = this.getUser.billing_address_2;
		this.city = this.getUser.billing_city;
		this.state = this.getUser.billing_state;
		this.country = this.getUser.billing_country;
		this.zip = this.getUser.billing_postcode;
		this.phone = this.getUser.billing_phone;
		this.email = this.getUser.billing_email
			? this.getUser.billing_email
			: this.getUser.email;
	},
	methods: {
		...mapMutations("user", {
			setUser: "SET_USER",
		}),
		changeBillingAddress: async function () {
			await window.axios
				.put("/web/account-billing-address", {
					id: this.getUser.id,
					billing_first_name: this.firstName,
					billing_last_name: this.lastName,
					billing_company: this.company,
					billing_address_1: this.streetAddress1,
					billing_address_2: this.streetAddress2,
					billing_city: this.city,
					billing_state: this.state,
					billing_country: this.country,
					billing_postcode: this.zip,
					billing_phone: this.phone,
					billing_email: this.email,
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