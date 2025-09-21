<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="icon" href="<?= $settings['store_icon'] ? base_url($settings['store_icon']) : base_url('assets/img/rmb_circle2.png') ?>">
	<title><?= $settings['store_name'] ?? 'Our Store' ?> - <?= esc($product['product_name'] ?? 'Product Details') ?></title>

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
						<!-- Navigation Menu -->
						<nav class="nav-menu">
							<ul class="nav-list">
								<li><a href="<?= base_url() ?>" class="nav-link">Home</a></li>
								<li><a href="<?= base_url('products') ?>" class="nav-link">Products</a></li>
								<li><a href="#" class="nav-link">About Us</a></li>
							</ul>
							<!-- Mobile Menu Toggle -->
							<button class="mobile-menu-toggle" id="mobileMenuToggle">
								<span></span>
								<span></span>
								<span></span>
							</button>
							<!-- Search Icon -->
							<a href="#searchModal" class="modal-trigger search-icon-nav"><i class="fa fa-search"></i></a>
						</nav>
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
				<a href="#!" class="fa fa-times modal-action modal-close"></a>
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
                    <i class="fa fa-female"></i>Product<span><i class="fa fa-angle-right right"></i></span>
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
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-rss"></i>Blog<span><i class="fa fa-angle-right right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="<?= base_url('blog') ?>">Blog</a></li>
                        <li><a href="<?= base_url('blog-single') ?>">Blog Single</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-file"></i>Pages<span><i class="fa fa-angle-right right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="<?= base_url('about') ?>">About</a></li>
                        <li><a href="<?= base_url('contact') ?>">Contact</a></li>
                        <li><a href="<?= base_url('page-not-found') ?>">Page Not Found</a></li>
                        <li><a href="<?= base_url('settings') ?>">Settings</a></li>
                        <li><a href="<?= base_url('signup') ?>">Sign Up</a></li>
                        <li><a href="<?= base_url('signin') ?>">Sign In</a></li>
                        <li><a href="<?= base_url('team') ?>">Team</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="<?= base_url('contact') ?>"><i class="fa fa-envelope-o"></i>Contact Us</a></li>
            <li><a href="<?= base_url('signin') ?>"><i class="fa fa-sign-in"></i>Sign In</a></li>
            <li><a href="<?= base_url('signup') ?>"><i class="fa fa-user-plus"></i>Sign Up</a></li>
            <li><a href="<?= base_url() ?>"><i class="fa fa-share"></i>Log Out</a></li>
        </ul>
    </div>
    <!-- end sidebar -->
	
	<!-- sidebar -->
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
    <!-- end sidebar -->

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

	<!-- product details -->
	<div class="segments-page">
		<div class="container">
			<div class="product-details">
				<div class="contents">
					<div class="product-d-slide owl-carousel owl-theme">
						<?php if (!empty($product['image_post'])): ?>
							<div class="content">
								<img src="<?= base_url($product['image_post']) ?>" alt="<?= esc($product['product_name']) ?>" 
									 style="width: 100%; aspect-ratio: 1 / 1; object-fit: cover; object-position: center; border-radius: 10px;">
							</div>
						<?php endif; ?>
						
						<?php if (!empty($product['gallery_images'])): ?>
							<?php foreach ($product['gallery_images'] as $galleryImage): ?>
								<div class="content">
									<img src="<?= base_url($galleryImage['image_path']) ?>" alt="<?= esc($product['product_name']) ?>"
										 style="width: 100%; aspect-ratio: 1 / 1; object-fit: cover; object-position: center; border-radius: 10px;">
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
						
						<?php if (empty($product['image_post']) && empty($product['gallery_images'])): ?>
							<div class="content">
								<img src="<?= base_url('assets/frontend/images/product-details1.jpg') ?>" alt="<?= esc($product['product_name']) ?>"
									 style="width: 100%; aspect-ratio: 1 / 1; object-fit: cover; object-position: center; border-radius: 10px;">
							</div>
							<div class="content">
								<img src="<?= base_url('assets/frontend/images/product-details2.jpg') ?>" alt="<?= esc($product['product_name']) ?>"
									 style="width: 100%; aspect-ratio: 1 / 1; object-fit: cover; object-position: center; border-radius: 10px;">
							</div>
						<?php endif; ?>
					</div>
					<div class="desc-short">
						<h4><?= esc($product['product_name'] ?? 'Product Name') ?></h4>
						<h5><?= $settings['currency'] ?? 'USD' ?><?= number_format($product['price'] ?? 0, 2) ?></h5>
						<p><?= esc($product['short_description'] ?? 'Product description will be displayed here.') ?></p>
					</div>

					<div class="desc-long">
						<h5>Description</h5>
						<p><?= esc($product['description'] ?? 'Detailed product description will be displayed here.') ?></p>
					</div>
					
					<!-- Back to Home Link -->
					<div class="back-to-home" style="margin: 30px 0; text-align: center;">
						<a href="<?= base_url() ?>" class="button" style="background-color: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block; transition: background-color 0.3s;">
							<i class="fa fa-home" style="margin-right: 8px;"></i>
							Back to Home
						</a>
					</div>
				</div>
				
				<?php if (!empty($related_products)): ?>
				<div class="related-products">
					<h5>Related Products</h5>
					<div class="product-slide owl-carousel owl-theme">
						<?php foreach ($related_products as $relatedProduct): ?>
							<div class="content">
								<a href="<?= base_url('product/' . $relatedProduct['id']) ?>">
									<img src="<?= base_url($relatedProduct['image_post'] ?? 'assets/frontend/images/style1.jpg') ?>" alt="<?= esc($relatedProduct['product_name']) ?>">
								</a>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<!-- end product details -->

	<!-- footer -->
	<footer>
		<div class="container">
			<a href="<?= base_url() ?>"><h1><?= $settings['store_name'] ?? 'STORE' ?></h1></a>
					<ul>
			<li><a href="https://www.facebook.com/profile.php?id=100085169617947" target="_blank" style="color: white; font-weight: bold;"><i class="fa fa-facebook"></i> Rai Mini Boutique Facebook Page</a></li>
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
			<?php if (!empty($related_products)): ?>
				products = <?= json_encode($related_products) ?>;
				console.log('📦 Loaded', products.length, 'related products for search');
			<?php else: ?>
				console.log('⚠️ No products loaded for search');
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

	<!-- Navigation Menu Styles -->
	<style>
		/* Navigation Menu Styles */
		.nav-menu {
			display: flex;
			align-items: center;
			margin-right: 15px;
		}

		.nav-list {
			display: flex;
			list-style: none;
			margin: 0;
			padding: 0;
			gap: 20px;
		}

		.nav-link {
			color: #333;
			text-decoration: none;
			font-weight: 500;
			font-size: 14px;
			transition: color 0.3s ease;
			padding: 8px 0;
		}

		.nav-link:hover {
			color: #2196F3;
		}

		.mobile-menu-toggle {
			display: none;
			flex-direction: column;
			background: none;
			border: none;
			cursor: pointer;
			padding: 5px;
			margin-right: 10px;
		}

		.mobile-menu-toggle span {
			width: 25px;
			height: 3px;
			background-color: #333;
			margin: 3px 0;
			transition: 0.3s;
			border-radius: 2px;
		}

		/* Mobile Responsive */
		@media (max-width: 768px) {
			.nav-list {
				display: none;
				position: absolute;
				top: 100%;
				right: 0;
				background: white;
				box-shadow: 0 4px 12px rgba(0,0,0,0.15);
				border-radius: 8px;
				padding: 20px;
				min-width: 200px;
				z-index: 1000;
				flex-direction: column;
				gap: 15px;
			}

			.nav-list.active {
				display: flex;
			}

			.mobile-menu-toggle {
				display: flex;
			}

			.nav-link {
				font-size: 16px;
				padding: 10px 0;
				border-bottom: 1px solid #eee;
			}

			.nav-link:last-child {
				border-bottom: none;
			}

			.content-right {
				position: relative;
			}
		}

		@media (max-width: 480px) {
			.nav-list {
				right: -10px;
				min-width: 180px;
			}
		}
	</style>

	<!-- Navigation Menu JavaScript -->
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const mobileMenuToggle = document.getElementById('mobileMenuToggle');
			const navList = document.querySelector('.nav-list');
			
			if (mobileMenuToggle && navList) {
				mobileMenuToggle.addEventListener('click', function() {
					navList.classList.toggle('active');
				});
				
				// Close menu when clicking outside
				document.addEventListener('click', function(event) {
					if (!event.target.closest('.nav-menu')) {
						navList.classList.remove('active');
					}
				});
			}
		});
	</script>

</body>
</html>
