<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <link rel="icon" href="<?= $settings['store_icon'] ? base_url($settings['store_icon']) : base_url('assets/img/rmb_circle2.png') ?>">
    <title><?= $settings['store_name'] ?? 'Our Store' ?> - Home</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/materialize.css') ?>?v=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/loaders.css') ?>?v=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/line-awesome.css') ?>?v=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/line-awesome-font-awesome.css') ?>?v=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/owl.carousel.min.css') ?>?v=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/owl.theme.default.min.css') ?>?v=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/style.css') ?>?v=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/chatbot.css') ?>">

</head>

<body>

    <!-- preloader -->
    <div class="preloader">
        <div class="spinner"></div>
    </div>
    <!-- end preloader -->

    <!-- navbar -->
    <div class="navbar">
        <div class="container">
            <div class="row">
                <div class="col s6">
                    <div class="content-left">
                        <a href="<?= base_url() ?>" style="display: flex; align-items: center; text-decoration: none;">
                            <?php if (!empty($settings['store_icon'])): ?>
                                <img src="<?= base_url($settings['store_icon']) ?>" alt="Store Icon" class="store-icon" style="height: 40px; width: auto; margin-right: 10px;">
                            <?php endif; ?>
                            <h1 style="margin: 0;"><?= $settings['store_name'] ?? 'STORE' ?></h1>
                        </a>
                    </div>
                </div>
                				<div class="col s6">
					<div class="content-right">
						<a href="#searchModal" class="modal-trigger search-icon-nav"><i class="fa fa-search"></i></a>
					</div>
				</div>
            </div>
        </div>
    </div>
    <!-- end navbar -->

    	<!-- Search Modal -->
	<div id="searchModal" class="modal search-modal">
		<div class="modal-content">
			<div class="search-modal-header">
				<h4><i class="fa fa-search"></i> Search Products</h4>
				<a href="#!" class="modal-close modal-action modal-close"><i class="fa fa-times"></i></a>
			</div>
			<div class="search-modal-body">
				<div class="search-form-container">
					<div class="search-input-wrapper">
						<i class="fa fa-search search-icon"></i>
						<input type="text" id="headerProductSearch" placeholder="Search for products, brands, categories..." autocomplete="off">
						<div class="search-suggestions hidden" id="searchSuggestions">
							<!-- Product suggestions will appear here -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end Search Modal -->

    <!-- sidebar -->
    <div class="sidebar-panel">
        <ul id="slide-out" class="collapsible side-nav">
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="<?= base_url('assets/frontend/images/bg-user.jpg') ?>" alt="">
                    </div>
                    <img class="circle responsive-img" src="<?= base_url('assets/frontend/images/profile.png') ?>" alt="">
                    <span class="white-text name"><?= $settings['admin_name'] ?? 'Guest' ?></span>
                </div>
            </li>
            <li><a href="<?= base_url() ?>"><i class="fa fa-home"></i>Home</a></li>
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-female"></i>Products<span><i class="fa fa-angle-right right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="<?= base_url('products') ?>">All Products</a></li>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <li><a href="<?= base_url('category/' . $category['id']) ?>"><?= esc($category['name']) ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-shopping-cart"></i>Shop Pages<span><i class="fa fa-angle-right right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="<?= base_url('cart') ?>">Cart</a></li>
                        <li><a href="<?= base_url('categories') ?>">Categories</a></li>
                        <li><a href="<?= base_url('wishlist') ?>">Wishlist</a></li>
                        <li><a href="<?= base_url('checkout') ?>">Checkout</a></li>
                        <li><a href="<?= base_url('profile') ?>">Profile</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="<?= base_url('about') ?>"><i class="fa fa-info-circle"></i>About Us</a></li>
            <li><a href="<?= base_url('contact') ?>"><i class="fa fa-envelope-o"></i>Contact Us</a></li>
            <li><a href="<?= base_url('signin') ?>"><i class="fa fa-sign-in"></i>Sign In</a></li>
            <li><a href="<?= base_url('signup') ?>"><i class="fa fa-user-plus"></i>Sign Up</a></li>
        </ul>
    </div>
    <!-- end sidebar -->

    <!-- sidebar search -->
    <div class="sidebar-panel sidebar-right-search">
        <ul id="slide-out-right" class="collapsible side-nav">
            <li>
                <div class="form">
                    <input type="search" placeholder="Search products...">
                    <button class="button"><i class="fa fa-search"></i></button>
                </div>
                <div class="clear"></div>
            </li>
            <li>
                <h5>Popular Categories</h5></li>
            <?php if (!empty($categories)): ?>
                <?php foreach (array_slice($categories, 0, 6) as $category): ?>
                    <li><a href="<?= base_url('category/' . $category['id']) ?>"><?= esc($category['name']) ?></a></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
    <!-- end sidebar search -->

    <!-- sidebar cart -->
    <div class="sidebar-panel sidebar-right-cart">
        <div id="slide-out-cart" class="collapsible side-nav">
            <div class="cart-items">
                <!-- Cart items will be loaded dynamically -->
                <div class="empty-cart">
                    <p>Your cart is empty</p>
                </div>
            </div>
            <div class="cart-button">
                <ul>
                    <li>
                        <button class="button" onclick="window.location.href='<?= base_url('cart') ?>'"><i class="fa fa-shopping-cart"></i>View Cart</button>
                    </li>
                    <li>
                        <button class="button" onclick="window.location.href='<?= base_url('checkout') ?>'"><i class="fa fa-send"></i>Checkout</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end sidebar cart -->

    <!-- slide -->
    <div class="container">
        <div class="slide">
            <div class="slide-show owl-carousel owl-theme">
                <?php if (!empty($sliders)): ?>
                    <?php foreach ($sliders as $index => $slider): ?>
                        <div class="slide-content <?= $index === 0 ? 'first-slide' : ($index === 1 ? 'second-slide' : 'third-slide') ?>">
                            <div class="mask2"></div>
                            <img src="<?= base_url($slider['image']) ?>" alt="<?= esc($slider['title']) ?>">
                            <div class="caption">
                                <h2><?= esc($slider['title']) ?></h2>
                                <p><?= esc($slider['subtitle'] ?? '') ?></p>
                                <?php if ($slider['button_text'] && $slider['button_url']): ?>
                                    <button class="button" onclick="window.location.href='<?= esc($slider['button_url']) ?>'"><?= esc($slider['button_text']) ?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Default sliders if no sliders are configured -->
                    <div class="slide-content first-slide">
                        <div class="mask2"></div>
                        <img src="<?= base_url('assets/frontend/images/slider1.jpg') ?>" alt="">
                        <div class="caption">
                            <h2>Welcome to <?= $settings['store_name'] ?? 'Our Store' ?></h2>
                            <p><?= $settings['about_us'] ?? 'Discover amazing products' ?></p>
                            <button class="button" onclick="window.location.href='<?= base_url('products') ?>'">Shop Now</button>
                        </div>
                    </div>
                    <div class="slide-content second-slide">
                        <div class="mask2"></div>
                        <img src="<?= base_url('assets/frontend/images/slider2.jpg') ?>" alt="">
                        <div class="caption">
                            <h2>New Collection</h2>
                            <p>Latest trends and styles</p>
                            <button class="button" onclick="window.location.href='<?= base_url('products') ?>'">Shop Now</button>
                        </div>
                    </div>
                    <div class="slide-content third-slide">
                        <div class="mask2"></div>
                        <img src="<?= base_url('assets/frontend/images/slider3.jpg') ?>" alt="">
                        <div class="caption">
                            <h2>Quality Products</h2>
                            <p>Best prices guaranteed</p>
                            <button class="button" onclick="window.location.href='<?= base_url('products') ?>'">Shop Now</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- end slide -->

    <!-- category -->
    <div class="category segments">
        <div class="container">
            <div class="row">
                <?php if (!empty($categories)): ?>
                    <?php foreach (array_slice($categories, 0, 8) as $index => $category): ?>
                        <div class="col s3">
                            <div class="content">
                                <a href="<?= base_url('category/' . $category['id']) ?>">
                                    <i class="<?= $category['category_icon'] ?? 'fa fa-tag' ?>"></i>
                                    <span><?= esc($category['name']) ?></span>
                                </a>
                            </div>
                        </div>
                        <?php if (($index + 1) % 4 == 0 && $index < 7): ?>
                            </div><div class="row">
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Default categories if none exist -->
                    <div class="col s3">
                        <div class="content">
                            <a href="<?= base_url('products') ?>">
                                <i class="fa fa-car"></i>
                                <span>Automotive</span>
                            </a>
                        </div>
                    </div>
                    <div class="col s3">
                        <div class="content">
                            <a href="<?= base_url('products') ?>">
                                <i class="fa fa-cutlery"></i>
                                <span>Food</span>
                            </a>
                        </div>
                    </div>
                    <div class="col s3">
                        <div class="content">
                            <a href="<?= base_url('products') ?>">
                                <i class="fa fa-camera-retro"></i>
                                <span>Camera</span>
                            </a>
                        </div>
                    </div>
                    <div class="col s3">
                        <div class="content">
                            <a href="<?= base_url('products') ?>">
                                <i class="fa fa-futbol-o"></i>
                                <span>Sport</span>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- end category -->

    <!-- featured products -->
    <?php if (!empty($featured_products)): ?>
    <div class="b-seller segments">
        <div class="container">
            <div class="section-title">
                <h3>Featured Products</h3>
            </div>
            <div class="row">
                <?php foreach (array_slice($featured_products, 0, 4) as $product): ?>
                    <div class="col s6">
                        <div class="content">
                            <div class="image">
                                <img src="<?= base_url($product['image_icon'] ?? 'assets/frontend/images/product1.jpg') ?>" alt="<?= esc($product['product_name']) ?>">
                            </div>
                            <div class="text">
                                <a href="<?= base_url('product/' . $product['id']) ?>">
                                    <p><?= esc($product['product_name']) ?></p>
                                </a>
                                <h5>$<?= number_format($product['price'], 2) ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- end featured products -->

    <!-- banner -->
    <div class="banner">
        <div class="container-fluid">
            <div class="content">
                <a href="<?= base_url('products') ?>"><img src="<?= base_url('uploads/products/product_ads.jpg') ?>" alt="Product Advertisement"></a>
            </div>
        </div>
    </div>
    <!-- end banner -->

    <!-- latest products -->
    <?php if (!empty($latest_products)): ?>
    <div class="product-home segments">
        <div class="container">
            <div class="section-title">
                <h3>Latest Products</h3>
            </div>
            <div class="product-slide owl-carousel owl-theme">
                <?php foreach ($latest_products as $product): ?>
                    <div class="content">
                        <a href="<?= base_url('product/' . $product['id']) ?>">
                            <img src="<?= base_url($product['image_icon'] ?? 'assets/frontend/images/style1.jpg') ?>" alt="<?= esc($product['product_name']) ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="l-more">
                <a href="<?= base_url('products') ?>">
                    See More<i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- end latest products -->

    <!-- footer -->
    <footer>
        <div class="container">
            <a href="<?= base_url() ?>"><h1><?= $settings['store_name'] ?? 'STORE' ?></h1></a>
            <ul>
                <?php if (!empty($settings['social_facebook'])): ?>
                    <li><a href="<?= esc($settings['social_facebook']) ?>"><i class="fa fa-facebook"></i></a></li>
                <?php endif; ?>
                <?php if (!empty($settings['social_twitter'])): ?>
                    <li><a href="<?= esc($settings['social_twitter']) ?>"><i class="fa fa-twitter"></i></a></li>
                <?php endif; ?>
                <?php if (!empty($settings['social_instagram'])): ?>
                    <li><a href="<?= esc($settings['social_instagram']) ?>"><i class="fa fa-instagram"></i></a></li>
                <?php endif; ?>
            </ul>
            <p>Copyright © <?= date('Y') ?> <?= $settings['store_name'] ?? 'Our Store' ?>. All Rights Reserved</p>
            <p><a href="<?= base_url('admin/') ?>" style="color: #fff; text-decoration: none; font-size: 12px;">Admin Panel</a></p>
        </div>
    </footer>
    <!-- end footer -->

    <script src="<?= base_url('assets/frontend/js/jquery.min.js') ?>?v=1.0"></script>
    <script src="<?= base_url('assets/frontend/js/materialize.js') ?>?v=1.0"></script>
    <script src="<?= base_url('assets/frontend/js/owl.carousel.min.js') ?>?v=1.0"></script>
    <script src="<?= base_url('assets/frontend/js/styleswitcher.js') ?>?v=1.0"></script>
         <script src="<?= base_url('assets/frontend/js/main.js') ?>?v=1.0"></script>

    <!-- Load Products for Search -->
    <script>
        // Global products array for search functionality
        let products = [];
        
        // Load products when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Load products from the page data
            <?php if (!empty($latest_products)): ?>
                products = <?= json_encode($latest_products) ?>;
                console.log('📦 Loaded', products.length, 'latest products for search');
                console.log('📦 Products data:', products);
            <?php else: ?>
                console.log('⚠️ No latest products loaded for search');
            <?php endif; ?>
        });
    </script>

    <!-- Chatbot Widget -->
    <div class="chatbot-widget" id="chatbotWidget">
        <!-- Chat Button -->
                        <div class="chat-button" id="chatButton">
                    <i class="fa fa-comments"></i>
                </div>
        
        <!-- Chat Window -->
        <div class="chat-window" id="chatWindow">
            <!-- Chat Header -->
            <div class="chat-header">
                <div class="chat-header-info">
                    <div class="chat-avatar">
                        <i class="fa fa-robot"></i>
                    </div>
                    <div class="chat-title">
                        <h4>RMB Store Assistant</h4>
                        <span class="status">Online</span>
                    </div>
                </div>
                <div class="chat-actions">
                    <button class="close-btn" id="closeBtn">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Chat Messages -->
            <div class="chat-messages" id="chatMessages">
                <!-- Welcome Message -->
                <div class="message bot-message">
                    <div class="message-content">
                        <p>👋 Hi there! I'm your RMB Store assistant. How can I help you today?</p>
                        <span class="message-time">Just now</span>
                    </div>
                </div>
                

            </div>
            
            <!-- Mode Toggle -->
            <div class="chat-mode-toggle">
                <div class="mode-indicator" id="modeIndicator">🤖 Auto-Detect</div>
                <div class="mode-buttons">
                    <button class="mode-btn active" data-mode="auto" title="Auto-detect mode">
                        <i class="fa fa-magic"></i>
                        <span>Auto</span>
                    </button>
                    <button class="mode-btn" data-mode="products" title="Product search mode">
                        <i class="fa fa-shopping-bag"></i>
                        <span>Products</span>
                    </button>
                    <button class="mode-btn" data-mode="store" title="Store inquiry mode">
                        <i class="fa fa-store"></i>
                        <span>Store</span>
                    </button>
                </div>
            </div>
            
            <!-- Chat Input -->
            <div class="chat-input-container">
                <div class="chat-input-wrapper">
                    <input type="text" id="chatInput" placeholder="Ask me anything... (auto-detect mode)" maxlength="500">
                    <button class="send-btn" id="sendBtn" title="Send Message">
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </div>
                <div class="typing-indicator" id="typingIndicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/frontend/js/chatbot.js') ?>"></script>

</body>

</html>
