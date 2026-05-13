<?php
// public/index.php

// 1. Load Composer Autoloader
if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
}

// 2. Simple Autoloader for PSR-4 like namespacing
spl_autoload_register(function ($class) {
    // Project-specific namespace prefix
    $prefix = 'App\\';
    $base_dir = dirname(__DIR__) . '/app/';

    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return; // Move to the next registered autoloader
    }

    // Get the relative class name
    $relative_class = substr($class, $len);

    // Replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

// 2. Load Environment Variables
use App\Core\DotEnv;
$envPath = dirname(__DIR__) . '/.env';
if (file_exists($envPath)) {
    (new DotEnv($envPath))->load();
}

// 3. Register Global Error Handler
use App\Core\ErrorHandler;
ErrorHandler::register();

// 4. Load Configuration
require_once dirname(__DIR__) . '/config/config.php';

// 4. Initialize Core Components
use App\Core\Router;
use App\Core\Session;

// Start secure sessions
Session::init();

$router = new Router();

// 5. Define Static Routes
$router->get('/', 'Front\HomeController@index');

// Collection Routes (Support both singular and plural)
$router->get('/collection', 'Front\CollectionController@index');
$router->get('/collections', 'Front\CollectionController@index');
$router->get('/collection/filters/{params}', 'Front\CollectionController@index');
$router->get('/collections/filters/{params}', 'Front\CollectionController@index');
$router->get('/collection/{slug}', 'Front\CollectionController@show');
$router->get('/collections/{slug}', 'Front\CollectionController@show');

$router->get('/track-order', 'Front\OrderTrackingController@index');
$router->get('/track-order/status', 'Front\OrderTrackingController@track');
$router->get('/order-status', 'Front\OrderTrackingController@track');
$router->get('/api/collection/search', 'Front\CollectionController@apiSearch');
$router->get('/product/{slug}', 'Front\ProductController@show');
// Pages and SEO Routes
$router->get('/page/{slug}', 'Front\PageController@show');
$router->get('/blog', 'Front\BlogController@index');
$router->get('/blog/{slug}', 'Front\BlogController@show');

$router->get('/contact-us', 'Front\HomeController@contact');
$router->get('/wishlist', 'Front\HomeController@wishlist');
$router->get('/cart', 'Front\HomeController@cart');
$router->post('/api/review/submit', 'Front\ProductController@submitReview');
$router->get('/checkout', 'Front\CheckoutController@index');
$router->post('/api/checkout/place', 'Front\CheckoutController@placeOrder');
$router->get('/checkout/success', 'Front\CheckoutController@success');

// Authentication Routes
$router->get('/login', 'Front\HomeController@login');
$router->get('/signup', 'Front\HomeController@signup');
$router->get('/register', 'Front\HomeController@signup');
$router->post('/api/auth/login', 'Front\AuthController@login');
$router->post('/api/auth/signup', 'Front\AuthController@signup');
$router->get('/logout', 'Front\AuthController@logout');

// Customer Account Routes
$router->get('/account', 'Front\AccountController@index');
$router->get('/account/orders', 'Front\AccountController@orders');
$router->get('/account/profile', 'Front\AccountController@profile');
$router->get('/account/addresses', 'Front\AccountController@addresses');
$router->post('/api/account/update', 'Front\AccountController@updateProfile');
$router->post('/api/account/address/add', 'Front\AccountController@addAddress');
$router->post('/api/account/address/delete', 'Front\AccountController@deleteAddress');
$router->post('/api/account/address/default', 'Front\AccountController@setDefaultAddress');

// Cart API Routes
$router->get('/api/cart', 'Front\CartController@index');
$router->post('/api/cart/add', 'Front\CartController@add');
$router->post('/api/cart/update', 'Front\CartController@update');
$router->post('/api/cart/remove', 'Front\CartController@remove');
$router->post('/api/cart/clear', 'Front\CartController@clear');

// Policy Routes
$router->get('/shipping-policy', 'Front\HomeController@shippingPolicy');
$router->get('/refund-policy', 'Front\HomeController@refundPolicy');
$router->get('/return-policy', 'Front\HomeController@returnPolicy');
$router->get('/privacy-policy', 'Front\HomeController@privacyPolicy');
$router->get('/terms-and-conditions', 'Front\HomeController@termsAndConditions');
$router->get('/fda-disclaimer', 'Front\HomeController@fdaDisclaimer');

// Admin Auth Routes
$router->get('/admin/login', 'Admin\AuthController@showLoginForm');
$router->post('/admin/login', 'Admin\AuthController@login');
$router->get('/admin/logout', 'Admin\AuthController@logout');

// Admin Dashboard & Core Modules
$router->get('/admin', 'Admin\DashboardController@index');

// Products
$router->get('/admin/products', 'Admin\ProductController@index');
$router->get('/admin/products/create', 'Admin\ProductController@create');
$router->post('/admin/products/store', 'Admin\ProductController@store');
$router->get('/admin/products/edit/{id}', 'Admin\ProductController@edit');
$router->post('/admin/products/update/{id}', 'Admin\ProductController@update');
$router->post('/admin/products/delete/{id}', 'Admin\ProductController@delete');
$router->get('/admin/products/api/search', 'Admin\ProductController@apiSearch');
$router->get('/admin/products/api/by-collection', 'Admin\ProductController@apiByCollection');

// Brands
$router->get('/admin/brands', 'Admin\BrandController@index');
$router->get('/admin/brands/create', 'Admin\BrandController@create');
$router->post('/admin/brands/store', 'Admin\BrandController@store');
$router->get('/admin/brands/edit/{id}', 'Admin\BrandController@edit');
$router->post('/admin/brands/update/{id}', 'Admin\BrandController@update');
$router->get('/admin/brands/delete/{id}', 'Admin\BrandController@delete');

// Collections
$router->get('/admin/collections', 'Admin\CollectionController@index');
$router->get('/admin/collections/create', 'Admin\CollectionController@create');
$router->post('/admin/collections/store', 'Admin\CollectionController@store');
$router->get('/admin/collections/edit/{id}', 'Admin\CollectionController@edit');
$router->post('/admin/collections/update/{id}', 'Admin\CollectionController@update');
$router->post('/admin/collections/delete/{id}', 'Admin\CollectionController@delete');

// Pages
$router->get('/admin/pages', 'Admin\PageController@index');
$router->get('/admin/pages/create', 'Admin\PageController@create');
$router->post('/admin/pages/store', 'Admin\PageController@store');
$router->get('/admin/pages/edit/{id}', 'Admin\PageController@edit');
$router->post('/admin/pages/update/{id}', 'Admin\PageController@update');
$router->get('/admin/pages/delete/{id}', 'Admin\PageController@delete');

// Navigation (Menus)
$router->get('/admin/menus', 'Admin\MenuController@index');
$router->get('/admin/menus/edit/{id}', 'Admin\MenuController@edit');
$router->post('/admin/menus/store', 'Admin\MenuController@store');
$router->post('/admin/menus/update/{id}', 'Admin\MenuController@update');
$router->get('/admin/menus/search', 'Admin\MenuController@search');
$router->get('/admin/menus/delete/{id}', 'Admin\MenuController@delete');
$router->get('/admin/menus/settings', 'Admin\MenuController@settings');

// Customers & Orders
$router->get('/admin/customers', 'Admin\CustomerController@index');
$router->get('/admin/customers/detail/{id}', 'Admin\CustomerController@detail');
$router->get('/admin/orders', 'Admin\OrderController@index');
$router->get('/admin/orders/detail/{id}', 'Admin\OrderController@detail');
$router->post('/admin/orders/update-status/{id}', 'Admin\OrderController@updateStatus');

// Refunds
$router->get('/admin/refunds', 'Admin\RefundController@index');
$router->get('/admin/refunds/detail/{id}', 'Admin\RefundController@detail');
$router->get('/admin/refunds/requests', 'Admin\RefundController@requests');

// Blogs
$router->get('/admin/blogs', 'Admin\BlogController@index');
$router->get('/admin/blogs/create', 'Admin\BlogController@create');
$router->post('/admin/blogs/store', 'Admin\BlogController@store');
$router->get('/admin/blogs/edit/{id}', 'Admin\BlogController@edit');
$router->post('/admin/blogs/update/{id}', 'Admin\BlogController@update');
$router->post('/admin/blogs/delete/{id}', 'Admin\BlogController@delete');
$router->get('/admin/blog-categories', 'Admin\BlogController@categories');
$router->post('/admin/blog-categories/store', 'Admin\BlogController@storeCategory');
$router->post('/admin/blog-categories/update/{id}', 'Admin\BlogController@updateCategory');
$router->post('/admin/blog-categories/delete/{id}', 'Admin\BlogController@deleteCategory');

// System & Settings
$router->get('/admin/messages', 'Admin\MessageController@index');
$router->get('/admin/theme', 'Admin\ThemeController@index');
$router->post('/admin/theme/update', 'Admin\ThemeController@update');
$router->get('/admin/media', 'Admin\MediaController@index');
$router->post('/admin/media/upload', 'Admin\MediaController@upload');
$router->post('/admin/media/delete/{id}', 'Admin\MediaController@delete');
$router->get('/admin/media/search', 'Admin\MediaController@apiSearch');

$router->get('/admin/coupons', 'Admin\CouponController@index');
$router->get('/admin/coupons/create', 'Admin\CouponController@create');
$router->post('/admin/coupons/store', 'Admin\CouponController@store');
$router->get('/admin/coupons/edit/{id}', 'Admin\CouponController@edit');
$router->post('/admin/coupons/update/{id}', 'Admin\CouponController@update');
$router->post('/admin/coupons/delete/{id}', 'Admin\CouponController@delete');

$router->get('/admin/reviews', 'Admin\ReviewController@index');
$router->get('/admin/settings', 'Admin\SettingController@index');
$router->post('/admin/settings/update', 'Admin\SettingController@update');

// 6. Dispatch the Request
// The router will determine the URL and call the appropriate Controller method
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '/';
$router->dispatch($url);
