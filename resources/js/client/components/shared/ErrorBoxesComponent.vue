<template>
	<ul class="error-box" v-if="errorMsg.length">
		<li
			v-for="(error, index) in errorMsg"
			:key="'error-' + index"
			v-html="error"
		></li>
	</ul>
</template>
<script>
export default {
    props: {
        errorMsg: Array
    }
}
</script>