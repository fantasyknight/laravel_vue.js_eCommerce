<template>
	<div class="add-cart-box text-center">
		<p>
			You've just added this product to the
			<br />cart:
		</p>
		<h4 id="productTitle"></h4>
		<img
			:src="$root.getUrl(product.media[0].copy_link, true, 100)"
			id="productImage"
			width="100"
			height="100"
			:alt="
				product.media[0].alt_text
					? product.media[0].alt_text
					: 'product'
			"
			v-if="product.media.length > 0"
			:key="'cart-product'"
		/>
		<img
			id="productImage"
			width="100"
			height="100"
			alt="adding cart image"
			:src="$root.getUrl('server/images/placeholder-img-100x100.png')"
			v-else
			:key="'placeholder'"
		/>
		<div class="btn-actions">
			<div @click="$emit('close')">
				<router-link to="/pages/cart">
					<button class="btn-primary">View Cart</button>
				</router-link>
			</div>
			<a href="javascript:;">
				<button class="btn-primary" @click.prevent="$emit('close')">
					Continue
				</button>
			</a>
		</div>
	</div>
</template>
<script>
export default {
	props: {
		product: Object,
	},
};
</script>