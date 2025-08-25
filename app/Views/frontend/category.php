<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="icon" href="<?= $settings['store_icon'] ? base_url($settings['store_icon']) : base_url('assets/img/rmb_circle2.png') ?>">
	<title><?= $settings['store_name'] ?? 'Our Store' ?> - <?= esc($category['name'] ?? 'Category') ?></title>

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
                            <?php foreach ($categories as $cat): ?>
                                <li><a href="<?= base_url('category/' . $cat['id']) ?>"><?= esc($cat['name']) ?></a></li>
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
                <?php foreach (array_slice($categories, 0, 6) as $cat): ?>
                    <li><a href="<?= base_url('category/' . $cat['id']) ?>"><?= esc($cat['name']) ?></a></li>
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

	<!-- category products -->
	<div class="product-list segments-page">
		<div class="container">
			<div class="pages-title">
				<h3><?= esc($category['name'] ?? 'Category') ?> Products</h3>
			</div>
			<div class="row">
				<div class="col s6">
					<select class="browser-default">
					    <option value="1">Newest Items</option>
					    <option value="2">Best Seller</option>
					    <option value="3">Popular</option>
					    <option value="4">Price: High to Low</option>
					    <option value="5">Price: Low to High</option>
				 	</select>
				</div>
				<div class="col s6">
					<select class="browser-default">
					    <option value="1">Added: Any Date</option>
					    <option value="2">in the last Year</option>
					    <option value="3">in the last Month</option>
					    <option value="4">in the last Week</option>
					    <option value="5">in the last Day</option>
				 	</select>
				</div>
			</div>
			
			<?php if (!empty($products)): ?>
				<?php foreach ($products as $index => $product): ?>
					<div class="content <?= ($index < count($products) - 1) ? 'no-bb' : '' ?>">
						<div class="product-image">
							<img src="<?= base_url($product['image_icon'] ?? 'assets/frontend/images/product1.jpg') ?>" alt="<?= esc($product['product_name']) ?>">
						</div>
						<div class="product-text">
							<a href="<?= base_url('product/' . $product['id']) ?>"><p><?= esc($product['product_name']) ?></p></a>
							<h5>$<?= number_format($product['price'], 2) ?></h5>
							<button class="button">Add to Cart</button>
						</div>
						<div class="clear"></div>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="content">
					<div class="product-text">
						<p>No products found in this category.</p>
					</div>
				</div>
			<?php endif; ?>
			
			<div class="pagination">
				<ul>
					<li class="disabled"><a href="">1</a></li>
					<li><a href="">2</a></li>
					<li><a href="">3</a></li>
					<li><a href="">4</a></li>
					<li><a href="">5</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- end category products -->

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
			<?php if (!empty($products)): ?>
				products = <?= json_encode($products) ?>;
				console.log('📦 Loaded', products.length, 'products for search');
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

</body>
</html>
