
<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?> 

	<div class="geex-content__section geex-content__form">
		<div class="geex-content__form__wrapper">
			<div class="geex-content__form__wrapper__item geex-content__form__left">

				<!-- MINI BADGE START -->
				<div class="geex-content__form__single">
					<h4 class="geex-content__form__single__label">Mini badge for notification counters</h4>
					<div class="geex-content__form__single__box">
						<span class="geex-badge geex-badge--danger geex-badge--mini">2</span>
						<span class="geex-badge geex-badge--warning geex-badge--mini">84</span>
						<span class="geex-badge geex-badge--info geex-badge--mini">2</span>
					</div>
				</div>
				<!-- MINI BADGE END -->
				<!-- TEXT BADGE START -->
				<div class="geex-content__form__single">
					<h4 class="geex-content__form__single__label">Text badge for status label</h4>
					<div class="geex-content__form__single__box">
						<span class="geex-badge geex-badge--danger">Badge</span>
						<span class="geex-badge geex-badge--success">Badge</span>
						<span class="geex-badge geex-badge--warning">Badge</span>
					</div>
				</div>
				<!-- TEXT BADGE END -->
				<!-- LABEL WITH ICON START -->
				<div class="geex-content__form__single">
					<h4 class="geex-content__form__single__label">Label with icon</h4>
					<div class="geex-content__form__single__box">
						<span class="geex-badge geex-badge--label-icon geex-badge--danger-transparent"><i class="uil-arrow-down-right"></i>Label</span>
						<span class="geex-badge geex-badge--label-icon geex-badge--success-transparent"><i class="uil-arrow-down-right"></i>Label</span>
						<span class="geex-badge geex-badge--label-icon geex-badge--warning-transparent"><i class="uil-arrow-down-right"></i>Label</span>
						<span class="geex-badge geex-badge--label-icon geex-badge--info-transparent"><i class="uil-arrow-down-right"></i>Label</span>
						<span class="geex-badge geex-badge--label-icon geex-badge--primary-transparent"><i class="uil-arrow-down-right"></i>Label</span>
					</div>
				</div>
				<!--  LABEL WITH ICON END -->
			</div>
			<div class="geex-content__form__wrapper__item geex-content__form__right">

				<!-- FILE FORMAT ICON START -->
				<div class="geex-content__form__single">
					<h4 class="geex-content__form__single__label">File format Icon</h4>
					<div class="geex-content__form__single__box">
						<span class="geex-badge geex-badge--dark geex-badge--icon">
							<i class="uil-grid"></i>
						</span>
						<span class="geex-badge geex-badge--pink geex-badge--icon">
							<i class="uil-image"></i>
						</span>
						<span class="geex-badge geex-badge--warning geex-badge--icon">
							<i class="uil-play"></i>
						</span>
						<span class="geex-badge geex-badge--success geex-badge--icon">
							<i class="uil-airplay"></i>
						</span>
						<span class="geex-badge geex-badge--info geex-badge--icon">
							<i class="uil-file-alt"></i>
						</span>
						<span class="geex-badge geex-badge--primary geex-badge--icon">
							<i class="uil-folder"></i>
						</span>
						<span class="geex-badge geex-badge--white geex-badge--icon">
							<i class="uil-arrow-right"></i>
						</span>
					</div>
				</div>
				<!--  FILE FORMAT ICON END -->
				<!-- TOOLTIP START -->
				<div class="geex-content__form__single">
					<h4 class="geex-content__form__single__label">Tooltip</h4>
					<div class="geex-content__form__single__box">
						<div class="geex-tooltip geex-tooltip--default">
							<h5 class="geex-tooltip__title">24%</h5>
							<span class="geex-tooltip__text">982 Visitors</span>
						</div>
						<div class="geex-tooltip geex-tooltip--white">
							<h5 class="geex-tooltip__title">48 Request</h5>
							<span class="geex-tooltip__text">From Web Server A</span>
						</div>
					</div>
				</div>
				<!--  TOOLTIP END -->
				<!-- LABEL LEGEND START  -->
				<div class="geex-content__form__single">
					<h4 class="geex-content__form__single__label">Label Legend</h4>
					<div class="geex-content__form__single__box">
						<span class="geex-label geex-label--success">Web Server A</span>
						<span class="geex-label geex-label--primary">Web Server B</span>
					</div>
				</div>
				<!-- LABEL LEGEND END  -->
				<!--  ICON TRANSACTION START -->
				<div class="geex-content__form__single">
					<h4 class="geex-content__form__single__label">Icon Transaction</h4>
					<div class="geex-content__form__single__box">
						<span class="geex-badge geex-badge--danger-transparent geex-badge--transaction-icon">
							<i class="uil-arrow-down"></i>
						</span>
						<span class="geex-badge geex-badge--success-transparent geex-badge--transaction-icon">
							<i class="uil-arrow-up"></i>
						</span>
					</div>
				</div>
				<!-- ICON TRANSACTION END  -->
			</div>
		</div>
	</div>

<?= $this->endSection(); ?>