<template v-once>
	<footer class="footer footer-three">
		<div class="footer-middle">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-4">
						<div class="widget">
							<h4 class="widget-title">Contact Info</h4>
							<ul class="contact-info mb-2">
								<li>
									<span class="contact-info-label"
										>Address:</span
									>1234 Street Name, City, England
								</li>
								<li>
									<span class="contact-info-label"
										>Phone:</span
									><a href="tel:">(123) 456-7890</a>
								</li>
								<li>
									<span class="contact-info-label"
										>Email:</span
									>
									<a href="mailto:mail@example.com"
										>mail@example.com</a
									>
								</li>
								<li>
									<span class="contact-info-label"
										>Working Days/Hours:</span
									>
									Mon - Sun / 9:00 AM - 8:00PM
								</li>
							</ul>
							<div class="social-icons">
								<a
									href="javascript:;"
									class="social-icon social-instagram icon-instagram"
									target="_blank"
									title="Instagram"
								></a>
								<a
									href="javascript:;"
									class="social-icon social-twitter icon-twitter"
									target="_blank"
									title="Twitter"
								></a>
								<a
									href="javascript:;"
									class="social-icon social-facebook icon-facebook"
									target="_blank"
									title="Facebook"
								></a>
							</div>
						</div>
					</div>

					<div class="col-lg-9 col-md-8">
						<div class="widget widget-newsletter">
							<h4 class="widget-title m-b-1 pb-2">
								Subscribe newsletter
							</h4>
							<div class="row">
								<div class="col-lg-6">
									<p class="pt-2 mb-lg-0">
										Get all the latest information on
										Events, Sales and Offers. Sign up for
										newsletter today.
									</p>
								</div>

								<div class="col-lg-6">
									<form action="#" class="d-flex mb-0 w-100">
										<input
											type="email"
											class="form-control mb-0"
											placeholder="Email address"
											required=""
										/>

										<input
											type="submit"
											class="btn btn-primary shadow-none"
											value="Subscribe"
										/>
									</form>
								</div>
							</div>
						</div>

						<div class="row pt-3">
							<div class="col-sm-6 col-lg-5">
								<div class="widget">
									<h4 class="widget-title">
										Customer Service
									</h4>

									<ul class="links link-parts row mb-0">
										<div class="link-part col-sm-6">
											<li>
												<router-link
													to="/pages/about-us"
													>About Us</router-link
												>
											</li>
											<li>
												<router-link
													to="/pages/contact-us"
													>Contact Us</router-link
												>
											</li>
											<li>
												<router-link to="/pages/account"
													>My Account</router-link
												>
											</li>
										</div>
										<div class="link-part col-sm-6">
											<li>
												<a href="javascript:;"
													>Orders History</a
												>
											</li>
											<li>
												<a href="javascript:;"
													>Advanced Search</a
												>
											</li>
											<li>
												<a
													href="javascript:;"
													class="login-link"
													>Login</a
												>
											</li>
										</div>
									</ul>
								</div>
							</div>

							<div class="col-sm-6 col-lg-7">
								<div class="widget">
									<h4 class="widget-title">About Us</h4>

									<ul class="links link-parts row mb-0">
										<div class="link-part col-xl-6">
											<li>
												<a href="javascript:;"
													>Super Fast WordPress
													Theme</a
												>
											</li>
											<li>
												<a href="javascript:;"
													>1st Fully working Ajax
													Theme</a
												>
											</li>
											<li>
												<a href="javascript:;"
													>33 Unique Shop Layouts</a
												>
											</li>
										</div>
										<div class="link-part col-xl-6">
											<li>
												<a href="javascript:;"
													>Powerful Admin Panel</a
												>
											</li>
											<li>
												<a href="javascript:;"
													>Mobile &amp; Retina
													Optimized</a
												>
											</li>
										</div>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div
				class="container d-flex justify-content-between align-items-center flex-wrap"
			>
				<p class="footer-copyright py-3 pr-4 mb-0">
					© Porto eCommerce. {{ year }}. All Rights Reserved
				</p>

				<img
					:src="$root.getUrl('client/images/payments.png')"
					alt="payment methods"
					width="240"
					height="32"
					class="footer-payments py-3"
				/>
			</div>
		</div>
	</footer>
</template>

<script>
export default {
	props: {
		tags: Array,
	},
	data: function (){
		return {
			year: new Date().getFullYear()
		}
	}
};
</script>