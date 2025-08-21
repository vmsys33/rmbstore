<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?> 

	<div class="geex-content__section geex-content__form">
		<div class="geex-content__form__wrapper">
			<div class="geex-content__form__wrapper__item geex-content__form__left">

				<!-- EMAIL SECTION START -->
				<div class="geex-content__form__single d-flex gap-20 justify-content-between">
					<div class="geex-content__form__single__left">
						<h4 class="geex-content__form__single-action__label">Email</h4>
						<p class="geex-content__form__single-action__text">Welcome to Geex Modern Admin Dashboard</p>
					</div>
					<div class="geex-content__form__single__right d-flex gap-20">
						<div class="geex-content__header__searchform">
							<input type="text" id="headerSearchInput" placeholder="Search" class="geex-content__header__btn">
							<i class="uil uil-search"></i>
						</div>
						<ul class="geex-content__header__quickaction">
							<li class="geex-content__header__quickaction__item">
								<a href="#" class="geex-content__header__quickaction__link">
									<img class="notification-img" src="<?= base_url('assets/img/avatar/chat.svg') ?>" alt="chat" />
									<span class="geex-content__header__badge">84</span>
								</a>
							</li>
							<li class="geex-content__header__quickaction__item">
								<a href="#" class="geex-content__header__quickaction__link">
									<img class="notification-img" src="<?= base_url('assets/img/avatar/notification.svg') ?>" alt="chat" />
									<span class="geex-content__header__badge bg-info">2</span>
								</a>
							</li>
							<li class="geex-content__header__quickaction__item">
								<a href="#" class="geex-content__header__quickaction__link">
									<img class="user-img" src="<?= base_url('assets/img/avatar/user.svg') ?>" alt="user" />
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- EMAIL SECTION END -->
				<!-- DASHBOARD SECTION START -->
				<div class="geex-content__form__single d-flex gap-20 justify-content-between">
					<div class="geex-content__form__single__left">
						<h4 class="geex-content__form__single-action__label">Dashboard</h4>
						<p class="geex-content__form__single-action__text">Welcome to Geex Modern Admin Dashboard</p>
					</div>
					<div class="geex-content__form__single__right d-flex gap-20">
						<ul class="geex-content__header__quickaction">
							<li class="geex-content__header__quickaction__item">
								<a href="#" class="geex-content__header__quickaction__link">
									<i class="uil uil-search"></i>
								</a>
							</li>
							<li class="geex-content__header__quickaction__item">
								<a href="#" class="geex-content__header__quickaction__link">
									<img class="notification-img" src="<?= base_url('assets/img/avatar/chat.svg') ?>" alt="chat" />
									<span class="geex-content__header__badge">5</span>
								</a>
							</li>
							<li class="geex-content__header__quickaction__item">
								<a href="#" class="geex-content__header__quickaction__link">
									<img class="notification-img" src="<?= base_url('assets/img/avatar/notification.svg') ?>" alt="chat" />
									<span class="geex-content__header__badge bg-info">15</span>
								</a>
							</li>
							<li class="geex-content__header__quickaction__item">
								<a href="#" class="geex-content__header__quickaction__link">
									<img class="user-img" src="<?= base_url('assets/img/avatar/user.svg') ?>" alt="user" />
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- DASHBOARD SECTION END -->
				<!-- PAGINATION SECTION START -->
				<div class="geex-content__form__single d-flex gap-20 justify-content-between">
					<div class="geex-content__form__single__left">
						<p class="geex-content__form__single__text">Showing 4 of 256 data</p>
					</div>
					<div class="geex-content__form__single__right d-flex gap-20">
						<ul class="geex-content__pagination flex gap-10">
							<li class="geex-content__pagination__item">
								<a href="#" class="geex-content__pagination__link active">
									1
								</a>
							</li>
							<li class="geex-content__pagination__item">
								<a href="#" class="geex-content__pagination__link">
									2
								</a>
							</li>
							<li class="geex-content__pagination__item">
								<a href="#" class="geex-content__pagination__link">
									3
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- PAGINATION SECTION END -->

			</div>
		</div>
	</div>  

<?= $this->endSection(); ?>