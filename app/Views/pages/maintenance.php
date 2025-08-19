<?= $this->extend('layout/layout2'); ?>

<?= $this->section('content'); ?> 

	<!-- PAGE CONTENT START -->
	<div class="geex-content__section geex-content__error">
		<div class="geex-content__error__wrapper">
			<div class="geex-content__error__content">
				<img src="<?= base_url('assets/img/maintanence.svg') ?>" alt="Maintanence Image">
				<h3 class="geex-content__error__subtitle secondary">Site Under Maintenance</h3>
				<p class="geex-content__error__desc">We should be back shortly. Thank you for your patience.</p>
			</div>
		</div>
	</div>
	<!-- PAGE CONTENT END -->

<?= $this->endSection(); ?>	
