<template>
	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<router-link to="/">
					<i class="icon-home"></i>
				</router-link>
			</li>
			<li class="breadcrumb-item">
				<router-link
					:to="{
						path: $route.path,
					}"
					>Shop</router-link
				>
			</li>
			<li
				class="breadcrumb-item"
				v-for="category in categories"
				:key="category.id"
			>
				<router-link
					:to="{
						query: { category: category.slug },
					}"
					v-if="category.slug != $route.query.category"
					>{{ category.name }}</router-link
				>
				<span v-else>{{ category.name }}</span>
			</li>
			<li class="breadcrumb-item" v-if="$route.query.tag">
				<span>Product Tag - {{ $route.query.tag }}</span>
			</li>
			<li class="breadcrumb-item" v-if="$route.query.search_term">
				<span>Search - {{ $route.query.search_term }}</span>
			</li>
		</ol>
	</nav>
</template>
<script>
export default {
    props: {
        categories: {
            type: Array,
            default: []
        }
    }
}
</script>