
<?= $this->extend('layout/layout2'); ?>

<?= $this->section('content'); ?>

		<div class="geex-content__section geex-content__error">
			<div class="geex-content__error__wrapper">

				<!-- PAGE CONTENT START -->
				<div class="geex-content__error__content">
					<h2 class="geex-content__error__title">404</h2>
					<h3 class="geex-content__error__subtitle">Page Not Found</h3>
					<p class="geex-content__error__desc">Sorry, the page you seems looking for, has been moved, redirected or removed permanently.</p>
					<a class="geex-btn" href="<?= route_to('index') ?>"> Back to Homepage</a>
				</div>
				<!-- PAGE CONTENT END -->

			</div>
		</div>

<?= $this->endSection(); ?>