<template>
	<div class="category-banner-container bg-gray">
		<div
			class="category-banner banner text-uppercase shop-banner"
			v-lazy:background-image="
				$root.getUrl('client/images/banners/banner-top.jpg')
			"
		>
			<div class="container position-relative">
				<div class="row">
					<div
						class="pl-lg-5 pb-5 pb-md-0 col-md-5 col-xl-4 col-lg-4 offset-1"
					>
						<h3>
							Electronic
							<br />Deals
						</h3>
						<a href="#" class="btn btn-dark btn-black ls-10"
							>Get Yours!</a
						>
					</div>
					<div class="col-md-4 offset-md-0 offset-1 pt-3">
						<div class="coupon-sale-content">
							<h4
								class="coupon-sale-text bg-white text-transform-none ls-n-10"
							>
								Exclusive COUPON
							</h4>
							<h5 class="mb-2 coupon-sale-text d-block p-0">
								<i class="ls-0">UP TO</i>
								<b class="text-dark">$100</b> OFF
							</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>