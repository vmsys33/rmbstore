<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="icon" href="<?= $settings['store_icon'] ? base_url($settings['store_icon']) : base_url('assets/img/rmb_circle2.png') ?>">
	<title><?= $settings['store_name'] ?? 'Our Store' ?> - Products</title>

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
                    <i class="fa fa-female"></i>Product<span><i class="fa fa-angle-right right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="<?= base_url('products') ?>">All Products</a></li>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <li><a href="<?= base_url('products?category=' . $category['id']) ?>"><?= esc($category['name']) ?></a></li>
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
                    <li><a href="<?= base_url('products?category=' . $category['id']) ?>"><?= esc($category['name']) ?></a></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
    <!-- end sidebar -->



	<!-- product list -->
	<div class="product-list segments-page">
		<div class="container">
			<div class="pages-title">
				<h3><?= $title ?? 'All Products' ?></h3>
				<!-- Product count caption -->
				<span id="product-count" class="text-base font-normal text-gray-500 ml-2"></span>
			</div>
			
			<!-- Selected Category Display -->
			<?php if (!empty($selected_category)): ?>
				<div class="selected-category-banner" style="margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
					<div class="category-pill-badge" style="background: linear-gradient(135deg, #2196F3, #1976D2); color: white; padding: 12px 20px; border-radius: 25px; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3); font-weight: bold; font-size: 16px;">
						<span>📚 <?= esc($selected_category['name']) ?></span>
					</div>
					<div class="product-count-badge" style="background: #E3F2FD; color: #1976D2; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 500; border: 2px solid #2196F3;">
						<?= count($products) ?> products in this category
					</div>
					<a href="<?= base_url('products') ?>" class="pill-close-btn" style="background: linear-gradient(135deg, #FF5722, #E64A19); color: white; padding: 12px 16px; border-radius: 25px; text-decoration: none; display: flex; align-items: center; justify-content: center; width: 45px; height: 45px; box-shadow: 0 4px 12px rgba(255, 87, 34, 0.3); transition: all 0.3s ease; font-weight: bold; font-size: 20px;">
						&times;
					</a>
				</div>
			<?php endif; ?>
			
			<!-- Badges Container -->
			<div id="badges-container" class="flex flex-wrap gap-2 mb-6 min-h-[40px]">
				<!-- Badges will be dynamically added here -->
			</div>
			

			
			<!-- Professional Filters Section -->
			<div class="filters-section">
				
				<div class="row">
					<!-- Category Filter -->
					<div class="col s12 m6 l4">
						<div class="filter-card">
							<h6><i class="fa fa-tags"></i> Categories</h6>
							<div class="category-filters">
								<div class="category-option">
									<input type="radio" id="category-all" class="category-radio" name="category" value="all" <?= empty($selected_category) ? 'checked' : '' ?>>
									<label for="category-all">All Categories</label>
								</div>
								<?php if (!empty($categories)): ?>
									<?php foreach ($categories as $category): ?>
										<div class="category-option">
											<input type="radio" id="category-<?= esc($category['id']) ?>" class="category-radio" name="category" value="<?= esc($category['id']) ?>" <?= (!empty($selected_category) && $selected_category['id'] == $category['id']) ? 'checked' : '' ?>>
											<label for="category-<?= esc($category['id']) ?>"><?= esc($category['name']) ?></label>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
					
					<!-- Price Filter -->
					<div class="col s12 m6 l8">
						<div class="filter-card">
							<h6><i class="fa fa-dollar-sign"></i> Price Range</h6>
							<div class="price-filter-container">
								<div class="price-range-display">
														<span class="price-label">Min: <span id="minPriceDisplay"><?= $settings['currency'] ?? 'USD' ?>0</span></span>
					<span class="price-label">Max: <span id="maxPriceDisplay"><?= $settings['currency'] ?? 'USD' ?>1000</span></span>
								</div>
								<div class="price-slider-container">
									<div class="price-slider-track">
										<div class="price-slider-fill" id="priceSliderFill"></div>
									</div>
									<input type="range" id="minPriceSlider" class="price-slider" min="0" max="1000" value="0" step="10">
									<input type="range" id="maxPriceSlider" class="price-slider" min="0" max="1000" value="1000" step="10">
								</div>
								<div class="price-inputs">
									<input type="number" id="minPriceInput" class="price-input" placeholder="Min Price" min="0">
									<input type="number" id="maxPriceInput" class="price-input" placeholder="Max Price" min="0">
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Products Grid -->
				<div class="products-grid" id="productsGrid">
				<?php if (!empty($products)): ?>
					<?php foreach ($products as $product): ?>
						<div class="product-card" data-category="<?= esc($product['product_category'] ?? '') ?>" data-price="<?= $product['price'] ?>">
							<div class="product-image-container">
								<img src="<?= base_url($product['image_post'] ?? 'assets/frontend/images/product1.jpg') ?>" 
									 alt="<?= esc($product['product_name']) ?>"
									 class="product-image">
								<div class="product-overlay">
									<a href="<?= base_url('product/' . $product['id']) ?>" class="view-details-btn">
										<i class="fa fa-eye"></i> View Details
									</a>
								</div>
								<?php if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']): ?>
									<div class="product-badge sale">Sale</div>
								<?php elseif (!empty($product['featured']) && $product['featured'] == 1): ?>
									<div class="product-badge featured">Featured</div>
								<?php endif; ?>
							</div>
							<div class="product-info">
								<h5 class="product-name">
									<a href="<?= base_url('product/' . $product['id']) ?>"><?= esc($product['product_name']) ?></a>
								</h5>
								<div class="product-price">
									<?php if (!empty($product['price']) && $product['price'] > 0): ?>
										<?php if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']): ?>
											<!-- Sale Price Display -->
											<span class="currency-symbol"><?= $settings['currency'] ?? 'USD' ?></span>
											<span class="price-value" style="color: #e74c3c; font-weight: 700;"><?= number_format($product['sale_price'], 2) ?></span>
											<span class="original-price" style="color: #7f8c8d; text-decoration: line-through; font-size: 0.9em; margin-left: 8px;">
												<?= $settings['currency'] ?? 'USD' ?><?= number_format($product['price'], 2) ?>
											</span>
										<?php else: ?>
											<!-- Regular Price Display -->
									<span class="currency-symbol"><?= $settings['currency'] ?? 'USD' ?></span>
									<span class="price-value"><?= number_format($product['price'], 2) ?></span>
										<?php endif; ?>
									<?php else: ?>
										<span class="price-value" style="color: #999;">Price not available</span>
									<?php endif; ?>
								</div>
								<div class="product-category">
									<?php 
									$categoryName = '';
									if (!empty($categories)) {
										foreach ($categories as $cat) {
											if ($cat['id'] == ($product['product_category'] ?? '')) {
												$categoryName = $cat['name'];
												break;
											}
										}
									}
									?>
									<span class="category-tag"><?= esc($categoryName) ?></span>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php else: ?>
					<div class="no-products">
						<i class="fa fa-box-open"></i>
						<h4>No products found</h4>
						<p>Try adjusting your filters or check back later.</p>
					</div>
				<?php endif; ?>
			</div>
			
			<!-- Results Count -->
			<div class="results-info">
				<span id="resultsCount"></span>
			</div>
			
			<!-- Pagination -->
			<?php if (isset($total_pages) && $total_pages > 1): ?>
			<div class="pagination-container">
				<div class="pagination-info">
					Showing <?= (($current_page - 1) * $per_page) + 1 ?> to <?= min($current_page * $per_page, $total_products) ?> of <?= $total_products ?> products
				</div>
				<nav class="pagination-nav">
					<ul class="pagination">
						<?php if ($has_previous): ?>
							<li class="page-item">
								<a class="page-link" href="<?= base_url('products' . ($selected_category ? '?category=' . $selected_category['id'] : '')) . ($current_page > 2 ? '&page=' . $previous_page : '') ?>">
									<i class="fa fa-chevron-left"></i> Previous
								</a>
							</li>
						<?php endif; ?>
						
						<?php
						// Calculate page range to show
						$start_page = max(1, $current_page - 2);
						$end_page = min($total_pages, $current_page + 2);
						
						// Show first page if not in range
						if ($start_page > 1): ?>
							<li class="page-item">
								<a class="page-link" href="<?= base_url('products' . ($selected_category ? '?category=' . $selected_category['id'] : '')) ?>">1</a>
							</li>
							<?php if ($start_page > 2): ?>
								<li class="page-item disabled"><span class="page-link">...</span></li>
							<?php endif; ?>
						<?php endif; ?>
						
						<?php for ($i = $start_page; $i <= $end_page; $i++): ?>
							<li class="page-item <?= $i == $current_page ? 'active' : '' ?>" <?= ($i == $current_page || $i == 1 || $i == $total_pages) ? 'data-mobile-visible="true"' : '' ?>>
								<?php if ($i == $current_page): ?>
									<span class="page-link"><?= $i ?></span>
								<?php else: ?>
									<a class="page-link" href="<?= base_url('products' . ($selected_category ? '?category=' . $selected_category['id'] : '')) . ($i > 1 ? ($selected_category ? '&' : '?') . 'page=' . $i : '') ?>"><?= $i ?></a>
								<?php endif; ?>
							</li>
						<?php endfor; ?>
						
						<?php
						// Show last page if not in range
						if ($end_page < $total_pages): ?>
							<?php if ($end_page < $total_pages - 1): ?>
								<li class="page-item disabled"><span class="page-link">...</span></li>
							<?php endif; ?>
							<li class="page-item">
								<a class="page-link" href="<?= base_url('products' . ($selected_category ? '?category=' . $selected_category['id'] : '')) . '&page=' . $total_pages ?>"><?= $total_pages ?></a>
							</li>
						<?php endif; ?>
						
						<?php if ($has_next): ?>
							<li class="page-item">
								<a class="page-link" href="<?= base_url('products' . ($selected_category ? '?category=' . $selected_category['id'] : '')) . ($selected_category ? '&' : '?') . 'page=' . $next_page ?>">
									Next <i class="fa fa-chevron-right"></i>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</nav>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<!-- end product list -->

	<script src="<?= base_url('assets/frontend/js/jquery.min.js') ?>?v=1.0"></script>
	<script src="<?= base_url('assets/frontend/js/materialize.js') ?>?v=1.0"></script>
	<script src="<?= base_url('assets/frontend/js/owl.carousel.min.js') ?>?v=1.0"></script>
    <script src="<?= base_url('assets/frontend/js/styleswitcher.js') ?>?v=1.0"></script>
	<script src="<?= base_url('assets/frontend/js/main.js') ?>?v=1.0"></script>

	<!-- Load Products for Search -->
	<script>
		// Working version - both category and price filters
		document.addEventListener('DOMContentLoaded', function() {
			const allProducts = <?= json_encode($products) ?>;
			let currentFilters = {
				category: '<?= (!empty($selected_category) && is_array($selected_category)) ? $selected_category['id'] : 'all' ?>',
				price: 'all'
			};
		
			// Category filter
			document.querySelector('.category-filters').addEventListener('change', function(e) {
				if (e.target.classList.contains('category-radio')) {
					const value = e.target.value;
					if (value === 'all') {
						window.location.href = '<?= base_url('products') ?>';
					} else {
						window.location.href = '<?= base_url('products') ?>?category=' + value;
					}
				}
			});
				
				// Initialize price range
				initializePriceRange();
			
			// Price filter
			document.getElementById('minPriceSlider').addEventListener('input', handlePriceFilter);
			document.getElementById('maxPriceSlider').addEventListener('input', handlePriceFilter);
			
		function initializePriceRange() {
			const prices = allProducts.map(p => parseFloat(p.price)).filter(p => !isNaN(p) && p > 0);
			if (prices.length === 0) {
				// No products with prices, disable price filter
				document.getElementById('minPriceSlider').disabled = true;
				document.getElementById('maxPriceSlider').disabled = true;
				return;
			}
			
			const minPrice = Math.floor(Math.min(...prices));
			const maxPrice = Math.ceil(Math.max(...prices));
			
			// Update slider ranges
			document.getElementById('minPriceSlider').min = minPrice;
			document.getElementById('minPriceSlider').max = maxPrice;
			document.getElementById('maxPriceSlider').min = minPrice;
			document.getElementById('maxPriceSlider').max = maxPrice;
			
			// Set initial values to full range
			document.getElementById('minPriceSlider').value = minPrice;
			document.getElementById('maxPriceSlider').value = maxPrice;
			document.getElementById('minPriceInput').value = minPrice;
			document.getElementById('maxPriceInput').value = maxPrice;
			document.getElementById('minPriceDisplay').textContent = '<?= $settings['currency'] ?? 'USD' ?>' + minPrice;
			document.getElementById('maxPriceDisplay').textContent = '<?= $settings['currency'] ?? 'USD' ?>' + maxPrice;
		}
		
		function handlePriceFilter() {
			const minSlider = document.getElementById('minPriceSlider');
			const maxSlider = document.getElementById('maxPriceSlider');
			const minValue = parseInt(minSlider.value);
			const maxValue = parseInt(maxSlider.value);
			
			// Update displays
			document.getElementById('minPriceInput').value = minValue;
			document.getElementById('maxPriceInput').value = maxValue;
			document.getElementById('minPriceDisplay').textContent = '<?= $settings['currency'] ?? 'USD' ?>' + minValue;
			document.getElementById('maxPriceDisplay').textContent = '<?= $settings['currency'] ?? 'USD' ?>' + maxValue;
			
			// Set price filter
			const prices = allProducts.map(p => parseFloat(p.price)).filter(p => !isNaN(p) && p > 0);
			if (prices.length === 0) {
				// No products with prices, keep filter as 'all'
				currentFilters.price = 'all';
				renderProducts();
				renderBadges();
				return;
			}
			const fullMinPrice = Math.floor(Math.min(...prices));
			const fullMaxPrice = Math.ceil(Math.max(...prices));
			
			if (minValue > fullMinPrice || maxValue < fullMaxPrice) {
				currentFilters.price = `${minValue}-${maxValue}`;
			} else {
				currentFilters.price = 'all';
			}
			
			renderProducts();
			renderBadges();
		}
		
		function renderProducts() {
			const filteredProducts = allProducts.filter(product => {
				// Category filter (handled by page redirect)
				if (currentFilters.category !== 'all' && product.product_category != currentFilters.category) {
					return false;
				}
				
				// Price filter
				if (currentFilters.price !== 'all') {
					const [minPrice, maxPrice] = currentFilters.price.split('-').map(Number);
					const productPrice = parseFloat(product.price) || 0;
					if (productPrice < minPrice || productPrice > maxPrice) {
						return false;
					}
				}
				
				return true;
			});
			
			// Update display
			const productsGrid = document.querySelector('.products-grid');
			if (productsGrid) {
				productsGrid.innerHTML = '';
				filteredProducts.forEach(product => {
					const productCard = createProductCard(product);
					productsGrid.appendChild(productCard);
				});
			}
		}
		
		function renderBadges() {
			const badgesContainer = document.getElementById('badges-container');
			if (!badgesContainer) return;
			
			badgesContainer.innerHTML = '';
			
			if (currentFilters.price !== 'all') {
				const badge = document.createElement('span');
				badge.className = 'badge';
				badge.innerHTML = `Price: ${currentFilters.price} <i class="fa fa-times"></i>`;
				badge.setAttribute('data-filter-key', 'price');
				badge.setAttribute('data-filter-value', currentFilters.price);
				badgesContainer.appendChild(badge);
			}
		}
		
			function createProductCard(product) {
				const card = document.createElement('div');
				card.className = 'product-card';
				
				const imageUrl = product.image_post ? 
					'<?= base_url() ?>' + product.image_post : 
					'<?= base_url('assets/frontend/images/no-image.png') ?>';
				
				const price = product.sale_price ? product.sale_price : product.price;
				const originalPrice = product.sale_price ? product.price : null;
				
				card.innerHTML = `
					<div class="product-image-container">
						<img src="${imageUrl}" alt="${product.product_name}" class="product-image">
						<div class="product-overlay">
							<a href="<?= base_url('product/') ?>${product.slug}" class="view-details-btn">
								<i class="fa fa-eye"></i> View Details
							</a>
						</div>
						${product.sale_price ? '<div class="product-badge">Sale</div>' : ''}
						${product.featured == '1' ? '<div class="product-badge featured">Featured</div>' : ''}
					</div>
					<div class="product-info">
						<h5 class="product-name">
							<a href="<?= base_url('product/') ?>${product.slug}">${product.product_name}</a>
						</h5>
						<div class="product-price">
							${originalPrice ? `<span class="original-price">PHP ${originalPrice}</span>` : ''}
							<span class="currency-symbol">PHP</span>
							<span class="price-value">${price}</span>
						</div>
						<div class="product-category">
							<span class="category-tag">${product.category_name || 'Uncategorized'}</span>
						</div>
					</div>
				`;
				
				return card;
			}
			
			// Badge click handler
			document.getElementById('badges-container').addEventListener('click', function(e) {
				const badge = e.target.closest('.badge');
				if (badge) {
					const key = badge.getAttribute('data-filter-key');
					if (key === 'price') {
						// Reset price sliders
						const prices = allProducts.map(p => parseFloat(p.price));
						const minPrice = Math.floor(Math.min(...prices));
						const maxPrice = Math.ceil(Math.max(...prices));
						
						document.getElementById('minPriceSlider').value = minPrice;
						document.getElementById('maxPriceSlider').value = maxPrice;
						document.getElementById('minPriceInput').value = minPrice;
						document.getElementById('maxPriceInput').value = maxPrice;
						
						currentFilters.price = 'all';
						renderProducts();
						renderBadges();
					}
				}
			});
		});
	</script>

	<!-- CSS for better category option styling -->
	<style>
	.category-option {
		margin-bottom: 8px;
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.category-option label {
		font-size: 14px;
		color: #555;
		cursor: pointer;
		margin: 0;
	}

	.category-option input[type="radio"] {
		margin: 0;
		width: 16px;
		height: 16px;
	}

	.filter-card {
		background: white;
		border-radius: 12px;
		padding: 20px;
		box-shadow: 0 2px 8px rgba(0,0,0,0.1);
		margin-bottom: 20px;
	}

	.filter-card h6 {
		margin: 0 0 15px 0;
		color: #333;
		font-weight: 600;
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.price-filter-container {
		display: flex;
		flex-direction: column;
		gap: 15px;
	}

	.price-range-display {
		display: flex;
		justify-content: space-between;
		font-size: 14px;
		color: #666;
	}

	.price-slider-container {
		position: relative;
		height: 20px;
	}

	.price-slider-track {
		position: absolute;
		top: 50%;
		left: 0;
		right: 0;
		height: 4px;
		background: #ddd;
		border-radius: 2px;
		transform: translateY(-50%);
	}

	.price-slider-fill {
		position: absolute;
		top: 0;
		height: 100%;
		background: #2196F3;
		border-radius: 2px;
	}

	.price-slider {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		width: 100%;
		height: 20px;
		background: transparent;
		outline: none;
		-webkit-appearance: none;
		appearance: none;
	}

	.price-slider::-webkit-slider-thumb {
		-webkit-appearance: none;
		appearance: none;
		width: 20px;
		height: 20px;
		background: #2196F3;
		border-radius: 50%;
		cursor: pointer;
		box-shadow: 0 2px 4px rgba(0,0,0,0.2);
	}

	.price-slider::-moz-range-thumb {
		width: 20px;
		height: 20px;
		background: #2196F3;
		border-radius: 50%;
		cursor: pointer;
		border: none;
		box-shadow: 0 2px 4px rgba(0,0,0,0.2);
	}

	.price-inputs {
		display: flex;
		gap: 10px;
	}

	.price-input {
		flex: 1;
		padding: 8px 12px;
		border: 1px solid #ddd;
		border-radius: 6px;
		font-size: 14px;
	}

	.badge {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		background: #2196F3;
		color: white;
		padding: 6px 12px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.3s ease;
	}

	.badge:hover {
		background: #1976D2;
		transform: scale(1.05);
	}

	.badge i {
		font-size: 10px;
	}
	</style>

	<!-- footer -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div class="footer-content">
						<p>&copy; <?= date('Y') ?> <?= $settings['store_name'] ?? 'Our Store' ?>. All rights reserved.</p>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- end footer -->

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
			gap: 20px;
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
			transition: color 0.3s ease;
		}

		.nav-link:hover {
			color: #2196F3;
		}

		.search-icon-nav {
			color: #333;
			font-size: 18px;
			text-decoration: none;
			transition: color 0.3s ease;
		}

		.search-icon-nav:hover {
			color: #2196F3;
		}

		.mobile-menu-toggle {
			display: none;
			flex-direction: column;
			background: none;
			border: none;
			cursor: pointer;
			padding: 5px;
		}

		.mobile-menu-toggle span {
			width: 25px;
			height: 3px;
			background: #333;
			margin: 3px 0;
			transition: 0.3s;
		}

		@media (max-width: 768px) {
			.nav-list {
				display: none;
			}

			.mobile-menu-toggle {
				display: flex;
			}

			.nav-menu {
				gap: 10px;
			}
		}
	</style>

	<!-- Navigation Menu JavaScript -->
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const mobileMenuToggle = document.getElementById('mobileMenuToggle');
			const slideOut = document.getElementById('slide-out');
			
			if (mobileMenuToggle && slideOut) {
				mobileMenuToggle.addEventListener('click', function() {
					slideOut.classList.toggle('active');
				});
			}
		});
	</script>

</body>
</html>
