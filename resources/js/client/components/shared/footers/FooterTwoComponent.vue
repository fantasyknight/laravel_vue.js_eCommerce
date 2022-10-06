<template v-once>
	<footer class="footer footer-two">
		<div class="footer-top">
			<div
				class="container top-border d-flex align-items-center justify-content-between flex-wrap"
			>
				<div
					class="footer-left widget-newsletter d-md-flex align-items-center"
				>
					<div class="widget-newsletter-info">
						<h5
							class="widget-newsletter-title text-uppercase m-b-1"
						>
							subscribe newsletter
						</h5>
						<p class="widget-newsletter-content mb-0">
							Get all the latest information on Events, Sales and
							Offers.
						</p>
					</div>
					<form action="#">
						<div class="footer-submit-wrapper d-flex">
							<input
								type="email"
								class="form-control"
								placeholder="Email address..."
								size="40"
								required
							/>
							<button type="submit" class="btn btn-dark btn-sm">
								Subscribe
							</button>
						</div>
					</form>
				</div>
				<div class="footer-right">
					<div class="social-icons">
						<a
							href="javascript:;"
							class="social-icon social-facebook icon-facebook"
							target="_blank"
						></a>
						<a
							href="javascript:;"
							class="social-icon social-twitter icon-twitter"
							target="_blank"
						></a>
						<a
							href="javascript:;"
							class="social-icon social-instagram icon-instagram"
							target="_blank"
						></a>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-middle">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-xl-4">
						<div class="widget">
							<h4 class="widget-title">Contact Info</h4>

							<div class="row">
								<div class="col-sm-6">
									<div class="contact-widget">
										<h4 class="widget-title">ADDRESS</h4>
										<a href="javascript:;"
											>1234 Street Name, City, England</a
										>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="contact-widget email">
										<h4 class="widget-title">EMAIL</h4>
										<a href="mailto:mail@example.com"
											>mail@example.com</a
										>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="contact-widget">
										<h4 class="widget-title">PHONE</h4>
										<a href="tel:+(123) 456-7890"
											>Toll Free (123) 456-7890</a
										>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="contact-widget">
										<h4 class="widget-title">
											WORKING DAYS/HOURS
										</h4>
										<a href="javascript:;"
											>Mon - Sun / 9:00 AM - 8:00 PM</a
										>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3 col-xl-4">
						<div class="widget">
							<h4 class="widget-title">My Account</h4>
							<ul class="links link-parts row">
								<div class="link-part col-xl-4">
									<li>
										<router-link to="/pages/about-us"
											>About Us</router-link
										>
									</li>
									<li>
										<router-link to="/pages/contact-us"
											>Contact Us</router-link
										>
									</li>
									<li>
										<router-link to="/pages/account"
											>My Account</router-link
										>
									</li>
								</div>
								<div class="link-part col-xl-8">
									<li>
										<router-link to="/pages/account/orders"
											>Orders History</router-link
										>
									</li>
									<li>
										<a href="javascript:;"
											>Advanced Search</a
										>
									</li>
								</div>
							</ul>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3 col-xl-4">
						<div class="widget">
							<h4 class="widget-title">Main Features</h4>
							<ul class="links link-parts row">
								<div class="link-part col-xl-6">
									<li>
										<a href="javascript:;"
											>Super Fast WordPress Theme</a
										>
									</li>
									<li>
										<a href="javascript:;"
											>1st Fully working Ajax Theme</a
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
											>Mobile &amp; Retina Optimized</a
										>
									</li>
								</div>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div
				class="container top-border d-flex align-items-center justify-content-between flex-wrap"
			>
				<p class="footer-copyright mb-0 py-3 pr-3">
					Porto eCommerce. &copy; {{ year }}. All Rights Reserved
				</p>
				<img
					class="py-3"
					:src="$root.getUrl('client/images/payments.png')"
					alt="payment image"
					width="240"
					height="32"
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