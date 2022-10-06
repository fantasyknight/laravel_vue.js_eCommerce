<template>
	<footer class="footer footer-one bg-dark">
		<div class="footer-middle">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-sm-6">
						<div class="widget mb-0">
							<h4 class="widget-title">Contact Info</h4>
							<ul class="contact-info">
								<li>
									<span class="contact-info-label"
										>Address:</span
									>123 Street Name, City, England
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
									Mon - Sun / 9:00 AM - 8:00 PM
								</li>
							</ul>
							<div class="social-icons">
								<a
									href="javascript:;"
									class="social-icon social-facebook icon-facebook"
									target="_blank"
									title="Facebook"
								></a>
								<a
									href="javascript:;"
									class="social-icon social-twitter icon-twitter"
									target="_blank"
									title="Twitter"
								></a>
								<a
									href="javascript:;"
									class="social-icon social-instagram icon-instagram"
									target="_blank"
									title="Instagram"
								></a>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-sm-6">
						<div class="widget">
							<h4 class="widget-title">Customer Service</h4>

							<ul class="links">
								<li>
									<a
										href="/laravel/laravel-porto/docs/index.html"
										>Help & FAQs</a
									>
								</li>
								<li>
									<a href="javascript:;">Order Tracking</a>
								</li>
								<li>
									<a href="javascript:;"
										>Shipping & Delivery</a
									>
								</li>
								<li>
									<router-link to="/pages/account/orders"
										>Orders History</router-link
									>
								</li>
								<li>
									<a href="javascript:;">Advanced Search</a>
								</li>
								<li>
									<router-link to="/pages/account"
										>My Account</router-link
									>
								</li>
								<li>
									<a href="javascript:;">Careers</a>
								</li>
								<li>
									<router-link to="/pages/about-us"
										>About Us</router-link
									>
								</li>
								<li>
									<a href="javascript:;">Corporate Sales</a>
								</li>
								<li>
									<a href="javascript:;">Privacy</a>
								</li>
							</ul>
						</div>
					</div>

					<div class="col-lg-3 col-sm-6">
						<div class="widget">
							<h4 class="widget-title">Popular Tags</h4>

							<div class="tagcloud">
								<router-link
									:to="{
										path: '/shop/default',
										query: { tag: tag.slug },
									}"
									v-for="tag in tags"
									:key="tag.id"
									>{{ tag.name }}</router-link
								>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-sm-6">
						<div class="widget widget-newsletter">
							<h4 class="widget-title">Subscribe newsletter</h4>
							<p>
								Get all the latest information on events, sales
								and offers. Sign up for newsletter:
							</p>
							<form action="#" class="mb-0">
								<input
									type="email"
									class="form-control m-b-3"
									placeholder="Email address"
									required
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
			</div>
		</div>

		<div class="container">
			<div
				class="footer-bottom d-flex justify-content-between align-items-center flex-wrap"
			>
				<p class="footer-copyright pr-4 mb-0">
					&copy; Porto eCommerce. {{ year }}. All
					Rights Reserved
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