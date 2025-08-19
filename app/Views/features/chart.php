
<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?> 

	<div class="geex-content__wrapper">
		<div class="geex-content__section-wrapper">
			<div class="row">

				<!-- SERVER REQUEST CHART START -->
				<div class="col-lg-6 mb-40">
					<div class="geex-content__section geex-content__server-request">
						<div class="geex-content__section__header">
							<div class="geex-content__section__header__title-part">
								<h4 class="geex-content__section__header__title">Server Request</h4>
							</div>
						</div>
						<div class="geex-content__section__content">
							<div id="line-chart" class="server-request-chart"></div>
						</div>
					</div>
				</div>
				<!-- SERVER REQUEST CHART END -->
				<!-- COLUMN CHART START -->
				<div class="col-lg-6 mb-40">
					<div class="geex-content__section">
						<div id="stack-chart"></div>
					</div>
				</div>
				<!-- COLUMN CHART END -->
				<!-- VISITORS CHART START -->
				<div class="col-lg-6 md-mb-40">
					<div class="geex-content__section geex-content__visitor-count">
						<div class="geex-content__section__header">
							<div class="geex-content__section__header__title-part">
								<h4 class="geex-content__section__header__title">Visitors</h4>
							</div>
							<div class="geex-content__section__header__content-part">
								<div class="geex-content__section__header__btn">
									<a href="#" class="geex-content__section__header__link">
										View More
									</a>
								</div>
							</div>
						</div>
						<div class="geex-content__section__content">
							<div class="geex-content__visitor-count__number">
								<h2 class="geex-content__visitor-count__number__title">98,425k</h2>
								<div class="geex-content__visitor-count__number__text">
									<span class="geex-content__visitor-count__number__subtitle">+2.5%</span>
									<p class="geex-content__visitor-count__number__desc">Than last week</p>
								</div>
							</div>
							<div id="column-chart"></div>
						</div>
					</div>
				</div>
				<!-- VISITORS CHART END -->
				<!-- CHAT SUMMARY CHART START -->
				<div class="col-lg-6">
					<div class="geex-content__section geex-content__chat-summary">
						<div class="geex-content__section__header">
							<div class="geex-content__section__header__title-part">
								<h4 class="geex-content__section__header__title">Chart Summary</h4>
							</div>
							<div class="geex-content__section__header__content-part">
								<div class="geex-content__section__header__btn">
									<a href="#" class="geex-content__section__header__link">
										Download Report
									</a>
								</div>
							</div>
						</div>
						<div class="geex-content__section__content">
							<div id="pie-chart"></div>
						</div>
					</div>
				</div>
				<!-- CHAT SUMMARY CHART END -->
			</div>
		</div>
	</div>

<?= $this->endSection(); ?>