<!doctype html>
<html lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Two Step Verification - Geex Dashboard</title>

	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">

	<!-- inject:css-->
	<link rel="stylesheet" href="<?= base_url('assets/vendor/css/bootstrap/bootstrap.css') ?>">
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
	<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
	<!-- endinject -->
	<link rel="icon" type="image/png" sizes="16x16" href="<?= $settings['store_icon'] ? base_url($settings['store_icon']) : base_url('assets/img/rmb_circle2.png') ?>">
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
		<div class="geex-content__authentication geex-content__authentication--forgot-password">
			<div class="geex-content__authentication__content">
				<div class="geex-content__authentication__content__wrapper">
					<div class="geex-content__authentication__content__logo">
						<a href="<?= route_to('index') ?>">
							<img src="<?= base_url('assets/img/logo.svg') ?>" alt="">
						</a>
					</div>

					<!-- VARIFICATION FORM START -->
					<form id="signInForm" class="geex-content__authentication__form">
						<h2 class="geex-content__authentication__title">Two Step Verification 👋</h2>
						<p class="geex-content__authentication__desc">We sent a verification code to your mobile. Enter the code from the mobile in the field below. <span class="verification-number">*******1427</span></p>
						<div class="geex-content__authentication__form-group">
							<label for="verificationCode1">Type your 6 digits security code</label>
							<div class="geex-content__authentication__form-group__code">
								<input type="text" id="verificationCode1" name="verificationCode1" required>
								<input type="text" id="verificationCode2" name="verificationCode2" required>
								<input type="text" id="verificationCode3" name="verificationCode3" required>
								<input type="text" id="verificationCode4" name="verificationCode4" required>
								<input type="text" id="verificationCode5" name="verificationCode5" required>
								<input type="text" id="verificationCode6" name="verificationCode6" required>
							</div>
						</div>
						<button type="submit" class="geex-content__authentication__form-submit">Verify My Account</button>
						<div class="geex-content__authentication__form-footer">
							Didn’t get the code? <a href="#">Resend</a>
						</div>
					</form>
					<!-- VARIFICATION FORM END -->

				</div>
			</div>
			<!-- SIDE IMAGE START -->
			<div class="geex-content__authentication__img">
				<img src="<?= base_url('assets/img/authentication.svg') ?>" alt="">
			</div>
			<!-- SIDE IMAGE END -->
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