<template>
	<div class="store">
		<div class="store-info">
			<figure>
				<img
					v-lazy="$root.getUrl(store.banner, true)"
					width="453"
					height="220"
					alt="store"
				/>
			</figure>
			<div class="store-content">
				<h3 class="store-title">Porto Vendor</h3>
				<div class="ratings-container">
					<div class="store-ratings" title="Rated 4.00 out of 5">
						<span class="ratings" style="width: 80%;"></span>
					</div>
				</div>
				<p class="store-address">
					<span class="store-state">California,</span>
					<span class="store-country"> United States (US)</span>
				</p>
			</div>
		</div>
		<div class="store-footer">
			<div class="seller-avatar">
				<img
					v-lazy="$root.getUrl('client/images/brands/vendor-1.jpg')"
					alt="vendor"
					width="68"
					height="68"
				/>
			</div>
			<router-link
				to="/vendor/1"
				class="btn btn-primary btn-round"
			></router-link>
		</div>
	</div>
</template>
<script>
export default {
    props: {
        store: Object
    }
}
</script>