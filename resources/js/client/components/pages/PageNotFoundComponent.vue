<template>
	<div class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<router-link to="/">
							<i class="icon-home"></i>
						</router-link>
					</li>
					<li class="breadcrumb-item active" aria-current="page">
						404
					</li>
				</ol>
			</div>
		</nav>
		<div class="container">
			<section class="http-error">
				<div class="row justify-content-center py-3">
					<div class="col-md-7 text-center">
						<div class="http-error-main">
							<h2>
								404
								<i class="fas fa-file ml-3"></i>
							</h2>
							<p>
								We're sorry, but the page you were looking for
								doesn't exist.
							</p>
						</div>
					</div>
					<div class="col-md-4 mt-4 mt-md-0">
						<h4 class="text-primary">Here are some useful links</h4>
						<ul class="nav nav-list">
							<li class="nav-item">
								<router-link class="nav-link" to="/"
									>Home</router-link
								>
							</li>
							<li class="nav-item">
								<router-link
									class="nav-link"
									to="/pages/about-us"
									>About Us</router-link
								>
							</li>
							<li class="nav-item">
								<a
									class="nav-link"
									href="https://d-themes.com/laravel/porto/porto-docs"
									>FAQ's</a
								>
							</li>
							<li class="nav-item">
								<router-link class="nav-link" to="#"
									>Sitemap</router-link
								>
							</li>
							<li class="nav-item">
								<router-link
									class="nav-link"
									to="/pages/contact-us"
									>Contact Us</router-link
								>
							</li>
						</ul>
					</div>
				</div>
			</section>
		</div>
	</div>
</template>

<script>
export default {};
</script>