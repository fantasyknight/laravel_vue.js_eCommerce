<template>
	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<router-link to="/">
					<i class="icon-home"></i>
				</router-link>
			</li>
			<li class="breadcrumb-item">
				<router-link to="/shop/default">Shop</router-link>
			</li>
			<li class="breadcrumb-item">
				<span
					v-for="(category, index) in categories"
					:key="category.id"
				>
					<router-link
						:to="{
							path: '/shop/default',
							query: { category: category.slug },
						}"
						class="product-category"
						>{{ category.name }}</router-link
					>
					{{ index < categories.length - 1 ? "," : "" }}
				</span>
			</li>
			<li class="breadcrumb-item">
				{{ name }}
			</li>
		</ol>
	</nav>
</template>
<script>
export default {
    props: {
        categories: Array,
        name: String
    }
}
</script>