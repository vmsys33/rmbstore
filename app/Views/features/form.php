
<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?> 
	<div class="geex-content__section geex-content__form">
			<div class="geex-content__form__wrapper">
				<div class="geex-content__form__wrapper__item geex-content__form__left">

					<!-- TEXTAREA START -->
					<div class="geex-content__form__single">
						<h4 class="geex-content__form__single__label">Textarea</h4>
						<div class="geex-content__form__single__box">
							<textarea class="form-control" id="geex-textarea1" rows="5"></textarea>
							<textarea class="form-control" id="geex-textarea2" rows="5"></textarea>
						</div>
					</div>
					<!-- TEXTAREA END -->

					<!-- SEARCH START -->
					<div class="geex-content__form__single">
						<h4 class="geex-content__form__single__label">Search Box</h4>
						<div class="geex-content__header__searchform">
							<input type="text" id="searchInput1" placeholder="Search" class="geex-content__header__btn">
							<i class="uil uil-search"></i>
						</div>
					</div>
					<!-- SEARCH END -->
							
					<!-- CHECKBOX START -->
					<div class="geex-content__form__single">
						<h4 class="geex-content__form__single__label">Checkbox</h4>
						<div class="geex-content__form__single__box">
							<div class="form-check success">
								<input class="form-check-input" type="checkbox" value="" id="geex-checkbox1" />
								<label class="form-check-label" for="geex-checkbox1">
									Checkbox 1
								</label>
							</div>
							<div class="form-check warning">
								<input class="form-check-input" type="checkbox" value="" id="geex-checkbox2" />
								<label class="form-check-label" for="geex-checkbox2">
									Checkbox 2
								</label>
							</div>
							<div class="form-check danger">
								<input class="form-check-input" type="checkbox" value="" id="geex-checkbox3" />
								<label class="form-check-label" for="geex-checkbox3">
									Checkbox 3
								</label>
							</div>
							<div class="form-check info">
								<input class="form-check-input" type="checkbox" value="" id="geex-checkbox4" />
								<label class="form-check-label" for="geex-checkbox4">
									Checkbox 4
								</label>
							</div>
							<div class="form-check default">
								<input class="form-check-input" type="checkbox" value="" id="geex-checkbox5" />
								<label class="form-check-label" for="geex-checkbox5">
									Checkbox 5
								</label>
							</div>
						</div>
					</div>
					<!-- CHECKBOX END -->

				</div>
				<div class="geex-content__form__wrapper__item geex-content__form__right">

					<!-- DEFAULT INPUT START -->
					<div class="geex-content__form__single">
						<h4 class="geex-content__form__single__label">Default Input</h4>
						<div class="geex-content__form__single__box mb-20">
							<input placeholder="Insert amount" class="form-control" id="geex-input1" />
							<input placeholder="Insert amount" class="form-control" id="geex-input2" />
						</div>
						<div class="geex-content__form__single__box">
							<div class="input-icon">
								<i class="uil uil-dollar-alt"></i>
								<input placeholder="@Insert amount" class="form-control" id="geex-input3" />
							</div>
							<div class="input-icon">
								<i class="uil uil-dollar-alt"></i>
								<input placeholder="@Insert amount" class="form-control" id="geex-input4" />
							</div>
						</div>
					</div>
					<!-- DEFAULT INPUT END -->

					<!-- DEFAULT INPUT WITH LABEL START -->
					<div class="geex-content__form__single">
						<h4 class="geex-content__form__single__label">Default Input With Label</h4>
						<div class="geex-content__form__single__box mb-20">
							<div class="input-wrapper">
								<label for="geex-input-5" class="input-label">
									Label
								</label>
								<input placeholder="Insert amount" class="form-control" id="geex-input-5" />
							</div>
							<div class="input-wrapper">
								<label for="geex-input-6" class="input-label">
									Label
								</label>
								<input placeholder="Insert amount" class="form-control" id="geex-input-6" />
							</div>
						</div>
						<div class="geex-content__form__single__box">
							<div class="input-wrapper input-icon">
								<label for="geex-input-7" class="input-label">
									Label
								</label>
								<input placeholder="Insert amount" class="form-control" id="geex-input-7" />
								<i class="uil uil-dollar-alt"></i>
							</div>
							<div class="input-wrapper input-icon">
								<label for="geex-input-8" class="input-label">
									Label
								</label>
								<input placeholder="Insert amount" class="form-control" id="geex-input-8" />
								<i class="uil uil-dollar-alt"></i>
							</div>
						</div>
					</div>
					<!-- DEFAULT INPUT WITH LABEL END -->

				</div>
			</div>
	</div>   
	
<?= $this->endSection(); ?>