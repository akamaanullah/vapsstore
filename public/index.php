<?php
// public/index.php

// 1. Simple Autoloader for PSR-4 like namespacing
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

// 3. Load Configuration
require_once dirname(__DIR__) . '/config/config.php';

// 4. Initialize Core Components
use App\Core\Router;
use App\Core\Session;

// Start secure sessions
Session::init();

$router = new Router();

// 5. Define Static Routes
$router->get('/', 'Front\HomeController@index');
$router->get('/collection/{slug}', 'Front\CollectionController@show');

// Admin Auth Routes
$router->get('/admin/login', 'Admin\AuthController@showLoginForm');
$router->post('/admin/login', 'Admin\AuthController@login');
$router->get('/admin/logout', 'Admin\AuthController@logout');

// Admin Dashboard Routes
$router->get('/admin', 'Admin\DashboardController@index');
$router->get('/admin/products', 'Admin\ProductController@index');
$router->get('/admin/products/export', 'Admin\ProductController@export');
$router->get('/admin/products/create', 'Admin\ProductController@create');
$router->post('/admin/products/store', 'Admin\ProductController@store');
$router->get('/admin/products/edit/{id}', 'Admin\ProductController@edit');
$router->post('/admin/products/update/{id}', 'Admin\ProductController@update');
$router->post('/admin/products/delete/{id}', 'Admin\ProductController@delete');

// Brands Management
$router->get('/admin/brands', 'Admin\BrandController@index');
$router->get('/admin/brands/create', 'Admin\BrandController@create');
$router->post('/admin/brands/store', 'Admin\BrandController@store');
$router->get('/admin/brands/edit/{id}', 'Admin\BrandController@edit');
$router->post('/admin/brands/update/{id}', 'Admin\BrandController@update');
$router->get('/admin/brands/delete/{id}', 'Admin\BrandController@delete');

$router->get('/admin/collections', 'Admin\CollectionController@index');
$router->get('/admin/collections/create', 'Admin\CollectionController@create');
$router->post('/admin/collections/store', 'Admin\CollectionController@store');
$router->get('/admin/collections/edit', 'Admin\CollectionController@edit');
$router->get('/admin/collections/edit/{id}', 'Admin\CollectionController@edit');
$router->post('/admin/collections/update/{id}', 'Admin\CollectionController@update');
$router->post('/admin/collections/delete/{id}', 'Admin\CollectionController@delete');

$router->get('/admin/customers', 'Admin\CustomerController@index');
$router->get('/admin/customers/detail', 'Admin\CustomerController@detail');
$router->get('/admin/customers/detail/{id}', 'Admin\CustomerController@detail');

$router->get('/admin/orders', 'Admin\OrderController@index');
$router->get('/admin/orders/detail', 'Admin\OrderController@detail');
$router->get('/admin/orders/detail/{id}', 'Admin\OrderController@detail');

$router->get('/admin/refunds', 'Admin\RefundController@index');
$router->get('/admin/refunds/detail', 'Admin\RefundController@detail');
$router->get('/admin/refunds/detail/{id}', 'Admin\RefundController@detail');
$router->get('/admin/refunds/requests', 'Admin\RefundController@requests');

$router->get('/admin/blogs', 'Admin\BlogController@index');
$router->get('/admin/blogs/create', 'Admin\BlogController@create');
$router->get('/admin/blogs/edit', 'Admin\BlogController@edit');
$router->get('/admin/blogs/edit/{id}', 'Admin\BlogController@edit');
$router->get('/admin/blog-categories', 'Admin\BlogController@categories');
$router->get('/admin/messages', 'Admin\MessageController@index');

$router->get('/admin/brands', 'Admin\BrandController@index');
$router->get('/admin/brands/create', 'Admin\BrandController@create');
$router->get('/admin/brands/edit', 'Admin\BrandController@edit');
$router->get('/admin/brands/edit/{id}', 'Admin\BrandController@edit');

$router->get('/admin/pages', 'Admin\PageController@index');
$router->get('/admin/pages/create', 'Admin\PageController@create');
$router->get('/admin/pages/edit', 'Admin\PageController@edit');
$router->get('/admin/pages/edit/{id}', 'Admin\PageController@edit');

$router->get('/admin/menus', 'Admin\MenuController@index');
$router->get('/admin/menus/edit', 'Admin\MenuController@edit');
$router->get('/admin/menus/settings', 'Admin\MenuController@settings');
$router->get('/admin/theme', 'Admin\ThemeController@index');

$router->get('/admin/coupons', 'Admin\CouponController@index');
$router->get('/admin/coupons/create', 'Admin\CouponController@create');
$router->get('/admin/coupons/edit', 'Admin\CouponController@edit');
$router->get('/admin/coupons/edit/{id}', 'Admin\CouponController@edit');
$router->get('/admin/reviews', 'Admin\ReviewController@index');
$router->get('/admin/settings', 'Admin\SettingController@index');

// 6. Dispatch the Request
// The router will determine the URL and call the appropriate Controller method
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '/';
$router->dispatch($url);
