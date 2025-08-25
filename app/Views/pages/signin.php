<!doctype html>
<html lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Admin Login - <?= $settings['store_name'] ?? 'Store Dashboard' ?></title>

	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">

	<!-- inject:css-->
	<link rel="stylesheet" href="<?= base_url('assets/vendor/css/bootstrap/bootstrap.css') ?>">
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
	<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
	<!-- endinject -->
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/img/rmb_circle2.png') ?>">
	<!-- Fonts -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconscout/unicons@4.0.8/css/line.min.css">

	<script>
		// Render localStorage JS:
		if (localStorage.theme) document.documentElement.setAttribute("data-theme", localStorage.theme);
		if (localStorage.layout) document.documentElement.setAttribute("data-nav", localStorage.navbar);
		if (localStorage.layout) document.documentElement.setAttribute("dir", localStorage.layout);
	</script>
</head>

<body class="geex-dashboard authentication-page">
	<main class="geex-content">
		<div class="geex-content__authentication">
			<div class="geex-content__authentication__content">
				<div class="geex-content__authentication__content__wrapper">
					<div class="geex-content__authentication__content__logo">
						<a href="<?= base_url('admin/') ?>">
							<?php if (!empty($settings['store_logo'])): ?>
								<img class="logo-lite" src="<?= base_url($settings['store_logo']) ?>" alt="<?= $settings['store_name'] ?? 'Store Logo' ?>">
								<img class="logo-dark" src="<?= base_url($settings['store_logo']) ?>" alt="<?= $settings['store_name'] ?? 'Store Logo' ?>">
							<?php else: ?>
								<img class="logo-lite" src="<?= base_url('assets/img/logo-dark.svg') ?>" alt="logo">
								<img class="logo-dark" src="<?= base_url('assets/img/logo-lite.svg') ?>" alt="logo">
							<?php endif; ?>
						</a>
					</div>
					<!-- LOGIN FORM START -->
					<form method="POST" action="<?= base_url('admin/login') ?>" class="geex-content__authentication__form">
						<h2 class="geex-content__authentication__title">Admin Login 👋</h2>
						
						<?php if (session()->getFlashdata('error')): ?>
							<div class="alert alert-danger" role="alert">
								<?= session()->getFlashdata('error') ?>
							</div>
						<?php endif; ?>
						
						<?php if (session()->getFlashdata('success')): ?>
							<div class="alert alert-success" role="alert">
								<?= session()->getFlashdata('success') ?>
							</div>
						<?php endif; ?>
						
						<div class="geex-content__authentication__form-group">
							<label for="email">Email Address</label>
							<input type="email" id="email" name="email" placeholder="Enter your email" value="<?= old('email') ?>" required>
							<i class="uil-envelope"></i>
						</div>
						
						<div class="geex-content__authentication__form-group">
							<div class="geex-content__authentication__label-wrapper">
								<label for="password">Password</label>
								<a href="<?= base_url('admin/forgot-password') ?>">Forgot Password?</a>
							</div>
							<input type="password" id="password" name="password" placeholder="Enter your password" required>
							<i class="uil-eye toggle-password-type"></i>
						</div>
						
						<div class="geex-content__authentication__form-group custom-checkbox">
							<input type="checkbox" class="geex-content__authentication__checkbox-input" id="remember" name="remember" value="1">
							<label class="geex-content__authentication__checkbox-label" for="remember">Remember Me</label>
						</div>
						
						<button type="submit" class="geex-content__authentication__form-submit">Login to Admin Panel</button>
						
						<div class="geex-content__authentication__form-footer">
							<a href="<?= base_url() ?>" style="color: #666; text-decoration: none;">
								<i class="uil-arrow-left"></i> Back to Store
							</a>
						</div>
					</form>
					<!-- LOGIN FORM END -->
				</div>
			</div>

			<!-- SIDE IMAGE START  -->
			<div class="geex-content__authentication__img">
				<img src="<?= base_url('assets/img/authentication.svg') ?>" alt="">
			</div>
			<!-- SIDE IMAGE END  -->

		</div>
	</main>

	<!-- inject:js-->
	<script src="<?= base_url('assets/vendor/js/jquery/jquery-3.5.1.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendor/js/jquery/jquery-ui.js') ?>"></script>
	<script src="<?= base_url('assets/vendor/js/bootstrap/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/main.js') ?>"></script>
	<!-- endinject-->
</body>

</html>