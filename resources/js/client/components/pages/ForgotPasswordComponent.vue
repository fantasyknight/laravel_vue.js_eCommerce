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
							<li
								class="breadcrumb-item active"
								aria-current="page"
							>
								My Account
							</li>
						</ol>
					</div>
				</nav>
				<h1>My Account</h1>
			</div>
		</div>

		<div class="container reset-password-container">
			<div class="row">
				<div class="col-lg-6 offset-lg-3">
					<div class="feature-box border-top-primary">
						<div class="feature-box-content">
							<form
								class="mb-0"
								action="#"
								@submit.prevent="resetPassword"
							>
								<p>
									Lost your password? Please enter your
									username or email address. You will receive
									a link to create a new password via email.
								</p>
								<div class="form-group mb-0">
									<label
										for="reset-email"
										class="font-weight-normal"
										>Email</label
									>
									<input
										type="email"
										class="form-control"
										id="reset-email"
										name="reset-email"
										v-model="resetEmail"
										required
									/>
								</div>

								<div class="form-footer mb-0">
									<router-link to="/pages/login"
										>Click here to login</router-link
									>
									<button
										type="submit"
										class="btn btn-md btn-primary form-footer-right font-weight-normal text-transform-none mr-0"
									>
										Reset Password
									</button>
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
export default {
	data() {
		return {
			resetEmail: ''
		}
	},
	methods: {
		resetPassword: async function () {
			await window.axios.post('/forgot-password', {
				email: this.resetEmail
			}).then( response => {
                this.$vToastify.stopLoader();
                this.$vToastify.setSettings( {
                    withBackdrop: false,
                    position: "top-right",
                    successDuration: 1000,
                } );
                this.$vToastify.success("Link send successfully");
			} ).catch( ( error ) => {
                this.$vToastify.stopLoader();
                this.$vToastify.setSettings( {
                    withBackdrop: false,
                    position: "top-right",
                    errorDuration: 1500,
                } );
                this.$vToastify.error("Link send failed");
            } );
		}
	}
}
</script>