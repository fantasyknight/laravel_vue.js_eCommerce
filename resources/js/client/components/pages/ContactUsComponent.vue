<template>
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<router-link to="/"
							><i class="icon-home"></i
						></router-link>
					</li>
					<li class="breadcrumb-item active" aria-current="page">
						Contact Us
					</li>
				</ol>
			</div>
		</nav>

		<div id="map"></div>

		<div class="container contact-us-container">
			<div class="contact-info">
				<div class="row">
					<div class="col-12">
						<h2 class="ls-n-25 m-b-1">
							Contact Info
						</h2>

						<p>
							Lorem ipsum dolor sit amet, consectetur adipiscing
							elit. Sed imperdiet libero id nisi euismod, sed
							porta est consectetur. Vestibulum auctor felis eget
							orci semper vestibulum. Pellentesque ultricies nibh
							gravida, accumsan libero luctus, molestie nunc.L
							orem ipsum dolor sit amet, consectetur adipiscing
							elit.
						</p>
					</div>

					<div class="col-md-6 col-lg-3">
						<div class="feature-box text-center">
							<i class="fa fa-map-marker-alt"></i>
							<div class="feature-box-content">
								<h3>Address</h3>
								<h5>123 Wall Street, New York / NY</h5>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-3">
						<div class="feature-box text-center">
							<i class="fa fa-mobile-alt"></i>
							<div class="feature-box-content">
								<h3>Phone Number</h3>
								<h5>(800) 123-4567</h5>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-3">
						<div class="feature-box text-center">
							<i class="far fa-envelope"></i>
							<div class="feature-box-content">
								<h3>E-mail Address</h3>
								<h5>porto@portotheme.com</h5>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-3">
						<div class="feature-box text-center">
							<i class="far fa-calendar-alt"></i>
							<div class="feature-box-content">
								<h3>Working Days/Hours</h3>
								<h5>Mon - Sun / 9:00AM - 8:00PM</h5>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<h2 class="mt-6 mb-2">Send Us a Message</h2>

					<form class="mb-0" action="#" method="post" @submit.prevent="submitContactForm">
						<div class="form-group">
							<label class="mb-1" for="contact-name"
								>Your Name
								<span class="required">*</span></label
							>
							<input
								type="text"
								class="form-control"
								id="contact-name"
								name="contact-name"
								v-model="contactName"
								required
							/>
						</div>

						<div class="form-group">
							<label class="mb-1" for="contact-email"
								>Your E-mail
								<span class="required">*</span></label
							>
							<input
								type="email"
								class="form-control"
								id="contact-email"
								name="contact-email"
								v-model="contactEmail"
								required
							/>
						</div>

						<div class="form-group">
							<label class="mb-1" for="contact-message"
								>Your Message
								<span class="required">*</span></label
							>
							<textarea
								cols="30"
								rows="1"
								id="contact-message"
								class="form-control"
								name="contact-message"
								v-model="contactMessage"
								required
							></textarea>
						</div>

						<div class="form-footer my-0">
							<button
								type="submit"
								class="btn btn-dark font-weight-normal"
							>
								Send Message
							</button>
						</div>
					</form>
				</div>

				<div class="col-lg-6">
					<h2 class="mt-6 mb-1">Frequently Asked Questions</h2>
					<div>
						<div class="card card-accordion">
							<div
								class="card-header"
								@click="faqToggle1 = !faqToggle1"
							>
								Curabitur eget leo at velit imperdiet viaculis
								vitaes?
							</div>
							<vue-slide-toggle
								class="card-body"
								:open="faqToggle1"
								:duration="400"
							>
								<p>
									Lorem ipsum dolor sit amet, consectetur
									adipiscing elit. Curabitur eget leo at velit
									imperdiet varius. In eu ipsum vitae velit
									congue iaculis vitae at risus. Nullam tortor
									nunc, bibendum vitae semper a, volutpat eget
									massa.
								</p>
							</vue-slide-toggle>
						</div>
						<div class="card card-accordion">
							<div
								class="card-header"
								@click="faqToggle2 = !faqToggle2"
							>
								Curabitur eget leo at velit imperdiet vague
								iaculis vitaes?
							</div>
							<vue-slide-toggle
								class="card-body"
								:open="faqToggle2"
								:duration="400"
							>
								<p>
									Lorem ipsum dolor sit amet, consectetur
									adipiscing elit. Curabitur eget leo at velit
									imperdiet varius. In eu ipsum vitae velit
									congue iaculis vitae at risus. Nullam tortor
									nunc, bibendum vitae semper a, volutpat eget
									massa. Lorem ipsum dolor sit amet,
									consectetur adipiscing elit. Integer
									fringilla, orci sit amet posuere auctor,
									orci eros pellentesque odio, nec
									pellentesque erat ligula nec massa. Aenean
									consequat lorem ut felis ullamcorper posuere
									gravida tellus faucibus. Maecenas dolor
									elit, pulvinar eu vehicula eu, consequat et
									lacus. Duis et purus ipsum. In auctor mattis
									ipsum id molestie. Donec risus nulla,
									fringilla a rhoncus vitae, semper a massa.
									Vivamus ullamcorper, enim sit amet consequat
									laoreet, tortor tortor dictum urna, ut
									egestas urna ipsum nec libero. Nulla justo
									leo, molestie vel tempor nec, egestas at
									massa. Aenean pulvinar, felis porttitor
									iaculis pulvinar, odio orci sodales odio, ac
									pulvinar felis quam sit.
								</p>
							</vue-slide-toggle>
						</div>
						<div class="card card-accordion">
							<div
								class="card-header"
								@click="faqToggle3 = !faqToggle3"
							>
								Curabitur eget leo at velit imperdiet viaculis
								vitaes?
							</div>
							<vue-slide-toggle
								class="card-body"
								:open="faqToggle3"
								:duration="400"
							>
								<p>
									Lorem ipsum dolor sit amet, consectetur
									adipiscing elit. Curabitur eget leo at velit
									imperdiet varius. In eu ipsum vitae velit
									congue iaculis vitae at risus. Nullam tortor
									nunc, bibendum vitae semper a, volutpat eget
									massa.
								</p>
							</vue-slide-toggle>
						</div>
						<div class="card card-accordion">
							<div
								class="card-header"
								@click="faqToggle4 = !faqToggle4"
							>
								Curabitur eget leo at velit imperdiet vague
								iaculis vitaes?
							</div>
							<vue-slide-toggle
								class="card-body"
								:open="faqToggle4"
								:duration="400"
							>
								<p>
									Lorem ipsum dolor sit amet, consectetur
									adipiscing elit. Curabitur eget leo at velit
									imperdiet varius. In eu ipsum vitae velit
									congue iaculis vitae at risus. Nullam tortor
									nunc, bibendum vitae semper a, volutpat eget
									massa. Lorem ipsum dolor sit amet,
									consectetur adipiscing elit. Integer
									fringilla, orci sit amet posuere auctor,
									orci eros pellentesque odio, nec
									pellentesque erat ligula nec massa. Aenean
									consequat lorem ut felis ullamcorper posuere
									gravida tellus faucibus. Maecenas dolor
									elit, pulvinar eu vehicula eu, consequat et
									lacus. Duis et purus ipsum. In auctor mattis
									ipsum id molestie. Donec risus nulla,
									fringilla a rhoncus vitae, semper a massa.
									Vivamus ullamcorper, enim sit amet consequat
									laoreet, tortor tortor dictum urna, ut
									egestas urna ipsum nec libero. Nulla justo
									leo, molestie vel tempor nec, egestas at
									massa. Aenean pulvinar, felis porttitor
									iaculis pulvinar, odio orci sodales odio, ac
									pulvinar felis quam sit.
								</p>
							</vue-slide-toggle>
						</div>
						<div class="card card-accordion">
							<div
								class="card-header"
								@click="faqToggle5 = !faqToggle5"
							>
								Curabitur eget leo at velit imperdiet vague
								iaculis vitaes?
							</div>
							<vue-slide-toggle
								class="card-body"
								:open="faqToggle5"
								:duration="400"
							>
								<p>
									Lorem ipsum dolor sit amet, consectetur
									adipiscing elit. Curabitur eget leo at velit
									imperdiet varius. In eu ipsum vitae velit
									congue iaculis vitae at risus. Nullam tortor
									nunc, bibendum vitae semper a, volutpat eget
									massa. Lorem ipsum dolor sit amet,
									consectetur adipiscing elit. Integer
									fringilla, orci sit amet posuere auctor,
									orci eros pellentesque odio, nec
									pellentesque erat ligula nec massa. Aenean
									consequat lorem ut felis ullamcorper posuere
									gravida tellus faucibus. Maecenas dolor
									elit, pulvinar eu vehicula eu, consequat et
									lacus. Duis et purus ipsum. In auctor mattis
									ipsum id molestie. Donec risus nulla,
									fringilla a rhoncus vitae, semper a massa.
									Vivamus ullamcorper, enim sit amet consequat
									laoreet, tortor tortor dictum urna, ut
									egestas urna ipsum nec libero. Nulla justo
									leo, molestie vel tempor nec, egestas at
									massa. Aenean pulvinar, felis porttitor
									iaculis pulvinar, odio orci sodales odio, ac
									pulvinar felis quam sit.
								</p>
							</vue-slide-toggle>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="mb-8"></div>
	</main>
</template>
<script>
import { VueSlideToggle } from "vue-slide-toggle";

export default {
    components: {
		VueSlideToggle
	},
	data() {
		return {
			faqToggle1: false,
			faqToggle2: false,
			faqToggle3: false,
			faqToggle4: false,
			faqToggle5: false,
			baseUrl: window.baseUrl,
			contactName: "",
			contactEmail: "",
			contactMessage: ""
		};
	},
	methods: {
		submitContactForm: function () {
			window.axios
                .post("/web/contact", {
                    contact_name: this.contactName,
					contact_email: this.contactEmail,
					contact_message: this.contactMessage
                })
                .then((response) => {
                    this.$vToastify.setSettings({
						withBackdrop: false,
						position: "top-right",
						successDuration: 1500,
					});
					this.$vToastify.success("Send Mail Successfully");
                })
                .catch((error) => {
                    this.$vToastify.error(error.response.data.message);
                });
		}
	}
}
</script>