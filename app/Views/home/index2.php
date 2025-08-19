<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?> 

    <div class="geex-content__wrapper">
        <div class="geex-content__section-wrapper">
            <div class="geex-content__double-column mb-40">

                <!-- INCOME CHART START -->
                <div class="geex-content__section geex-content__income-count">
                    <div class="geex-content__section__header">
                        <div class="geex-content__section__header__title-part">
                            <h4 class="geex-content__section__header__title">Income</h4>
                        </div>
                    </div>
                    <div class="geex-content__section__content">
                        <div class="geex-content__section__content__top">
                            <div class="geex-content__section__content__top__left">
                                <h4 class="geex-content__section__content__amount increment">
                                    <i class="uil uil-angle-up"></i>
                                    +4,6%
                                </h4>
                                <p class="geex-content__section__content__subtitle">Bigger than last week</p>
                            </div>
                            <div class="geex-content__section__content__top__right">
                                <h4 class="geex-content__section__content__price">$1,572.68</h4>
                            </div>
                        </div>
                        <div id="income-chart" class="column-chart"></div>
                    </div>
                </div>
                <!-- INCOME CHART END -->
                <!-- EXPENSE CHART START -->
                <div class="geex-content__section geex-content__expense-count">
                    <div class="geex-content__section__header">
                        <div class="geex-content__section__header__title-part">
                            <h4 class="geex-content__section__header__title">Expense</h4>
                        </div>
                    </div>
                    <div class="geex-content__section__content">
                        <div class="geex-content__section__content__top">
                            <div class="geex-content__section__content__top__left">
                                <h4 class="geex-content__section__content__amount decrement">
                                    <i class="uil uil-angle-down"></i>
                                    -2.5%
                                </h4>
                                <p class="geex-content__section__content__subtitle">Bigger than last week</p>
                            </div>
                            <div class="geex-content__section__content__top__right">
                                <h4 class="geex-content__section__content__price">$802.16</h4>
                            </div>
                        </div>
                        <div id="expense-chart"></div>
                    </div>
                </div>
                <!-- EXPENSE CHART END -->

            </div>

            <!-- TRANSACTION START -->
            <div class="geex-content__section geex-content__transaction">
                <div class="geex-content__section__header">
                    <div class="geex-content__section__header__title-part">
                        <h4 class="geex-content__section__header__title">All Transaction</h4>
                    </div>
                    <div class="geex-content__section__header__content-part">
                        <ul class="nav nav-tabs geex-transaction-tab" id="geex-transaction-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="transaction-history-tab" data-bs-toggle="tab" data-bs-target="#transaction-history-content" type="button" role="tab" aria-controls="transaction-history-content" aria-selected="true">History</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="transaction-upcoming-tab" data-bs-toggle="tab" data-bs-target="#transaction-upcoming-content" type="button" role="tab" aria-controls="transaction-upcoming-content" aria-selected="false">Upcoming</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="transaction-request-tab" data-bs-toggle="tab" data-bs-target="#transaction-request-content" type="button" role="tab" aria-controls="transaction-request-content" aria-selected="false">Request</button>
                            </li>
                        </ul>
                        <ul class="geex-transaction-filter filter-part">
                            <li>
                                <label id="geex-content__filter__label">
                                    <i class="uil-calendar-alt"></i>
                                    <input type="date" id="geex-content__filter__date" name="filterDate">
                                </label>
                            </li>
                            <li>
                                <a href="#" class="geex-content__toggle__btn">
                                    <i class="uil-search"></i>
                                </a>
                                <div class="geex-content__toggle__content geex-content__header__searchform">
                                    <input type="text" id="searchInput1" placeholder="Search" class="geex-content__header__btn">
                                    <i class="uil uil-search"></i>
                                </div>
                            </li>
                            <li>
                                <a href="#" class="geex-content__toggle__btn">
                                    <i class="uil-filter"></i>
                                </a>
                                <div class="geex-content__toggle__content filter-popup">
                                    <a href="#">Name</a>
                                    <a href="#">Date</a>
                                    <a href="#">Amount</a>
                                    <a href="#">Last Modified</a>
                                    <button class="geex-btn geex-btn--sm">Apply Filters</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="geex-content__section__content">
                    <div class="tab-content geex-transaction-content" id="geex-transaction-content">
                        <div class="tab-pane fade show active" id="transaction-history-content" role="tabpanel" aria-labelledby="transaction-history-tab">
                            <div class="transaction-content">
                                <div class="transaction-type">
                                    <div class="transaction-type__single decrement">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-down"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Paypal Transfer</h4>
                                            <p class="transaction-type__single__content__subtitle">November 24th, 2020 at 2:45 AM</p>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single decrement">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-down"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Upgrade Storage Plan</h4>
                                            <p class="transaction-type__single__content__subtitle">November 24th, 2020 at 2:45 AM</p>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single increment">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-up"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Bank Transfer</h4>
                                            <p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single decrement">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-down"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Youtube Monthly Subcrition</h4>
                                            <p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single increment">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-up"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Bank Transfer</h4>
                                            <p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transaction-type">
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/avatar/t1.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Thomas Edison</h4>
                                            <p class="transaction-type__single__content__subtitle">@thomasedis</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="decrement">- $98.21</span>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/icon/dropbox.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Dropbox</h4>
                                            <p class="transaction-type__single__content__subtitle">November</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="increment">+ $200</span>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/avatar/t2.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Louis Khun</h4>
                                            <p class="transaction-type__single__content__subtitle">@thomasedis</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="increment">+ $500</span>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/icon/youtube.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Youtube</h4>
                                            <p class="transaction-type__single__content__subtitle">September</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="decrement">- $200</span>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/avatar/t3.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Isabella Sirait</h4>
                                            <p class="transaction-type__single__content__subtitle">@thomasedis</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="increment">+ $500</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="transaction-upcoming-content" role="tabpanel" aria-labelledby="transaction-upcoming-tab">
                            <div class="transaction-content">
                                <div class="transaction-type">
                                    <div class="transaction-type__single increment">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-up"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Bank Transfer</h4>
                                            <p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single decrement">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-down"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Youtube Monthly Subcrition</h4>
                                            <p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single increment">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-up"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Bank Transfer</h4>
                                            <p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single decrement">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-down"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Paypal Transfer</h4>
                                            <p class="transaction-type__single__content__subtitle">November 24th, 2020 at 2:45 AM</p>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single decrement">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-down"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Upgrade Storage Plan</h4>
                                            <p class="transaction-type__single__content__subtitle">November 24th, 2020 at 2:45 AM</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transaction-type">
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/avatar/t1.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Thomas Edison</h4>
                                            <p class="transaction-type__single__content__subtitle">@thomasedis</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="decrement">- $98.21</span>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/icon/dropbox.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Dropbox</h4>
                                            <p class="transaction-type__single__content__subtitle">November</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="increment">+ $200</span>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/avatar/t2.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Louis Khun</h4>
                                            <p class="transaction-type__single__content__subtitle">@thomasedis</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="increment">+ $500</span>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/icon/youtube.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Youtube</h4>
                                            <p class="transaction-type__single__content__subtitle">September</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="decrement">- $200</span>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/avatar/t3.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Isabella Sirait</h4>
                                            <p class="transaction-type__single__content__subtitle">@thomasedis</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="increment">+ $500</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="transaction-request-content" role="tabpanel" aria-labelledby="transaction-request-tab">
                            <div class="transaction-content">
                                <div class="transaction-type">
                                    <div class="transaction-type__single increment">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-up"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Bank Transfer</h4>
                                            <p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single decrement">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-down"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Paypal Transfer</h4>
                                            <p class="transaction-type__single__content__subtitle">November 24th, 2020 at 2:45 AM</p>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single increment">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-up"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Bank Transfer</h4>
                                            <p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single decrement">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-down"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Youtube Monthly Subcrition</h4>
                                            <p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single decrement">
                                        <div class="transaction-type__single__icon">
                                            <i class="uil uil-arrow-down"></i>
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Upgrade Storage Plan</h4>
                                            <p class="transaction-type__single__content__subtitle">November 24th, 2020 at 2:45 AM</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transaction-type">
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/avatar/t2.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Louis Khun</h4>
                                            <p class="transaction-type__single__content__subtitle">@thomasedis</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="increment">+ $500</span>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/icon/youtube.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Youtube</h4>
                                            <p class="transaction-type__single__content__subtitle">September</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="decrement">- $200</span>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/avatar/t3.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Isabella Sirait</h4>
                                            <p class="transaction-type__single__content__subtitle">@thomasedis</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="increment">+ $500</span>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/avatar/t1.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Thomas Edison</h4>
                                            <p class="transaction-type__single__content__subtitle">@thomasedis</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="decrement">- $98.21</span>
                                        </div>
                                    </div>
                                    <div class="transaction-type__single">
                                        <div class="transaction-type__single__icon">
                                            <img src="<?= base_url('assets/img/icon/dropbox.svg') ?>" alt="user" />
                                        </div>
                                        <div class="transaction-type__single__content">
                                            <h4 class="transaction-type__single__content__title">Dropbox</h4>
                                            <p class="transaction-type__single__content__subtitle">November</p>
                                        </div>
                                        <div class="transaction-type__single__rate">
                                            <span class="increment">+ $200</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="geex-content__section__header__btn">
                        <a href="#" class="geex-btn load-more-btn">
                            Load More <i class="uil uil-angle-down"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- TRANSACTION END -->
        </div>

        <div class="geex-content__widget">

            <!-- CARD DETAIL START -->
            <div class="geex-content__widget__single mb-20">
                <div class="geex-content__widget__single__mastercard">
                    <div class="geex-content__widget__single__mastercard__top">
                        <div class="single-content mb-30">
                            <div class="geex-content__widget__single__mastercard__top__content">
                                <p class="geex-content__widget__single__mastercard__top__subtitle">Your Balance</p>
                                <h2 class="geex-content__widget__single__mastercard__top__title">$ 9,425</h2>
                            </div>
                            <div class="geex-content__widget__single__mastercard__top__icon">
                                <a href="#">
                                    <i class="uil uil-ellipsis-h"></i>
                                </a>
                            </div>
                        </div>
                        <div class="single-content">
                            <div class="geex-content__widget__single__mastercard__top__content">
                                <span>2451 **** **** ****</span>
                            </div>
                            <div class="geex-content__widget__single__mastercard__top__date">
                                <span>02/21</span>
                            </div>
                        </div>
                    </div>

                    <div class="geex-content__widget__single__mastercard__bottom single-content">
                        <div class="geex-content__widget__single__mastercard__bottom__content">
                            <p class="geex-content__widget__single__mastercard__bottom__subtitle">Name</p>
                            <h2 class="geex-content__widget__single__mastercard__bottom__title">David Bekam</h2>
                        </div>
                        <div class="geex-content__widget__single__mastercard__bottom__icon">
                            <img src="<?= base_url('assets/img/icon/mastercard-icon.svg') ?>" alt="mastercard" />
                            <span class="card-name">Mastersef</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CARD DETAIL END -->
            <!-- RECENT TRANSACTION START -->
            <div class="geex-content__widget__single mb-20">
                <div class="geex-content__widget__single__header">
                    <h4 class="geex-content__widget__single__title">Recent Transfer</h4>
                    <p class="geex-content__widget__single__subtitle">Maiores dicta atque dolorem temporibus </p>
                </div>
                <div class="geex-content__widget__single__content">
                    <ul class="geex-content__widget__single__transfer-img">
                        <li class="geex-content__widget__single__transfer-img__single trending">
                            <a href="#" class="geex-content__widget__single__transfer-img__link">
                                <img src="<?= base_url('assets/img/avatar/t1.svg') ?>" alt="user" />
                            </a>
                        </li>
                        <li class="geex-content__widget__single__transfer-img__single transparent">
                            <a href="#" class="geex-content__widget__single__transfer-img__link">
                                <img src="<?= base_url('assets/img/avatar/t2.svg') ?>" alt="user" />
                            </a>
                        </li>
                        <li class="geex-content__widget__single__transfer-img__single trending">
                            <a href="#" class="geex-content__widget__single__transfer-img__link">
                                <img src="<?= base_url('assets/img/avatar/t3.svg') ?>" alt="user" />
                            </a>
                        </li>
                        <li class="geex-content__widget__single__transfer-img__single">
                            <a href="#" class="geex-content__widget__single__transfer-img__link">
                                <i class="uil uil-navigator"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- RECENT TRANSACTION END -->
            <!-- CATEGORIES STRAT -->
            <div class="geex-content__widget__single">
                <div class="geex-content__widget__single__header">
                    <h4 class="geex-content__widget__single__title">Spending Categories</h4>
                    <p class="geex-content__widget__single__subtitle">Maiores dicta atque dolorem temporibus</p>
                </div>
                <div class="geex-content__widget__single__content">
                    <div class="geex-content__widget__single__progress primary mb-30">
                        <div class="geex-content__widget__single__progress__icon">
                            <i class="uil uil-info-circle"></i>
                        </div>
                        <div class="geex-content__widget__single__progress__text">
                            <h4 class="geex-content__widget__single__progress__title">Installment</h4>
                            <div class="geex-content__widget__single__progressbar">
                                <div class="geex-content__widget__single__progressbar__inner" style="width: 80%;"></div>
                            </div>
                            <p class="geex-content__widget__single__progress__subtitle"><span>$ 420.26 Used</span> /from $ 1,000</p>
                        </div>
                    </div>
                    <div class="geex-content__widget__single__progress success mb-30">
                        <div class="geex-content__widget__single__progress__icon">
                            <i class="uil uil-info-circle"></i>
                        </div>
                        <div class="geex-content__widget__single__progress__text">
                            <h4 class="geex-content__widget__single__progress__title">Restaurant</h4>
                            <div class="geex-content__widget__single__progressbar">
                                <div class="geex-content__widget__single__progressbar__inner" style="width: 80%;"></div>
                            </div>
                            <p class="geex-content__widget__single__progress__subtitle"><span>$ 420.26 Used</span> /from $ 1,000</p>
                        </div>
                    </div>
                    <div class="geex-content__widget__single__progress warning mb-30">
                        <div class="geex-content__widget__single__progress__icon">
                            <i class="uil uil-info-circle"></i>
                        </div>
                        <div class="geex-content__widget__single__progress__text">
                            <h4 class="geex-content__widget__single__progress__title">Transport</h4>
                            <div class="geex-content__widget__single__progressbar">
                                <div class="geex-content__widget__single__progressbar__inner" style="width: 65%;"></div>
                            </div>
                            <p class="geex-content__widget__single__progress__subtitle"><span>$ 420.26 Used</span> /from $ 1,000</p>
                        </div>
                    </div>
                    <div class="geex-content__widget__single__progress info mb-30">
                        <div class="geex-content__widget__single__progress__icon">
                            <i class="uil uil-info-circle"></i>
                        </div>
                        <div class="geex-content__widget__single__progress__text">
                            <h4 class="geex-content__widget__single__progress__title">Holiday</h4>
                            <div class="geex-content__widget__single__progressbar">
                                <div class="geex-content__widget__single__progressbar__inner" style="width: 70%;"></div>
                            </div>
                            <p class="geex-content__widget__single__progress__subtitle"><span>$ 420.26 Used</span> /from $ 1,000</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CATEGORIES END -->
        </div>
    </div>

<?= $this->endSection(); ?>