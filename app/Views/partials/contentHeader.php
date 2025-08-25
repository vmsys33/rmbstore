
<div class="geex-content__header">
    <!-- Mobile Menu Toggle Button -->
    <div class="geex-content__header__mobile-toggle">
        <button class="geex-content__header__mobile-toggle__btn" id="mobileMenuToggle">
            <i class="uil uil-bars"></i>
        </button>
    </div>
    
    <div class="geex-content__header__content">
        <h2 class="geex-content__header__title"><?= $title ?></h2>
        <p class="geex-content__header__subtitle"><?= $subTitle ?></p>
    </div>

    <div class="geex-content__header__action">
   
        <div class="geex-content__header__action__wrap">
            <ul class="geex-content__header__quickaction">

               
                <li class="geex-content__header__quickaction__item">
                    <a href="#" class="geex-content__header__quickaction__link">
                        <img class="user-img" src="<?= base_url('assets/img/rmb_circle2.png') ?>" alt="RMB Store" />
                    </a>
                    <div class="geex-content__header__popup geex-content__header__popup--author">
                        <div class="geex-content__header__popup__header">
                            <div class="geex-content__header__popup__header__img">
                                <img src="<?= base_url('assets/img/rmb_circle2.png') ?>" alt="RMB Store" />
                            </div>
                            <div class="geex-content__header__popup__header__content">
                                <h3 class="geex-content__header__popup__header__title">Michael Brown</h3>
                                <span class="geex-content__header__popup__header__subtitle">CEO, PixcelsThemes</span>
                            </div>
                        </div>
                        <div class="geex-content__header__popup__content">
                            <ul class="geex-content__header__popup__items">
                                <li class="geex-content__header__popup__item">
                                    <a class="geex-content__header__popup__link" href="#">
                                        <i class="uil uil-user"></i>
                                        Profile
                                    </a>
                                </li>
                                <li class="geex-content__header__popup__item">
                                    <a class="geex-content__header__popup__link" href="#">
                                        <i class="uil uil-cog"></i>
                                        Settings
                                    </a>
                                </li>
                                <li class="geex-content__header__popup__item">
                                    <a class="geex-content__header__popup__link" href="#">
                                        <i class="uil uil-dollar-alt"></i>
                                        Billing
                                    </a>
                                </li>
                                <li class="geex-content__header__popup__item">
                                    <a class="geex-content__header__popup__link" href="#">
                                        <i class="uil uil-users-alt"></i>
                                        Activity
                                    </a>
                                </li>
                                <li class="geex-content__header__popup__item">
                                    <a class="geex-content__header__popup__link" href="#">
                                        <i class="uil uil-bell"></i>
                                        Help
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="geex-content__header__popup__footer">
                            <a href="#" class="geex-content__header__popup__footer__link">
                                <i class="uil uil-arrow-up-left"></i>Logout
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>