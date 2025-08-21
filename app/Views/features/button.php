<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?> 

	<div class="geex-content__section geex-content__form">
		<div class="geex-content__form__wrapper">
			<div class="geex-content__form__wrapper__item geex-content__form__left">
				<div class="geex-content__form__single d-flex gap-10">
					<button class="geex-btn"><i class="uil-plus"></i> New Message</button>
					<button class="geex-btn geex-btn--dark"><i class="uil-plus"></i> New Message</button>
					<button class="geex-btn geex-btn--primary"><i class="uil-plus"></i> New Message</button>
				</div>
				<div class="geex-content__form__single d-flex gap-10">
					<button class="geex-btn geex-btn--transparent"><i class="uil-plus"></i> New Message</button>
					<button class="geex-btn geex-btn--dark-transparent"><i class="uil-plus"></i> New Message</button>
					<button class="geex-btn geex-btn--primary-transparent"><i class="uil-plus"></i> New Message</button>
				</div>
			</div>
		</div>
	</div>

<?= $this->endSection(); ?>