<template>
	<div class="sticky-wrapper" :class="{ sticky: isSticky }">
		<slot></slot>
	</div>
</template>

<script>
export default {
	props: {
		wrapperClass: {
			type: String,
			default: "header",
		},
		top: {
			type: Number,
			default: 300,
		},
		lg: {
			type: Number,
		},
	},
	data: function () {
		return {
			isSticky: false
		}
	},
	mounted: function () {
		window.addEventListener("scroll", this.scrollHandler, {
			passive: true,
		});
		window.addEventListener("resize", this.scrollHandler, {
			passive: true,
		});
	},
	destroyed: function () {
		window.removeEventListener("scroll", this.scrollHandler);
		window.removeEventListener("resize", this.scrollHandler);
	},
	methods: {
		scrollHandler: function () {
			let top = this.top;

			if (window.innerWidth < 992 && this.lg) {
				top = this.lg;
			}

			if (window.pageYOffset > top) {
				if (! this.isSticky) {
					let stickyContent = this.$el.children[0];
					let height = stickyContent.offsetHeight;
					this.$el.style.height = height + "px";
					stickyContent.classList.add("fixed");
					this.isSticky = true;
				}
			} else if (this.isSticky) {
				let stickyContent = this.$el.children[0];
				stickyContent.classList.remove("fixed");
				this.isSticky = false;
			}
		},
	},
};
</script>