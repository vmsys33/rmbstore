<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?> 

	<div class="geex-content__wrapper">
		<div class="geex-content__section-wrapper">
			<div class="geex-content__section geex-content__section--transparent geex-content__calendar">
				<button class="geex-btn geex-content__calendar__toggle">
					<i class="uil-bars"></i> Event List
				</button>

				<!-- CALENDAR SIDEBAR SECTION START -->
				<div class="geex-content__calendar__sidebar">
					<div class="geex-content__calendar__sidebar__header">
						<button class="geex-btn geex-btn--primary geex-btn__add-modal">
							<i class="uil-plus"></i> New Event
						</button>
					</div>
					<div class="geex-content__calendar__sidebar__meeting">
						<span class="geex-content__calendar__sidebar__meeting__label">My Schedule Today</span>
						<div class="geex-content__calendar__sidebar__meeting__single">
							<div class="geex-content__calendar__sidebar__meeting__single__text">
								<h4 class="geex-content__calendar__sidebar__meeting__single__title">Client Weekly Meeting</h4>
								<span class="geex-content__calendar__sidebar__meeting__single__time">09:00 AM - 10:00 AM</span>
							</div>
							<div class="geex-content__calendar__sidebar__meeting__single__tag">
								<a href="#" class="geex-content__calendar__sidebar__meeting__single__tag__item danger">
									Urgent
								</a>
								<a href="#" class="geex-content__calendar__sidebar__meeting__single__tag__item success">
									Face to face
								</a>
							</div>
							<div class="geex-content__calendar__sidebar__meeting__single__author">
								<div class="geex-content__calendar__sidebar__meeting__single__author__img">
									<img src="<?= base_url('assets/img/avatar/chat/1.svg') ?>" alt="avatar">
								</div>
								<div class="geex-content__calendar__sidebar__meeting__single__author__content">
									<div class="geex-content__calendar__sidebar__meeting__single__author__text">
										<span class="geex-content__calendar__sidebar__meeting__single__author__title">John Braun</span>
										<a href="#" class="geex-content__calendar__sidebar__meeting__single__author__btn">View details</a>
									</div>
									<div class="geex-content__calendar__sidebar__meeting__single__author__icon">
										<a href="#">
											<i class="uil-angle-right"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="geex-content__calendar__sidebar__meeting__single">
							<div class="geex-content__calendar__sidebar__meeting__single__text">
								<h4 class="geex-content__calendar__sidebar__meeting__single__title">Maintenance CenterLoad Balancer</h4>
								<span class="geex-content__calendar__sidebar__meeting__single__time">09:00 AM - 10:30 AM</span>
							</div>
							<div class="geex-content__calendar__sidebar__meeting__single__tag">
								<a href="#" class="geex-content__calendar__sidebar__meeting__single__tag__item primary">
									Fixing
								</a>
								<a href="#" class="geex-content__calendar__sidebar__meeting__single__tag__item warning">
									Backend
								</a>
							</div>
						</div>
						<div class="geex-content__calendar__sidebar__meeting__single">
							<div class="geex-content__calendar__sidebar__meeting__single__text">
								<h4 class="geex-content__calendar__sidebar__meeting__single__title">Check Annual Report</h4>
								<span class="geex-content__calendar__sidebar__meeting__single__time">09:00 AM - 10:30 AM</span>
							</div>
							<div class="geex-content__calendar__sidebar__meeting__single__tag">
								<a href="#" class="geex-content__calendar__sidebar__meeting__single__tag__item info">
									Report
								</a>
							</div>
						</div>
					</div>

					<div class="geex-content__calendar__sidebar__bottom">
						<button class="geex-btn geex-content__calendar__sidebar__bottom__btn">
							View More <i class="uil-arrow-right"></i>
						</button>
					</div>
				</div>
				<!-- CALENDAR SIDEBAR SECTION END -->
				<!-- CALENDAR CONTENT SECTION START -->
				<div class="tab-content geex-content__calendar__content">
					<div class="geex-content__modal__form">
						<div class="geex-content__modal__form__header">
							<h3 class="geex-content__modal__form__title">Add New Event</h3>
							<button class="geex-content__modal__form__close">
								<i class="uil-times"></i>
							</button>
						</div>
						<form class="geex-content__modal__form__wrapper">
							<div class="geex-content__modal__form__item">
								<input type="text" name="geex-content__modal__form__name" class="geex-content__modal__form__input" placeholder="Event Title" />
							</div>
							<div class="geex-content__modal__form__item">
								<textarea name="geex-content__modal__form__desc" class="geex-content__modal__form__input geex-content__modal__form__input--textarea" placeholder="Event Description"></textarea>
							</div>
							<div class="geex-content__modal__form__item">
								<button type="submit" class="geex-content__modal__form__submit">Submit</button>
							</div>
						</form>
					</div>
					<div id='geex-calendar' class="geex-calendar"></div>
				</div>
				<!-- CALENDAR CONTENT SECTION END -->
			</div>
		</div>
	</div>

	<!-- JAVASCRIPTS START -->
	<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
	<script src="https://fullcalendar.io/releases/fullcalendar/3.9.0/lib/moment.min.js"></script>
	<script src="https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.min.js"></script>
	<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<!-- JAVASCRIPTS END -->

<?= $this->endSection(); ?>	

<?= $this->section('custom_scripts'); ?> 
	<!-- JAVASCRIPTS START -->
	<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
            <script src="https://fullcalendar.io/releases/fullcalendar/3.9.0/lib/moment.min.js"></script>
            <script src="https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.min.js"></script>
            <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <!-- JAVASCRIPTS END -->
<?= $this->endSection(); ?>	