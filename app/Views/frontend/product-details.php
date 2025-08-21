<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="icon" href="<?= base_url('assets/frontend/images/favicon.png') ?>">
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
						<a href="#slide-out" data-activates="slide-out" class="sidebar"><i class="fa fa-bars"></i></a>
						<a href="<?= base_url() ?>"><h1><?= $settings['store_name'] ?? 'STORE' ?></h1></a>
					</div>
				</div>
				<div class="col s6">
					<div class="content-right">
						<a href="#slide-out-right" data-activates="slide-out-right" class="sidebar-search"><i class="fa fa-search"></i></a>
						<a href="#slide-out-cart" data-activates="slide-out-cart" class="sidebar-cart">
							<i class="fa fa-shopping-cart"></i>
							<sup>0</sup>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end navbar -->
	
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
								<img src="<?= base_url($product['image_post']) ?>" alt="<?= esc($product['product_name']) ?>">
							</div>
						<?php endif; ?>
						
						<?php if (!empty($product['gallery_images'])): ?>
							<?php foreach ($product['gallery_images'] as $galleryImage): ?>
								<div class="content">
									<img src="<?= base_url($galleryImage['image_path']) ?>" alt="<?= esc($product['product_name']) ?>">
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
						
						<?php if (empty($product['image_post']) && empty($product['gallery_images'])): ?>
							<div class="content">
								<img src="<?= base_url('assets/frontend/images/product-details1.jpg') ?>" alt="<?= esc($product['product_name']) ?>">
							</div>
							<div class="content">
								<img src="<?= base_url('assets/frontend/images/product-details2.jpg') ?>" alt="<?= esc($product['product_name']) ?>">
							</div>
						<?php endif; ?>
					</div>
					<div class="desc-short">
						<h4><?= esc($product['product_name'] ?? 'Product Name') ?></h4>
						<h5>$<?= number_format($product['price'] ?? 0, 2) ?></h5>
						<p><?= esc($product['short_description'] ?? 'Product description will be displayed here.') ?></p>
						<button class="button"><i class="fa fa-shopping-cart"></i>Add to cart</button>
					</div>
					<div class="share-media">
						<h5>Share</h5>
						<ul>
							<li><a href=""><i class="fa fa-facebook"></i></a></li>
							<li><a href=""><i class="fa fa-twitter"></i></a></li>
							<li><a href=""><i class="fa fa-google"></i></a></li>
						</ul>
					</div>
					<div class="desc-long">
						<h5>Description</h5>
						<p><?= esc($product['description'] ?? 'Detailed product description will be displayed here.') ?></p>
					</div>
				</div>
				
				<?php if (!empty($related_products)): ?>
				<div class="related-products">
					<h5>Related Products</h5>
					<div class="product-slide owl-carousel owl-theme">
						<?php foreach ($related_products as $relatedProduct): ?>
							<div class="content">
								<a href="<?= base_url('product/' . $relatedProduct['id']) ?>">
									<img src="<?= base_url($relatedProduct['image_icon'] ?? 'assets/frontend/images/style1.jpg') ?>" alt="<?= esc($relatedProduct['product_name']) ?>">
								</a>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endif; ?>
				<div class="review">
					<h5>Review</h5>
					<div class="comment-people">
						<div class="contents">
							<div class="icon">
								<img src="<?= base_url('assets/frontend/images/comment1.png') ?>" alt="">
							</div>
							<div class="text">
								<h6>John Doe</h6>
								<p class="date">January 10, 2018</p>
								<p>Great product! Highly recommended.</p>
							</div>
						</div>
						<div class="contents reply">
							<div class="icon">
								<img src="<?= base_url('assets/frontend/images/comment2.png') ?>" alt="">
							</div>
							<div class="text">
								<h6>Jordan <i class="fa fa-bookmark"></i></h6>
								<p class="date">January 10, 2018</p>
								<p>Excellent quality and fast delivery!</p>
							</div>
						</div>
					</div>
				</div>
				<div class="comment-post">
					<div class="comment-title">
						<h5>Leave Your Reply</h5>
					</div>
					<form>
						<input type="text" placeholder="Name">
						<input type="email" placeholder="Email">
						<textarea class="no-mb" cols="30" rows="10" placeholder="Message"></textarea>
						<button class="button">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end product details -->

	<script src="<?= base_url('assets/frontend/js/jquery.min.js') ?>?v=1.0"></script>
	<script src="<?= base_url('assets/frontend/js/materialize.js') ?>?v=1.0"></script>
	<script src="<?= base_url('assets/frontend/js/owl.carousel.min.js') ?>?v=1.0"></script>
    <script src="<?= base_url('assets/frontend/js/styleswitcher.js') ?>?v=1.0"></script>
	<script src="<?= base_url('assets/frontend/js/main.js') ?>?v=1.0"></script>

	<!-- Chatbot Integration -->
	<div class="chatbot-toggle" id="chatbotToggle">
		<div class="chatbot-icon">💬</div>
		<div class="chatbot-badge" id="chatbotBadge" style="display: none;">1</div>
	</div>

	<div class="chatbot-container" id="chatbotContainer">
		<div class="chatbot-header">
			<div class="chatbot-title">
				<div class="chatbot-avatar">🤖</div>
				<div class="chatbot-info">
					<h3>RMB Store Assistant</h3>
					<span class="status">Online</span>
				</div>
			</div>
			<button class="chatbot-close" id="chatbotClose">&times;</button>
		</div>

		<div class="chatbot-messages" id="chatbotMessages">
			<div class="message bot-message">
				<div class="message-content">
					<p>👋 Hi there! I'm your RMB Store assistant. How can I help you today?</p>
					<div class="quick-replies">
						<button class="quick-reply" onclick="sendQuickReply('products')">📦 Products</button>
						<button class="quick-reply" onclick="sendQuickReply('categories')">🏷️ Categories</button>
						<button class="quick-reply" onclick="sendQuickReply('contact')">📞 Contact</button>
						<button class="quick-reply" onclick="sendQuickReply('pricing')">💰 Pricing</button>
					</div>
				</div>
				<div class="message-time">Just now</div>
			</div>
		</div>

		<div class="chatbot-input">
			<input type="text" id="chatbotInput" placeholder="Type your message..." maxlength="500">
			<button class="chatbot-send" id="chatbotSend">📤</button>
		</div>
	</div>

	<script src="<?= base_url('assets/frontend/js/chatbot.js') ?>"></script>

</body>
</html>
