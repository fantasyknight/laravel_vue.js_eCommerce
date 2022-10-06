<template>
	<div class="dashboard-content">
		<p v-if="userName" key="has-name">
			Hello <strong class="text-dark">{{ userName }}</strong> (not
			<strong class="text-dark">{{ userName }}</strong
			>?
			<a href="javascript:;" class="btn btn-link" @click="logOut"
				>Log out</a
			>)
		</p>
		<p v-else key="unnamed">
			You haven't set your name yet.
		</p>
		<p>
			From your account dashboard you can view your
			<router-link class="btn btn-link" to="/pages/account/orders"
				>recent orders</router-link
			>, manage your
			<router-link class="btn btn-link" to="/pages/account/addresses/"
				>shipping and billing addresses</router-link
			>, and
			<router-link class="btn btn-link" to="/pages/account/details"
				>edit your password and account details.</router-link
			>
		</p>

		<!-- <div class="row">
			<div class="col-sm-6 col-md-4">
				<div class="feature-box text-center">
					<div class="feature-box-content">
						<i class="fab fa-dropbox"></i>
						<h3>Orders</h3>
					</div>
				</div>
			</div>
		</div> -->
	</div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
	computed: {
		...mapGetters("user", ["getUser", "userName"]),
	},
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