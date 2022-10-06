<template>
	<div class="account-content">
		<form action="#" @submit.prevent="changeAccountDetails" class="mb-2">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="acc-name"
							>First name <span class="required">*</span></label
						>
						<input
							type="text"
							class="form-control"
							id="acc-name"
							name="acc-name"
							v-model="firstName"
							required
						/>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label for="acc-lastname"
							>Last name <span class="required">*</span></label
						>
						<input
							type="text"
							class="form-control"
							id="acc-lastname"
							name="acc-lastname"
							v-model="lastName"
							required
						/>
					</div>
				</div>
			</div>

			<div class="form-group mb-4">
				<label for="acc-email"
					>Email address <span class="required">*</span></label
				>
				<input
					type="email"
					class="form-control"
					id="acc-email"
					name="acc-email"
					v-model="email"
					required
				/>
			</div>

			<div class="change-password">
				<h3 class="text-uppercase mb-2">Password Change</h3>

				<div class="form-group">
					<label for="acc-password"
						>Current Password (leave blank to leave
						unchanged)</label
					>
					<input
						type="password"
						class="form-control"
						id="acc-password"
						name="acc-password"
						v-model="pwdCurrent"
					/>
				</div>

				<div class="form-group">
					<label for="acc-password"
						>New Password (leave blank to leave unchanged)</label
					>
					<input
						type="password"
						class="form-control"
						id="acc-new-password"
						name="acc-new-password"
						v-model="pwdNew"
					/>
				</div>

				<div class="form-group">
					<label for="acc-password">Confirm New Password</label>
					<input
						type="password"
						class="form-control"
						id="acc-confirm-password"
						name="acc-confirm-password"
						v-model="pwdConfirm"
					/>
				</div>
			</div>

			<div class="form-footer mt-3 mb-0">
				<button type="submit" class="btn btn-dark mr-0">
					Save changes
				</button>
			</div>
		</form>
	</div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
	data() {
		return {
			firstName: "",
			lastName: "",
			email: "",
			pwdCurrent: "",
			pwdNew: "",
			pwdConfirm: "",
		};
	},
	computed: {
		...mapGetters("user", ["getUser"]),
	},
	created: function () {
		this.firstName = this.getUser.first_name;
		this.lastName = this.getUser.last_name;
		this.email = this.getUser.email;
	},
	methods: {
		...mapActions("user", ["setUser"]),
		changeAccountDetails: function () {
			this.setUser({
				id: this.getUser.id,
				firstName: this.firstName,
				lastName: this.lastName,
				email: this.email,
				pwdCurrent: this.pwdCurrent,
				pwdNew: this.pwdNew,
				pwdConfirm: this.pwdConfirm,
			});
		},
	},
};
</script>