<template>
	<main class="main">
		<div
			class="page-header page-header-bg text-left"
			style="background: 70% / cover #d4e1ea;"
			v-lazy:background-image="
				$root.getUrl('client/images/page-header-bg.jpg')
			"
		>
			<div class="container">
				<h1 class="ls-0"><span>ABOUT US</span> OUR COMPANY</h1>
				<router-link to="contact-us" class="btn btn-dark btn-sm"
					>Contact</router-link
				>
			</div>
		</div>

		<nav aria-label="breadcrumb" class="breadcrumb-nav">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<router-link to="/">
							<i class="icon-home"></i>
						</router-link>
					</li>
					<li class="breadcrumb-item active" aria-current="page">
						About Us
					</li>
				</ol>
			</div>
		</nav>

		<div class="about-section">
			<div class="container">
				<h2 class="subtitle">OUR STORY</h2>
				<p>
					Lorem Ipsum is simply dummy text of the printing and
					typesetting industry. Lorem Ipsum has been the industry's
					standard dummy text ever since the 1500s, when an unknown
					printer took a galley of type and scrambled it to make a
					type specimen book. It has survived not only five centuries,
					but also the leap into electronic typesetting, remaining
					essentially unchanged.
				</p>
				<p>
					Lorem Ipsum is simply dummy text of the printing and
					typesetting industry. Lorem Ipsum has been the industry's
					standard dummy text ever since the 1500s, when an unknown
					printer took a galley of type and scrambled it to make a
					type specimen book.
				</p>

				<p class="lead mb-3">
					“ Many desktop publishing packages and web page editors now
					use Lorem Ipsum as their default model search for evolved
					over sometimes by accident, sometimes on purpose ”
				</p>
			</div>
		</div>

		<div class="features-section bg-gray">
			<div class="container">
				<h2 class="subtitle">WHY CHOOSE US</h2>
				<div class="row">
					<div class="col-lg-4">
						<div class="feature-box bg-white">
							<i class="icon-shipped"></i>

							<div class="feature-box-content">
								<h3>Free Shipping</h3>
								<p>
									Lorem Ipsum is simply dummy text of the
									printing and typesetting industry. Lorem
									Ipsum has been the industr in some form.
								</p>
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="feature-box bg-white">
							<i class="icon-us-dollar"></i>

							<div class="feature-box-content">
								<h3>100% Money Back Guarantee</h3>
								<p>
									There are many variations of passages of
									Lorem Ipsum available, but the majority have
									suffered alteration in some form.
								</p>
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="feature-box bg-white">
							<i class="icon-online-support"></i>

							<div class="feature-box-content">
								<h3>Online Support 24/7</h3>
								<p>
									There are many variations of passages of
									Lorem Ipsum available, but the majority have
									suffered alteration in some form.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="testimonials-section">
			<div class="container">
				<h2 class="subtitle text-center">HAPPY CLIENTS</h2>

				<owl-carousel-component
					:options="{
						items: 1,
						dots: false,
						nav: false,
						responsive: {
							'0': {
								items: 1,
							},
							'992': {
								items: 2,
							},
						},
					}"
				>
					<div class="testimonial">
						<div class="testimonial-owner">
							<figure>
								<img
									:src="
										$root.getUrl(
											'client/images/clients/client1.png'
										)
									"
									width="60"
									height="60"
									alt="client"
								/>
							</figure>

							<div>
								<h4 class="testimonial-title">john Smith</h4>
								<span>Proto Co Ceo</span>
							</div>
						</div>

						<blockquote>
							<p>
								Lorem ipsum dolor sit amet, consectetur elitad
								adipiscing Cras non placerat mipsum dolor sit
								amet, consectetur elitad adipiscing.
							</p>
						</blockquote>
					</div>

					<div class="testimonial">
						<div class="testimonial-owner">
							<figure>
								<img
									:src="
										$root.getUrl(
											'client/images/clients/client2.png'
										)
									"
									alt="client"
									width="60"
									height="60"
								/>
							</figure>

							<div>
								<h4 class="testimonial-title">Bob Smith</h4>
								<span>Proto Co Ceo</span>
							</div>
						</div>

						<blockquote>
							<p>
								Lorem ipsum dolor sit amet, consectetur elitad
								adipiscing Cras non placerat mipsum dolor sit
								amet, consectetur elitad adipiscing.
							</p>
						</blockquote>
					</div>

					<div class="testimonial">
						<div class="testimonial-owner">
							<figure>
								<img
									:src="
										$root.getUrl(
											'client/images/clients/client1.png'
										)
									"
									alt="client"
									width="60"
									height="60"
								/>
							</figure>

							<div>
								<h4 class="testimonial-title">john Smith</h4>
								<span>Proto Co Ceo</span>
							</div>
						</div>

						<blockquote>
							<p>
								Lorem ipsum dolor sit amet, consectetur elitad
								adipiscing Cras non placerat mipsum dolor sit
								amet, consectetur elitad adipiscing.
							</p>
						</blockquote>
					</div>
				</owl-carousel-component>
			</div>
		</div>

		<div class="counters-section bg-gray">
			<div class="container">
				<div class="row">
					<div class="col-6 col-md-4 count-container">
						<count-to-component
							:from="0"
							:to="200"
							:speed="2000"
							:interval="50"
							>+</count-to-component
						>
						<h4 class="count-title">MILLION CUSTOMERS</h4>
					</div>

					<div class="col-6 col-md-4 count-container">
						<count-to-component
							:from="0"
							:to="1800"
							:speed="2000"
							:interval="50"
							>+</count-to-component
						>
						<h4 class="count-title">TEAM MEMBERS</h4>
					</div>

					<div class="col-6 col-md-4 count-container">
						<count-to-component
							:from="0"
							:to="24"
							:speed="2000"
							:interval="50"
						>
							<span>HR</span>
						</count-to-component>
						<h4 class="count-title">SUPPORT AVAILABLE</h4>
					</div>

					<div class="col-6 col-md-4 count-container">
						<count-to-component
							:from="0"
							:to="265"
							:speed="2000"
							:interval="50"
							>+</count-to-component
						>
						<h4 class="count-title">SUPPORT AVAILABLE</h4>
					</div>

					<div class="col-6 col-md-4 count-container">
						<count-to-component
							:from="0"
							:to="99"
							:speed="2000"
							:interval="50"
						>
							<span>%</span>
						</count-to-component>
						<h4 class="count-title">SUPPORT AVAILABLE</h4>
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
<script>
import CountToComponent from "../shared/CountToComponent";
import OwlCarouselComponent from "../shared/OwlCarouselComponent";

export default {
	components: {
		CountToComponent,
		OwlCarouselComponent,
	}
};
</script>