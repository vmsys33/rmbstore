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
									<span class="price-label">Min: <span id="minPriceDisplay">$0</span></span>
									<span class="price-label">Max: <span id="maxPriceDisplay">$1000</span></span>
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
								<img src="<?= base_url($product['featured_image'] ?? $product['image_icon'] ?? 'assets/frontend/images/product1.jpg') ?>" 
									 alt="<?= esc($product['product_name']) ?>"
									 class="product-image">
								<div class="product-overlay">
									<a href="<?= base_url('product/' . $product['id']) ?>" class="view-details-btn">
										<i class="fa fa-eye"></i> View Details
									</a>
								</div>
							</div>
							<div class="product-info">
								<h5 class="product-name">
									<a href="<?= base_url('product/' . $product['id']) ?>"><?= esc($product['product_name']) ?></a>
								</h5>
								<div class="product-price">
									<span class="currency-symbol"><?= $settings['currency'] ?? 'USD' ?></span>
									<span class="price-value"><?= number_format($product['price'], 2) ?></span>
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
		// Global products array for search functionality
		let products = [];
		let allProducts = [];
		let currentFilters = {
			category: 'all',
			price: 'all'
		};
		
		// DOM elements
		const productsContainer = document.getElementById('productsGrid');
		const badgesContainer = document.getElementById('badges-container');
		const productCountElement = document.getElementById('product-count');
		
		// Global error handler
		window.addEventListener('error', function(e) {
			console.error('❌ JavaScript Error:', e.error);
			
		});
		
		// Load products when page loads
		document.addEventListener('DOMContentLoaded', function() {
			console.log('🚀 DOM Content Loaded');
			
			// Load products from the page data
			<?php if (!empty($products)): ?>
				allProducts = <?= json_encode($products) ?>;
				products = [...allProducts];
				console.log('📦 Loaded', products.length, 'products for search');
				
				// Initialize price range
				initializePriceRange();
				// Initialize filters
				initializeFilters();
				// Initial render
				renderProducts();
				renderBadges();
			<?php else: ?>
				console.log('⚠️ No products loaded for search');
			<?php endif; ?>
		});
		
		// Initialize price range based on actual product prices
		function initializePriceRange() {
			if (allProducts.length === 0) return;
			
			const prices = allProducts.map(p => parseFloat(p.price));
			const minPrice = Math.floor(Math.min(...prices));
			const maxPrice = Math.ceil(Math.max(...prices));
			
			console.log('💰 Price range:', minPrice, 'to', maxPrice);
			
			// Update slider ranges
			document.getElementById('minPriceSlider').min = minPrice;
			document.getElementById('minPriceSlider').max = maxPrice;
			document.getElementById('maxPriceSlider').min = minPrice;
			document.getElementById('maxPriceSlider').max = maxPrice;
			
			// Set initial values to full range
			document.getElementById('minPriceSlider').value = minPrice;
			document.getElementById('maxPriceSlider').value = maxPrice;
			
			// Update displays
			updatePriceDisplays(minPrice, maxPrice);
			updatePriceSliderFill(minPrice, maxPrice);
			
			// Update input fields to match initial values
			document.getElementById('minPriceInput').value = minPrice;
			document.getElementById('maxPriceInput').value = maxPrice;
		}
		
		// Initialize filter event listeners
		function initializeFilters() {
			console.log('🔧 initializeFilters called');
			
			// Category radio buttons - use event delegation
			document.querySelector('.category-filters').addEventListener('change', function(e) {
				if (e.target.classList.contains('category-radio')) {
					handleCategoryFilter(e);
				}
			});
			
			// Price sliders
			document.getElementById('minPriceSlider').addEventListener('input', handlePriceFilter);
			document.getElementById('maxPriceSlider').addEventListener('input', handlePriceFilter);
			
			// Price inputs
			document.getElementById('minPriceInput').addEventListener('input', handlePriceInput);
			document.getElementById('maxPriceInput').addEventListener('input', handlePriceInput);
			
			// Add event listener to the badges container for removing filters
			badgesContainer.addEventListener('click', (e) => {
				// Find the parent badge element
				const badge = e.target.closest('.badge');
				if (badge) {
					const key = badge.getAttribute('data-filter-key');
					const value = badge.getAttribute('data-filter-value');
					
					// Reset the filter and corresponding radio button
					currentFilters[key] = 'all';
					
					// Reset category radio button if it's a category filter
					if (key === 'category') {
						document.querySelector('.category-radio[value="all"]').checked = true;
						// Redirect to products page without category filter
						window.location.href = '<?= base_url('products') ?>';
						return;
					}
					
					// Reset price filter if it's a price filter
					if (key === 'price') {
						// Reset price sliders to full range
						const minSlider = document.getElementById('minPriceSlider');
						const maxSlider = document.getElementById('maxPriceSlider');
						const prices = allProducts.map(p => parseFloat(p.price));
						const minPrice = Math.floor(Math.min(...prices));
						const maxPrice = Math.ceil(Math.max(...prices));
						
						minSlider.value = minPrice;
						maxSlider.value = maxPrice;
						document.getElementById('minPriceInput').value = minPrice;
						document.getElementById('maxPriceInput').value = maxPrice;
						updatePriceDisplays(minPrice, maxPrice);
					}

					// Remove the badge from the DOM with a transition
					badge.classList.add('opacity-0', 'scale-0');
					setTimeout(() => {
						badge.remove();
						// Re-render the products after the badge is removed
						renderProducts();
						renderBadges();
					}, 300);
				}
			});
		}
		
		// Handle category filter changes
		function handleCategoryFilter(e) {
			console.log('🎯 Category filter changed:', e.target.value);
			const value = e.target.value;
			
			// If "All Categories" is selected, redirect to products page without category
			if (value === 'all') {
				window.location.href = '<?= base_url('products') ?>';
				return;
			}
			
			// Redirect to products page with category parameter
			window.location.href = '<?= base_url('products') ?>?category=' + value;
		}
		
		// Handle price filter changes
		function handlePriceFilter(e) {
			const minSlider = document.getElementById('minPriceSlider');
			const maxSlider = document.getElementById('maxPriceSlider');
			
			let minValue = parseInt(minSlider.value);
			let maxValue = parseInt(maxSlider.value);
			
			// Ensure min doesn't exceed max
			if (minValue > maxValue) {
				if (e.target === minSlider) {
					minValue = maxValue;
					minSlider.value = minValue;
				} else {
					maxValue = minValue;
					maxSlider.value = maxValue;
				}
			}
			
			updatePriceDisplays(minValue, maxValue);
			updatePriceSliderFill(minValue, maxValue);
			
			// Update input fields
			document.getElementById('minPriceInput').value = minValue;
			document.getElementById('maxPriceInput').value = maxValue;
			
			// Check if price range is filtered (not at full range)
			const prices = allProducts.map(p => parseFloat(p.price));
			const fullMinPrice = Math.floor(Math.min(...prices));
			const fullMaxPrice = Math.ceil(Math.max(...prices));
			
			if (minValue > fullMinPrice || maxValue < fullMaxPrice) {
				currentFilters.price = `${minValue}-${maxValue}`;
			} else {
				currentFilters.price = 'all';
			}
			
			renderBadges();
			renderProducts();
		}
		
		// Handle price input changes
		function handlePriceInput(e) {
			const minInput = document.getElementById('minPriceInput');
			const maxInput = document.getElementById('maxPriceInput');
			const minSlider = document.getElementById('minPriceSlider');
			const maxSlider = document.getElementById('maxPriceSlider');
			
			let minValue = parseInt(minInput.value) || 0;
			let maxValue = parseInt(maxInput.value) || 1000;
			
			// Ensure min doesn't exceed max
			if (minValue > maxValue) {
				if (e.target === minInput) {
					minValue = maxValue;
					minInput.value = minValue;
				} else {
					maxValue = minValue;
					maxInput.value = maxValue;
				}
			}
			
			// Update sliders
			minSlider.value = minValue;
			maxSlider.value = maxValue;
			
			updatePriceDisplays(minValue, maxValue);
			updatePriceSliderFill(minValue, maxValue);
			
			// Check if price range is filtered (not at full range)
			const prices = allProducts.map(p => parseFloat(p.price));
			const fullMinPrice = Math.floor(Math.min(...prices));
			const fullMaxPrice = Math.ceil(Math.max(...prices));
			
			if (minValue > fullMinPrice || maxValue < fullMaxPrice) {
				currentFilters.price = `${minValue}-${maxValue}`;
			} else {
				currentFilters.price = 'all';
			}
			
			renderBadges();
			renderProducts();
		}
		
		// Update price displays
		function updatePriceDisplays(minPrice, maxPrice) {
			const currencySymbol = '<?= $settings['currency'] ?? 'USD' ?>';
			document.getElementById('minPriceDisplay').textContent = currencySymbol + minPrice;
			document.getElementById('maxPriceDisplay').textContent = currencySymbol + maxPrice;
		}
		
		// Update price slider fill
		function updatePriceSliderFill(minPrice, maxPrice) {
			const minSlider = document.getElementById('minPriceSlider');
			const maxSlider = document.getElementById('maxPriceSlider');
			const fill = document.getElementById('priceSliderFill');
			
			const minPercent = ((minPrice - minSlider.min) / (minSlider.max - minSlider.min)) * 100;
			const maxPercent = ((maxPrice - minSlider.min) / (minSlider.max - minSlider.min)) * 100;
			
			fill.style.left = minPercent + '%';
			fill.style.width = (maxPercent - minPercent) + '%';
		}
		
		// Function to filter and render products
		function renderProducts() {
			console.log('🔄 renderProducts called with filters:', currentFilters);
			// Filter products based on active filters
			const filteredProducts = allProducts.filter(product => {
				// Check category filter
				const categoryMatch = currentFilters.category === 'all' || product.product_category == currentFilters.category;

				// Check price filter
				const priceMatch = currentFilters.price === 'all' || (() => {
					const [min, max] = currentFilters.price.split('-').map(Number);
					return product.price >= min && product.price <= max;
				})();

				return categoryMatch && priceMatch;
			});

			// Update the product count
			productCountElement.textContent = `(${filteredProducts.length} items)`;

			// Update products array
			products = filteredProducts;
			
			// Update display
			updateProductsDisplay();
		}
		
		// Function to render the filter badges
		function renderBadges() {
			console.log('🏷️ renderBadges called with filters:', currentFilters);
			// Clear the badges container
			badgesContainer.innerHTML = '';

			// Render category badge if a filter is active
			if (currentFilters.category !== 'all') {
				const badge = document.createElement('div');
				badge.className = 'badge bg-blue-500 text-white px-4 py-2 rounded-full cursor-pointer flex items-center gap-2 transform hover:scale-105 hover:bg-blue-600 transition-all duration-200';
				badge.setAttribute('data-filter-key', 'category');
				badge.setAttribute('data-filter-value', currentFilters.category);
				badge.title = 'Click to remove this filter';
				
				// Get category name
				const categoryName = document.querySelector(`.category-radio[value="${currentFilters.category}"] + label`).textContent;
				
				badge.innerHTML = `
					<span>Category: ${categoryName}</span>
					<span class="font-bold text-lg leading-none hover:text-gray-300 transition-colors">&times;</span>
				`;
				badgesContainer.appendChild(badge);
			}

			// Render price badge if a filter is active
			if (currentFilters.price !== 'all') {
				const badge = document.createElement('div');
				badge.className = 'badge bg-green-500 text-white px-4 py-2 rounded-full cursor-pointer flex items-center gap-2 transform hover:scale-105 hover:bg-green-600 transition-all duration-200';
				badge.setAttribute('data-filter-key', 'price');
				badge.setAttribute('data-filter-value', currentFilters.price);
				badge.title = 'Click to remove this filter';
				
				const [min, max] = currentFilters.price.split('-').map(Number);
				const currencySymbol = '<?= $settings['currency'] ?? 'USD' ?>';
				
				badge.innerHTML = `
					<span>Price: ${currencySymbol}${min} - ${currencySymbol}${max}</span>
					<span class="font-bold text-lg leading-none hover:text-gray-300 transition-colors">&times;</span>
				`;
				badgesContainer.appendChild(badge);
			}
		}
		
		// Update products display
		function updateProductsDisplay() {
			const grid = document.getElementById('productsGrid');
			const productCards = grid.querySelectorAll('.product-card');
			
			productCards.forEach(card => {
				const productCategory = card.getAttribute('data-category');
				const productPrice = parseFloat(card.getAttribute('data-price'));
				
				// Check category filter
				const categoryMatch = currentFilters.category === 'all' || productCategory == currentFilters.category;
				
				// Check price filter
				const priceMatch = currentFilters.price === 'all' || (() => {
					const [min, max] = currentFilters.price.split('-').map(Number);
					return productPrice >= min && productPrice <= max;
				})();
				
				if (categoryMatch && priceMatch) {
					card.style.display = 'block';
					card.style.animation = 'fadeIn 0.3s ease-in';
				} else {
					card.style.display = 'none';
				}
			});
		}
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

	.category-radio {
		margin: 0;
		width: 16px;
		height: 16px;
		accent-color: #667eea;
	}

	/* Pill Badge Hover Effects */
	.category-pill-badge {
		transition: all 0.3s ease;
		cursor: default;
	}

	.category-pill-badge:hover {
		transform: translateY(-2px);
		box-shadow: 0 6px 20px rgba(33, 150, 243, 0.4);
	}

	.pill-close-btn {
		transition: all 0.3s ease;
	}

	.pill-close-btn:hover {
		transform: scale(1.1) rotate(90deg);
		box-shadow: 0 6px 20px rgba(255, 87, 34, 0.4);
		background: linear-gradient(135deg, #E64A19, #D84315);
	}

	/* Product Count Badge Styling */
	.product-count-badge {
		transition: all 0.3s ease;
		cursor: default;
	}

	.product-count-badge:hover {
		transform: translateY(-1px);
		box-shadow: 0 3px 10px rgba(33, 150, 243, 0.2);
		background: #F3E5F5;
		border-color: #9C27B0;
		color: #7B1FA2;
	}
	</style>

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
