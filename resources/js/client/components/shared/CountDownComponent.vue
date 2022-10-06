<template>
	<div class="count-down-panel">
		<h4>
			OFFER ENDS IN:
			<span class="countdown">
				<span class="days">
					<span class="font-weight-extra-bold">237</span>
					DAYS
				</span>
				<span class="hours"
					><span class="font-weight-extra-bold">20:</span>
				</span>
				<span class="minutes"
					><span class="font-weight-extra-bold">26:</span>
				</span>
				<span class="seconds"
					><span class="font-weight-extra-bold">06</span>
				</span>
			</span>
		</h4>
	</div>
</template>

<script>
export default {
	props: {
		saleEnd: String,
	},
	data: function () {
		return {
			interval: null,
		};
	},
	mounted: function () {
		let item = this.$el;
		let until = new Date(this.saleEnd);
		this.interval = window.setInterval(() => {
			let current = new Date();
			let time = (until - current) / 1000;
			let days = parseInt(time / (3600 * 24)).toString();
			let hours = parseInt((time % (3600 * 24)) / 3600).toString();
			let minutes = parseInt((time % 3600) / 60).toString();
			let seconds = parseInt(time % 60).toString();
			item.querySelector(
				".countdown .days .font-weight-extra-bold"
			).innerHTML = days;
			item.querySelector(
				".countdown .hours .font-weight-extra-bold"
			).innerHTML = (10 > hours ? "0" : "") + hours + ":";
			item.querySelector(
				".countdown .minutes .font-weight-extra-bold"
			).innerHTML = (10 > minutes ? "0" : "") + minutes + ":";
			item.querySelector(
				".countdown .seconds .font-weight-extra-bold"
			).innerHTML = (10 > seconds ? "0" : "") + seconds;
		}, 1000);
	},
	beforeDestroy: function () {
		window.clearInterval(this.interval);
	},
};
</script>