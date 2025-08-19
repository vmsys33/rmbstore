<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 
// Frontend Routes
$routes->get('/', 'FrontendController::index', ['as' => 'frontend.home']);
$routes->get('products', 'FrontendController::products', ['as' => 'frontend.products']);
$routes->get('product/(:num)', 'FrontendController::product/$1', ['as' => 'frontend.product']);
$routes->get('category/(:num)', 'FrontendController::category/$1', ['as' => 'frontend.category']);
$routes->get('about', 'FrontendController::about', ['as' => 'frontend.about']);
$routes->get('contact', 'FrontendController::contact', ['as' => 'frontend.contact']);

// POS Route (Direct access)
// $routes->get('pos', 'PosController::index', ['as' => 'pos.direct']);

// Admin Authentication Routes
$routes->group('admin', function($routes) {
    $routes->get('login', 'AdminAuthController::login', ['as' => 'admin.login']);
    $routes->post('login', 'AdminAuthController::authenticate', ['as' => 'admin.authenticate']);
    $routes->get('logout', 'AdminAuthController::logout', ['as' => 'admin.logout']);
    $routes->get('forgot-password', 'AdminAuthController::forgotPassword', ['as' => 'admin.forgotPassword']);
    $routes->post('forgot-password', 'AdminAuthController::sendResetLink', ['as' => 'admin.sendResetLink']);
    $routes->get('reset-password/(:any)', 'AdminAuthController::resetPassword/$1', ['as' => 'admin.resetPassword']);
    $routes->post('reset-password', 'AdminAuthController::updatePassword', ['as' => 'admin.updatePassword']);
});

// Admin Routes (Protected)
$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
    $routes->get('/', 'HomeController::index', ['as' => 'admin.home']);
    $routes->get('dashboard', 'HomeController::index', ['as' => 'admin.dashboard']);
    $routes->get('index2', 'HomeController::index2', ['as' => 'index2']);
    $routes->get('index3', 'HomeController::index3', ['as' => 'index3']);
    $routes->get('index4', 'HomeController::index4', ['as' => 'index4']);
    
    // Products Management Routes
    $routes->get('products', 'ProductsController::index', ['as' => 'products']);
    $routes->get('products/create', 'ProductsController::create', ['as' => 'products.create']);
    $routes->post('products/store', 'ProductsController::store', ['as' => 'products.store']);
    $routes->get('products/view/(:num)', 'ProductsController::view/$1', ['as' => 'products.view']);
    $routes->get('products/edit/(:num)', 'ProductsController::edit/$1', ['as' => 'products.edit']);
    $routes->post('products/update/(:num)', 'ProductsController::update/$1', ['as' => 'products.update']);
    $routes->get('products/delete/(:num)', 'ProductsController::delete/$1', ['as' => 'products.delete']);
    
    // Categories Management Routes
    $routes->get('categories', 'CategoriesController::index', ['as' => 'categories']);
    $routes->get('categories/create', 'CategoriesController::create', ['as' => 'categories.create']);
    $routes->post('categories/store', 'CategoriesController::store', ['as' => 'categories.store']);
    $routes->get('categories/view/(:num)', 'CategoriesController::view/$1', ['as' => 'categories.view']);
    $routes->get('categories/edit/(:num)', 'CategoriesController::edit/$1', ['as' => 'categories.edit']);
    $routes->post('categories/update/(:num)', 'CategoriesController::update/$1', ['as' => 'categories.update']);
    $routes->get('categories/delete/(:num)', 'CategoriesController::delete/$1', ['as' => 'categories.delete']);
    
    // Sliders Management Routes
    $routes->get('sliders', 'SlidersController::index', ['as' => 'sliders']);
    $routes->get('sliders/create', 'SlidersController::create', ['as' => 'sliders.create']);
    $routes->post('sliders/store', 'SlidersController::store', ['as' => 'sliders.store']);
    $routes->get('sliders/view/(:num)', 'SlidersController::view/$1', ['as' => 'sliders.view']);
    $routes->get('sliders/edit/(:num)', 'SlidersController::edit/$1', ['as' => 'sliders.edit']);
    $routes->post('sliders/update/(:num)', 'SlidersController::update/$1', ['as' => 'sliders.update']);
    $routes->get('sliders/delete/(:num)', 'SlidersController::delete/$1', ['as' => 'sliders.delete']);
    $routes->get('sliders/toggle-status/(:num)', 'SlidersController::toggleStatus/$1', ['as' => 'sliders.toggleStatus']);
    
    // Users Management Routes
    $routes->get('users', 'UsersController::index', ['as' => 'users']);
    $routes->get('users/create', 'UsersController::create', ['as' => 'users.create']);
    $routes->post('users/store', 'UsersController::store', ['as' => 'users.store']);
    $routes->get('users/view/(:num)', 'UsersController::view/$1', ['as' => 'users.view']);
    $routes->get('users/edit/(:num)', 'UsersController::edit/$1', ['as' => 'users.edit']);
    $routes->post('users/update/(:num)', 'UsersController::update/$1', ['as' => 'users.update']);
    $routes->get('users/delete/(:num)', 'UsersController::delete/$1', ['as' => 'users.delete']);
    
    // Settings Management Routes
    $routes->get('settings', 'SettingsController::index', ['as' => 'settings']);
    $routes->post('settings/update', 'SettingsController::update', ['as' => 'settings.update']);
    $routes->post('settings/add-gallery-image', 'SettingsController::addGalleryImage', ['as' => 'settings.addGalleryImage']);
    $routes->delete('settings/delete-gallery-image/(:num)', 'SettingsController::deleteGalleryImage/$1', ['as' => 'settings.deleteGalleryImage']);
    $routes->post('settings/reorder-gallery', 'SettingsController::reorderGallery', ['as' => 'settings.reorderGallery']);
    
    // POS Management Routes
    $routes->get('pos', 'PosController::index', ['as' => 'pos.index']);
    $routes->get('pos/products', 'PosController::getProducts', ['as' => 'pos.products']);
    $routes->get('pos/product-details', 'PosController::getProductDetails', ['as' => 'pos.productDetails']);
    $routes->post('pos/process-sale', 'PosController::processSale', ['as' => 'pos.processSale']);
    $routes->get('pos/sales-history', 'PosController::salesHistory', ['as' => 'pos.salesHistory']);
    $routes->get('pos/sale/(:num)', 'PosController::viewSale/$1', ['as' => 'pos.viewSale']);
    $routes->get('pos/receipt/(:num)', 'PosController::printReceipt/$1', ['as' => 'pos.printReceipt']);
    $routes->get('pos/sales-stats', 'PosController::getSalesStats', ['as' => 'pos.salesStats']);
    $routes->get('pos/today-sales', 'PosController::getTodaySales', ['as' => 'pos.todaySales']);
    $routes->get('pos/today-stats', 'PosController::getTodayStats', ['as' => 'pos.todayStats']);
    $routes->get('pos/recent-sales', 'PosController::getRecentSales', ['as' => 'pos.recentSales']);
    $routes->get('pos/sale-details/(:num)', 'PosController::getSaleDetails/$1', ['as' => 'pos.saleDetails']);
    $routes->delete('pos/delete-sale/(:num)', 'PosController::deleteSale/$1', ['as' => 'pos.deleteSale']);
    $routes->post('pos/close-day', 'PosController::closeDay', ['as' => 'pos.closeDay']);
    $routes->get('pos/inventory-status', 'PosController::inventoryStatus', ['as' => 'pos.inventoryStatus']);
    
    $routes->get('pos/get-sale-details', 'PosController::getSaleDetails', ['as' => 'pos.getSaleDetails']);
    $routes->get('pos/print-receipt', 'PosController::printReceipt', ['as' => 'pos.printReceipt']);
});

$routes->group('features', function($routes) {
    $routes->get('chart', 'FeaturesController::chart', ['as' => 'chart']);
    $routes->get('table', 'FeaturesController::table', ['as' => 'table']);
    $routes->get('badge', 'FeaturesController::badge', ['as' => 'badge']);
    $routes->get('button', 'FeaturesController::button', ['as' => 'button']);
    $routes->get('color', 'FeaturesController::color', ['as' => 'color']);
    $routes->get('form', 'FeaturesController::form', ['as' => 'form']);
    $routes->get('icon', 'FeaturesController::icon', ['as' => 'icon']);
    $routes->get('navigation', 'FeaturesController::navigation', ['as' => 'navigation']);
    $routes->get('typography', 'FeaturesController::typography', ['as' => 'typography']);
});

$routes->group('pages', function($routes) {
    $routes->get('blog', 'PagesController::blog', ['as' => 'blog']);
    $routes->get('blog-details', 'PagesController::blogDetails', ['as' => 'blogDetails']);
    $routes->get('faq', 'PagesController::faq', ['as' => 'faq']);
    $routes->get('pricing', 'PagesController::pricing', ['as' => 'pricing']);
    $routes->get('testimonial', 'PagesController::testimonial', ['as' => 'testimonial']);
    $routes->get('terms', 'PagesController::terms', ['as' => 'terms']);
    $routes->get('signin', 'PagesController::signin', ['as' => 'signin']);
    $routes->get('signup', 'PagesController::signup', ['as' => 'signup']);
    $routes->get('forgetpassword', 'PagesController::forgetPassword', ['as' => 'forgetPassword']);
    $routes->get('verification', 'PagesController::verification', ['as' => 'verification']);
    $routes->get('error', 'PagesController::error', ['as' => 'error']);
    $routes->get('comingsoon', 'PagesController::comingsoon', ['as' => 'comingsoon']);
    $routes->get('maintenance', 'PagesController::maintenance', ['as' => 'maintenance']);
    $routes->get('blankpage', 'PagesController::blankpage', ['as' => 'blankpage']);
});

$routes->group('app', function($routes) {
    $routes->get('file-manager', 'AppController::fileManager', ['as' => 'fileManager']);
    $routes->get('contact', 'AppController::contact', ['as' => 'contact']);
    $routes->get('kanban', 'AppController::kanban', ['as' => 'kanban']);
    $routes->get('todo', 'AppController::todo', ['as' => 'todo']);
    $routes->get('chat', 'AppController::chat', ['as' => 'chat']);
    $routes->get('calender', 'AppController::calender', ['as' => 'calender']);
});

$routes->group('store', function($routes) {
    $routes->get('/', 'StoreController::index', ['as' => 'storeDashboard']);
    $routes->get('stats', 'StoreController::getStats', ['as' => 'storeStats']);
    
    // Products
    $routes->get('products', 'StoreController::getProducts', ['as' => 'getProducts']);
    $routes->get('products/(:num)', 'StoreController::getProduct/$1', ['as' => 'getProduct']);
    $routes->post('products', 'StoreController::createProduct', ['as' => 'createProduct']);
    
    // Categories
    $routes->get('categories', 'StoreController::getCategories', ['as' => 'getCategories']);
    $routes->get('categories/(:num)', 'StoreController::getCategory/$1', ['as' => 'getCategory']);
    $routes->post('categories', 'StoreController::createCategory', ['as' => 'createCategory']);
    
    // Users
    $routes->get('users', 'StoreController::getUsers', ['as' => 'getUsers']);
    $routes->get('users/(:num)', 'StoreController::getUser/$1', ['as' => 'getUser']);
    
    // Search
    $routes->get('search', 'StoreController::searchProducts', ['as' => 'searchProducts']);
    
    // Product Images
    $routes->get('products-with-images', 'StoreController::getProductsWithImages', ['as' => 'getProductsWithImages']);
    $routes->get('products/(:num)/images', 'StoreController::getProductImages/$1', ['as' => 'getProductImages']);
    $routes->post('product-images', 'StoreController::addProductImage', ['as' => 'addProductImage']);
    $routes->delete('product-images/(:num)', 'StoreController::deleteProductImage/$1', ['as' => 'deleteProductImage']);
    $routes->put('product-images/(:num)/primary', 'StoreController::setPrimaryImage/$1', ['as' => 'setPrimaryImage']);
    
    // Product Gallery
    $routes->get('products/(:num)/gallery', 'StoreController::getProductGallery/$1', ['as' => 'getProductGallery']);
    $routes->post('product-gallery', 'StoreController::addGalleryImage', ['as' => 'addGalleryImage']);
    $routes->delete('product-gallery/(:num)', 'StoreController::deleteGalleryImage/$1', ['as' => 'deleteGalleryImage']);
    $routes->put('products/(:num)/gallery/reorder', 'StoreController::reorderGallery/$1', ['as' => 'reorderGallery']);
    
    // Product Icon and Post Images
    $routes->put('products/(:num)/icon', 'StoreController::updateProductIcon/$1', ['as' => 'updateProductIcon']);
    $routes->put('products/(:num)/post', 'StoreController::updateProductPost/$1', ['as' => 'updateProductPost']);
});
