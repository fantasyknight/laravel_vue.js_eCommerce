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
							<li class="breadcrumb-item active" aria-current="page">My Account</li>
						</ol>
					</div>
				</nav>
				<h1>My Account</h1>
			</div>
		</div>

		<div class="container login-container">
			<div class="row">
				<div class="col-lg-10 mx-auto">
					<div class="row">
						<div class="col-lg-6">
							<div class="heading mb-1">
								<h2 class="title">Login</h2>
							</div>

							<form action="#" @submit.prevent="logIn">
								<label for="login-email">
									Email address
									<span class="required">*</span>
								</label>
								<input
									type="email"
									class="form-input form-wide"
									id="login-email"
									v-model="loginEmail"
									required
								/>

								<label for="login-password">
									Password(minLength: 5)
									<span class="required">*</span>
								</label>
								<input
									type="password"
									class="form-input form-wide"
									id="login-password"
									v-model="loginPassword"
									required
								/>

								<div class="form-footer">
									<div class="custom-control custom-checkbox my-0">
										<input type="checkbox" class="custom-control-input" id="lost-password" />
										<label class="custom-control-label mb-0" for="lost-password">Remember Me</label>
									</div>
									<router-link
										to="/pages/forgot-pwd"
										class="forget-password text-dark form-footer-right"
									>Forgot Password?</router-link>
								</div>
								<button type="submit" class="btn btn-dark btn-md w-100">LOGIN</button>
							</form>
						</div>
						<div class="col-lg-6">
							<div class="heading mb-1">
								<h2 class="title">Register</h2>
							</div>

							<form action="#" @submit.prevent="registerAccount">
								<label for="register-email">
									Email address
									<span class="required">*</span>
								</label>
								<input
									type="email"
									class="form-input form-wide"
									id="register-email"
									v-model="registerEmail"
									required
								/>

								<label for="register-password">
									Password(minLength: 5)
									<span class="required">*</span>
								</label>
								<input
									type="password"
									class="form-input form-wide"
									id="register-password"
									v-model="registerPassword"
									required
								/>
								<template v-if="getSetting('multivendor') == '1'">
									<vue-slide-toggle :open="registerRole == 'vendor'">
										<label>
											First Name
											<span class="required">*</span>
										</label>
										<input
											type="text"
											class="form-input form-wide"
											v-model="firstName"
											:disabled="registerRole != 'vendor'"
											required
										/>

										<label>
											Last Name
											<span class="required">*</span>
										</label>
										<input
											type="text"
											class="form-input form-wide"
											v-model="lastName"
											:disabled="registerRole != 'vendor'"
											required
										/>

										<label>
											Store Name
											<span class="required">*</span>
										</label>
										<input
											type="text"
											class="form-input form-wide"
											v-model="storeName"
											:disabled="registerRole != 'vendor'"
											required
										/>

										<label>
											Phone
											<span class="required">*</span>
										</label>
										<input
											type="text"
											class="form-input form-wide"
											v-model="phone"
											:disabled="registerRole != 'vendor'"
											required
										/>

										<div class="form-group">
											<label>
												Country
												<span class="required">*</span>
											</label>

											<Select2
												id="country"
												v-model="country"
												:options="countries"
												:disabled="registerRole != 'vendor'"
												requried
											></Select2>
										</div>

										<div class="form-group">
											<label>
												State
												<span class="required">*</span>
											</label>
											<input
												type="text"
												class="form-input form-wide"
												v-model="state"
												v-if="selectStates.length == 0"
												:disabled="registerRole != 'vendor'"
												required
											/>
											<Select2
												id="state"
												v-model="state"
												:options="selectStates"
												:disabled="registerRole != 'vendor'"
												required
												v-else
											></Select2>
										</div>

										<label>
											City
											<span class="required">*</span>
										</label>
										<input
											type="text"
											class="form-input form-wide"
											v-model="city"
											:disabled="registerRole != 'vendor'"
											required
										/>

										<label>
											Street
											<span class="required">*</span>
										</label>
										<input
											type="text"
											class="form-input form-wide"
											v-model="street"
											:disabled="registerRole != 'vendor'"
											required
										/>

										<label>
											Paypal Email
											<span class="required">*</span>
										</label>
										<input
											type="email"
											class="form-input form-wide"
											v-model="paypalEmail"
											:disabled="registerRole != 'vendor'"
											required
										/>
									</vue-slide-toggle>
									<div class="custom-control custom-radio mb-0 mt-0">
										<input
											type="radio"
											name="role"
											v-model="registerRole"
											class="custom-control-input"
											value="customer"
											id="customer"
										/>
										<label for="customer" class="custom-control-label">I am a customer</label>
									</div>

									<div class="custom-control custom-radio mb-0 mt-0">
										<input
											type="radio"
											name="role"
											v-model="registerRole"
											class="custom-control-input"
											value="vendor"
											id="vendor"
										/>
										<label for="vendor" class="custom-control-label">I am a vendor</label>
									</div>
								</template>

								<div class="form-footer mb-2">
									<button type="submit" class="btn btn-dark btn-md w-100 mr-0">Register</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import Select2 from "v-select2-component";
import { VueSlideToggle } from "vue-slide-toggle";
import { COUNTRIES, STATES } from "../../../data/constant";

export default {
	components: {
		Select2,
		VueSlideToggle,
	},
	data: function () {
		return {
			countries: COUNTRIES,
			states: STATES,
			loginEmail: "",
			loginPassword: "",
			registerEmail: "",
			registerPassword: "",
			registerRole: "customer",
			firstName: null,
			lastName: null,
			country: null,
			state: null,
			storeName: null,
			city: null,
			paypalEmail: null,
			street: null,
			phone: null,
		};
	},
	computed: {
		...mapGetters("setting", ["getSetting"]),
		selectStates: function () {
			return this.country && STATES[this.country]
				? STATES[this.country]
				: [];
		},
	},
	methods: {
		...mapActions("user", ["login", "register"]),
		logIn: async function () {
			const result = await this.login({
				email: this.loginEmail,
				password: this.loginPassword,
			});
			if (result) {
				this.$nextTick(() => {
					window.location.reload();
				});
			}
		},
		registerAccount: async function () {
			const result = await this.register({
				email: this.registerEmail,
				password: this.registerPassword,
				role: this.registerRole,
				firstName: this.firstName,
				lastName: this.lastName,
				country: this.country,
				state: this.state,
				storeName: this.storeName,
				city: this.city,
				paypalEmail: this.paypalEmail,
				street: this.street,
				phone: this.phone,
			});
			if (result) {
				this.$nextTick(() => {
					window.location.reload();
				});
			}
		},
	},
};
</script>