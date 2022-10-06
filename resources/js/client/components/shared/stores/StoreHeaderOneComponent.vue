<template>
	<div class="store-header">
		<div class="store-details" v-if="user.vendor">
			<div class="seller-avatar">
				<img
					v-lazy="
						$root.getUrl(
							user.vendor.profile.copy_link, true, 100
						)
					"
					v-if="user.vendor.profile"
					alt="vendor"
					width="100"
					height="100"
				/>
				<img
					v-lazy="
						$root.getUrl(
							'server/images/placeholder-img-100x100.png'
						)
					"
					v-else
					alt="vendor"
					width="100"
					height="100"
				/>
			</div>

			<div class="store-data">
				<h1 class="store-title">{{ user.vendor.store_name }}</h1>
				<ul class="store-info-list">
					<li>
						<i class="fa fa-map-marker"></i>
						<span class="store-address">{{ getLocation(user.vendor.country, user.vendor.state) }}</span>
					</li>
					<li>
						<i class="fa fa-star"></i>
						{{ user.rating }} rating from {{ user.approved_reviews_count }} review
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>
<script>
import { COUNTIRES, STATES, COUNTRIES } from "../../../../data/constant";

export default {
	props: {
		user: Object,
	},
	methods: {
		getLocation: function (country, state) {
			let tempCountry = COUNTRIES.find((item) => item.id == country);

			let tempState = { text: "Unknown" };
			if (!tempCountry) {
				tempCountry = { text: "Unknown" };
			} else {
				tempState = STATES[country].find((item) => item.id == state);

				if (!tempState) {
					tempState = { text: "Unknown" };
				}
			}

			return tempState.text + ", " + tempCountry.text;
		},
	},
};
</script>