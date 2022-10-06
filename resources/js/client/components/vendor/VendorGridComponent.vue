<template>
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<router-link to="/">
							<i class="icon-home"></i>
						</router-link>
					</li>
					<li class="breadcrumb-item active">Store List</li>
				</ol>
			</div>
		</nav>

		<div class="container">
			<div class="toolbox toolbox-store">
				<div class="toolbox-left">
					<div class="toolbox-item">
						<label>Total store showing: {{ vendorCount }}</label>
					</div>
				</div>
				<div class="toolbox-item toolbox-filter mr-0">
					<a
						href="#"
						class="btn btn-primary"
						@click.prevent="filterSlide = !filterSlide"
						>Filter</a
					>
				</div>
				<div class="toolbox-item toolbox-sort">
					<label>Sort by:</label>
					<div class="select-custom">
						<select
							class="form-control"
							v-model="sortOption"
							@change="sortVendors"
						>
							<option value="recent">Most Recent</option>
							<option value="rating">Most Popular</option>
						</select>
					</div>
				</div>
				<div class="layout-modes">
					<router-link
						to="/vendors/grid"
						class="layout-btn btn-grid"
                        exact-active-class="active"
						title="Grid"
					>
						<i class="fas fa-th-large"></i>
					</router-link>
					<router-link
						to="/vendors/list"
						class="layout-btn btn-list"
                        exact-active-class="active"
						title="List"
					>
						<i class="fas fa-bars"></i>
					</router-link>
				</div>
			</div>

			<vue-slide-toggle
				:open="filterSlide"
				:duration="500"
				class="filter-form-container mt-0 mb-0 pb-0 pt-0"
			>
				<form
					class="mb-2 pt-5 pb-4"
					action="#"
					method="GET"
					@submit.prevent="filterVendors"
				>
					<div class="form-group">
						<input
							type="text"
							class="form-control"
							placeholder="Search Vendors"
							v-model="searchTerm"
							required
						/>
					</div>
					<div class="form-footer mb-0">
						<button
							type="submit"
							class="btn btn-primary btn-submit form-footer-right mr-0"
						>
							Apply
						</button>
					</div>
				</form>
			</vue-slide-toggle>

			<div class="row">
				<template v-if="filteredUsers.length > 0">
					<div
						class="col-md-4"
						v-for="user in filteredUsers"
						:key="user.id"
					>
						<div
							class="store"
							:class="{ 'no-banner': !user.vendor.banner }"
						>
							<div class="store-info">
								<figure>
									<img
										v-lazy="
											$root.getUrl(
												user.vendor.banner.copy_link,
												true
											)
										"
										:ratio="220 / 380"
										v-if="user.vendor.banner"
										alt="Store"
										:width="user.vendor.banner.width"
										:height="user.vendor.banner.height"
									/>
									<img
										v-lazy="
											$root.getUrl(
												'client/images/vendors/banner-3.png'
											)
										"
										v-else
										alt="Store"
										width="453"
										height="220"
									/>
								</figure>
								<div class="store-content">
									<h3 class="store-title">
										{{ user.vendor.store_name }}
									</h3>
									<div class="ratings-container">
										<div
											class="store-ratings"
											:title="
												'Rated ' +
												user.rating +
												'out of 5'
											"
										>
											<span
												class="ratings"
												:style="{
													width: setRating(
														user.rating
													),
												}"
											></span>
										</div>
									</div>
									<p class="store-address">
										{{
											getLocation(
												user.vendor.country,
												user.vendor.state
											)
										}}
									</p>
								</div>
							</div>
							<div class="store-footer">
								<div class="seller-avatar">
									<img
										v-lazy="
											$root.getUrl(
												user.vendor.profile.copy_link,
												true,
												100
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
								<router-link
									:to="'/vendors/' + user.id"
									class="btn btn-primary btn-round"
								></router-link>
							</div>
						</div>
					</div>
				</template>
				<div class="info-box with-icon py-3 px-1 skel-hide" v-else>
					<p class="porto-info">No vendor matching your selection.</p>
				</div>
			</div>
		</div>
		<div class="mb-6"></div>
	</main>
</template>
<script>
import { VueSlideToggle } from "vue-slide-toggle";

import { COUNTIRES, STATES, COUNTRIES } from "../../../data/constant";

export default {
	components: {
		VueSlideToggle,
	},
	data: function () {
		return {
			users: [],
			filteredUsers: [],
			filterSlide: false,
			sortOption: "recent",
			searchTerm: null,
		};
	},
	watch: {
		$route: function () {},
	},
	computed: {
		vendorCount: function () {
			return this.users.length;
		},
	},
	created: function () {
		this.getVendors();
	},
	methods: {
		getVendors: async function () {
			await window.axios
				.get("/web/vendors/")
				.then((response) => {
					this.users = response.data.vendors;
					this.filteredUsers = response.data.vendors;
				})
				.catch((error) => {
					this.$router.push("/pages/404");
				});
		},
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
		sortVendors: function () {
			if (this.sortOption == "recent") {
				this.filteredUsers = this.users.sort(function (a, b) {
					return a.created < b.created ? 1 : -1;
				});
			} else if (this.sortOption == "rating") {
				this.filteredUsers = this.users.sort(function (a, b) {
					return a.rating < b.rating ? 1 : -1;
				});
			}
		},
		filterVendors: function () {
			this.filteredUsers = this.users.filter(
				(user) =>
					user.vendor.store_name &&
					user.vendor.store_name.includes(this.searchTerm)
			);
		},
		setRating: function (rating) {
			return rating * 20 + "%";
		},
	},
};
</script>