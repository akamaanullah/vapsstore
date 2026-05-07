<?php
// config/config.php

// Database Configuration
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'vapestore');

// Application Configuration
define('APP_NAME', $_ENV['APP_NAME'] ?? 'The Perfect Vape');
define('APP_ENV', $_ENV['APP_ENV'] ?? 'development');

// Base URLs
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
// Remove /public if we are already in the public folder to avoid duplication
$basePath = str_replace('/public', '', $scriptName);
$dynamicBaseUrl = $protocol . "://" . $host . $basePath;

define('BASE_URL', $_ENV['BASE_URL'] ?? $dynamicBaseUrl);
define('ASSET_URL', BASE_URL . '/assets');

// Directories
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . '/app');
define('VIEW_DIR', ROOT_DIR . '/views');
