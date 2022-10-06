<template>
	<div class="modal-wrapper login-popup">
		<div class="container">
			<h2 class="title">Login</h2>

			<form action="#" class="mb-0" @submit.prevent="logIn">
				<label for="login-email">
					Email address
					<span class="required">*</span>
				</label>
				<input
					type="email"
					class="form-input form-wide mb-2"
					id="login-email"
					v-model="loginEmail"
					required
				/>

				<label for="login-password">
					Password
					<span class="required">*</span>
				</label>
				<input
					type="password"
					class="form-input form-wide mb-2"
					id="login-password"
					v-model="loginPassword"
					required
				/>

				<div class="form-footer">
					<div class="custom-control custom-checkbox ml-0">
						<input
							type="checkbox"
							class="custom-control-input"
							id="lost-password"
						/>
						<label
							class="custom-control-label form-footer-right"
							for="lost-password"
							>Remember Me</label
						>
					</div>
					<div @click="$emit('close')" class="form-footer-right">
						<router-link
							to="/pages/forgot-pwd"
							class="forget-password text-dark"
							>Forgot password?</router-link
						>
					</div>
				</div>
				<div>
					<button type="submit" class="btn btn-dark btn-block btn-md">
						LOGIN
					</button>
				</div>
			</form>
		</div>

		<button
			title="Close (Esc)"
			type="button"
			class="mfp-close"
			@click="$emit('close')"
		>
			×
		</button>
	</div>
</template>
<script>
import { mapActions } from "vuex";

export default {
	data: function () {
		return {
			loginEmail: null,
			loginPassword: null,
		};
	},
	computed: {},
	methods: {
		...mapActions("user", ["login"]),
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
	},
};
</script>