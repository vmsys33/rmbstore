$(function() {
    'use strict';

    // preloader
    $(".preloader").fadeOut();

    // Mobile Menu Toggle
    $('#mobileMenuToggle').on('click', function() {
        $('.nav-list').toggleClass('active');
        $(this).toggleClass('active');
    });

    // Close mobile menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.nav-menu').length) {
            $('.nav-list').removeClass('active');
            $('#mobileMenuToggle').removeClass('active');
        }
    });

    // Close mobile menu when clicking on a link
    $('.nav-link').on('click', function() {
        $('.nav-list').removeClass('active');
        $('#mobileMenuToggle').removeClass('active');
    });

    // sidebar
    $('.sidebar').sideNav({
        edge: 'left'
    });

    // sidebar search
    $('.sidebar-search').sideNav({
        edge: 'right'
    });

    // sidebar search
    $('.sidebar-cart').sideNav({
        edge: 'right'
    });

    // Initialize modals
    $('.modal').modal();
    
    // Debug modal initialization
    console.log('🔧 Modal initialization:', $('.modal').length, 'modals found');
    console.log('🔧 Search modal found:', $('#searchModal').length > 0);
    
    // Test modal trigger
    $('.search-icon-nav').on('click', function(e) {
        console.log('🔍 Search icon clicked!');
        e.preventDefault();
        $('#searchModal').modal('open');
    });

    // navbar on scroll
    $(window).on('scroll', function() {

        if ($(document).scrollTop() > 50) {

            $(".navbar").css({
                "box-shadow": "rgba(0, 0, 0, 0.18) 0px 0px 16px"
            });

        } else {

            $(".navbar").css({
                "box-shadow": "none"
            });

        }

    });

    // slider
    $(".slide-show").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        singleItem: true,
        loop: true,
        margin: 10,
        autoplay: false
    });

    // product-slide
    $(".product-slide").owlCarousel({
        stagePadding: 20,
        loop: false,
        margin: 10,
        items: 2,
        dots: false
    });

    // product-slide
    $(".product-slide-two").owlCarousel({
        stagePadding: 20,
        loop: false,
        margin: 10,
        items: 2,
        dots: false
    });

    // product-d-slide
    $(".product-d-slide").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        loop: false,
        margin: 10,
    });

    // tabs
    $('ul.tabs').tabs();

    // collapse
    $('.collapsible').collapsible();

    // testimonial
    $(".testimonial").owlCarousel({
        items: 1,
        loop: false
    })

    // Product Search Functionality
    initProductSearch();

    // Product Search with Autosuggest - Clean and Simple
    function initProductSearch() {
        console.log('🔍 Initializing product search...');
        
        const searchInput = document.getElementById('headerProductSearch');
        const suggestions = document.getElementById('searchSuggestions');
        
        console.log('🔍 Search elements found:', { 
            searchInput: !!searchInput, 
            suggestions: !!suggestions 
        });
        
        if (!searchInput || !suggestions) {
            console.log('❌ Search elements not found:', { searchInput, suggestions });
            return;
        }

        console.log('✅ All search elements found, setting up event listeners...');

        // Add input event listener for real-time search with debouncing
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            console.log('🔍 Input event triggered, value:', query);
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            if (query.length < 2) {
                console.log('🔍 Query too short, hiding suggestions');
                hideSuggestions();
                return;
            }
            
            // Debounce search to avoid excessive processing
            searchTimeout = setTimeout(() => {
                console.log('🔍 Processing search for query:', query);
                console.log('🔍 Available products:', products);
                
                // Advanced search algorithm with fuzzy matching
                const filteredProducts = searchProducts(query, products);
                
                console.log('🔍 Found', filteredProducts.length, 'matching products:', filteredProducts);
                
                if (filteredProducts.length > 0) {
                    showSuggestions(filteredProducts);
                } else {
                    // Show "no results" message
                    showNoResults(query);
                }
            }, 150); // 150ms delay for better performance
        });

        // Add blur event listener
        searchInput.addEventListener('blur', function() {
            console.log('🔍 Blur event triggered, hiding suggestions in 200ms');
            setTimeout(hideSuggestions, 200);
        });

        console.log('✅ Product search initialized successfully');
    }

    // Show no results message
    function showNoResults(query) {
        const suggestions = document.getElementById('searchSuggestions');
        if (!suggestions) return;
        
        suggestions.innerHTML = `
            <div class="no-results">
                <div class="no-results-icon">
                    <i class="fa fa-search"></i>
                </div>
                <div class="no-results-text">
                    <p>No products found for "<strong>${query}</strong>"</p>
                    <p class="suggestion">Try different keywords or check spelling</p>
                </div>
            </div>
        `;
        suggestions.classList.remove('hidden');
    }

    // Advanced search algorithm with fuzzy matching, scoring, and relevance detection
    function searchProducts(query, products) {
        if (!query || query.length < 2) return [];
        
        const searchTerms = query.toLowerCase().split(' ').filter(term => term.length > 0);
        const results = [];
        
        products.forEach(product => {
            let score = 0;
            const productName = (product.product_name || '').toLowerCase();
            const categoryName = (product.category_name || '').toLowerCase();
            const description = (product.description || '').toLowerCase();
            const shortDescription = (product.short_description || '').toLowerCase();
            
            // Calculate Levenshtein distance for fuzzy matching
            const calculateSimilarity = (str1, str2) => {
                if (str1 === str2) return 1;
                if (str1.length === 0) return 0;
                if (str2.length === 0) return 0;
                
                const matrix = [];
                for (let i = 0; i <= str2.length; i++) {
                    matrix[i] = [i];
                }
                for (let j = 0; j <= str1.length; j++) {
                    matrix[0][j] = j;
                }
                
                for (let i = 1; i <= str2.length; i++) {
                    for (let j = 1; j <= str1.length; j++) {
                        if (str2.charAt(i - 1) === str1.charAt(j - 1)) {
                            matrix[i][j] = matrix[i - 1][j - 1];
                        } else {
                            matrix[i][j] = Math.min(
                                matrix[i - 1][j - 1] + 1,
                                matrix[i][j - 1] + 1,
                                matrix[i - 1][j] + 1
                            );
                        }
                    }
                }
                
                return 1 - (matrix[str2.length][str1.length] / Math.max(str1.length, str2.length));
            };
            
            // Perfect exact match (highest priority)
            if (productName === query.toLowerCase()) {
                score += 10000;
            }
            
            // Product name starts with query
            if (productName.startsWith(query.toLowerCase())) {
                score += 5000;
            }
            
            // Product name contains query
            if (productName.includes(query.toLowerCase())) {
                score += 3000;
            }
            
            // Category name matches
            if (categoryName.includes(query.toLowerCase())) {
                score += 2000;
            }
            
            // All search terms found in product name (very high priority)
            const allTermsInName = searchTerms.every(term => productName.includes(term));
            if (allTermsInName) {
                score += 4000;
            }
            
            // Most search terms found in product name (high priority)
            const termsInName = searchTerms.filter(term => productName.includes(term)).length;
            if (termsInName > 0) {
                score += (termsInName / searchTerms.length) * 3000;
            }
            
            // Search terms found in category
            const termsInCategory = searchTerms.filter(term => categoryName.includes(term)).length;
            if (termsInCategory > 0) {
                score += (termsInCategory / searchTerms.length) * 1500;
            }
            
            // Search terms found in descriptions
            const termsInDescription = searchTerms.filter(term => 
                description.includes(term) || shortDescription.includes(term)
            ).length;
            if (termsInDescription > 0) {
                score += (termsInDescription / searchTerms.length) * 800;
            }
            
            // Fuzzy matching for typos and similar words
            searchTerms.forEach(term => {
                if (term.length >= 3) {
                    // Check product name words
                    const productWords = productName.split(/\s+/);
                    productWords.forEach(word => {
                        if (word.length >= 3) {
                            const similarity = calculateSimilarity(word, term);
                            if (similarity > 0.7) { // 70% similarity threshold
                                score += similarity * 500;
                            }
                        }
                    });
                    
                    // Check category name
                    if (categoryName.length >= 3) {
                        const categorySimilarity = calculateSimilarity(categoryName, term);
                        if (categorySimilarity > 0.7) {
                            score += categorySimilarity * 300;
                        }
                    }
                }
            });
            
            // Word boundary matching (better than simple includes)
            searchTerms.forEach(term => {
                const wordBoundaryRegex = new RegExp(`\\b${term}`, 'i');
                if (wordBoundaryRegex.test(productName)) {
                    score += 200;
                }
                if (wordBoundaryRegex.test(categoryName)) {
                    score += 100;
                }
            });
            
            // Acronym matching (e.g., "mac" matches "MacBook")
            searchTerms.forEach(term => {
                if (term.length >= 2) {
                    const productAcronym = productName.split(/\s+/).map(word => word.charAt(0)).join('').toLowerCase();
                    if (productAcronym.includes(term)) {
                        score += 150;
                    }
                }
            });
            
            // Length bonus for shorter, more specific matches
            if (productName.length <= query.length + 10) {
                score += 100;
            }
            
            // Only include products with meaningful scores
            if (score > 100) {
                results.push({ ...product, searchScore: score });
            }
        });
        
        // Sort by score (highest first) and return top results
        return results
            .sort((a, b) => b.searchScore - a.searchScore)
            .slice(0, 15) // Increased to 15 results for better coverage
            .map(product => {
                const { searchScore, ...cleanProduct } = product;
                return cleanProduct;
            });
    }

    // Show suggestions with improved display and relevance indicators
    function showSuggestions(products) {
        const suggestions = document.getElementById('searchSuggestions');
        if (!suggestions) return;

        if (products.length === 0) {
            console.log('🔍 No products found, hiding suggestions');
            hideSuggestions();
            return;
        }
        
        console.log('🔍 Showing suggestions for', products.length, 'products');
        
        // Add search summary
        let html = `
            <div class="search-summary">
                <span class="results-count">${products.length} product${products.length !== 1 ? 's' : ''} found</span>
                <span class="search-tip">Click on a product to view details</span>
            </div>
        `;
        
        // Generate product suggestions with relevance indicators
        html += products.map((product, index) => {
            // Get product image (use image_post or fallback to default)
            let imageUrl = '';
            if (product.image_post) {
                imageUrl = product.image_post.startsWith('uploads/') ? 
                    '/' + product.image_post : 
                    '/uploads/products/posts/' + product.image_post;
            } else {
                imageUrl = '/assets/frontend/images/product1.jpg';
            }
            
            // Format price
            const price = product.sale_price || product.price;
            const formattedPrice = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(price);

            // Add relevance indicators for top results
            const isTopResult = index < 3;
            const relevanceClass = isTopResult ? 'top-result' : '';
            const relevanceBadge = isTopResult ? '<div class="relevance-badge">★ Best Match</div>' : '';

            return '<div class="search-suggestion-item ' + relevanceClass + '" onclick="goToProduct(' + product.id + ')">' +
                '<div class="suggestion-image-container">' +
                    '<img src="' + imageUrl + '" alt="' + product.product_name + '" class="search-suggestion-image" onerror="this.src=\'/assets/frontend/images/product1.jpg\'">' +
                    relevanceBadge +
                '</div>' +
                '<div class="search-suggestion-content">' +
                    '<div class="search-suggestion-title">' + product.product_name + '</div>' +
                    '<div class="search-suggestion-price">' + formattedPrice + '</div>' +
                    '<div class="search-suggestion-category">' + (product.category_name || 'General') + '</div>' +
                '</div>' +
                '<div class="suggestion-arrow">' +
                    '<i class="fa fa-chevron-right"></i>' +
                '</div>' +
            '</div>';
        }).join('');

        suggestions.innerHTML = html;
        suggestions.classList.remove('hidden');
        console.log('🔍 Suggestions displayed with improved formatting');
    }

    // Hide suggestions - EXACT COPY from POS
    function hideSuggestions() {
        const suggestions = document.getElementById('searchSuggestions');
        if (!suggestions) return;

        suggestions.classList.add('hidden');
        console.log('🔍 Suggestions hidden');
    }

    // Navigate to product page
    function goToProduct(productId) {
        console.log('🔍 Navigating to product:', productId);
        hideSuggestions();
        window.location.href = `/product/${productId}`;
    }

    // Make goToProduct globally accessible for onclick attributes
    window.goToProduct = goToProduct;

    // Modal-specific functionality
    $(document).ready(function() {
        // Handle modal close button
        $('.modal-close').on('click', function() {
            $('#searchModal').modal('close');
        });

        // Focus on search input when modal opens
        $('#searchModal').on('modal:opened', function() {
            setTimeout(function() {
                $('#headerProductSearch').focus();
            }, 300);
        });

        // Clear search when modal closes
        $('#searchModal').on('modal:closed', function() {
            $('#headerProductSearch').value = '';
            hideSuggestions();
        });
    });

});