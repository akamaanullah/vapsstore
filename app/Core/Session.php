<?php
namespace App\Core;

class Session {
    public static function init() {
        if (session_status() == PHP_SESSION_NONE) {
            // Use Database Session Handler (Phase 3.2)
            $handler = new DatabaseSessionHandler();
            session_set_save_handler($handler, true);

            // Set secure session parameters
            ini_set('session.use_only_cookies', 1);
            ini_set('session.use_strict_mode', 1);
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_samesite', 'Strict');
            
            // Only use secure cookies if on HTTPS
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                ini_set('session.cookie_secure', 1);
            }
            
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return $_SESSION[$key] ?? null;
    }

    public static function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy() {
        session_unset();
        session_destroy();
    }
    
    // Flash messages (exist only for the next request)
    public static function setFlash($type, $message) {
        self::setFlashData('flash', [
            'type' => $type, // 'success', 'error', 'warning'
            'message' => $message
        ]);
    }
    
    public static function getFlash() {
        return self::getFlashData('flash');
    }

    /**
     * Set arbitrary data that will only be available for the next request.
     */
    public static function setFlashData($key, $value) {
        $_SESSION['flash_data'][$key] = $value;
    }

    /**
     * Get flash data and remove it so it's only read once.
     */
    public static function getFlashData($key) {
        if (isset($_SESSION['flash_data'][$key])) {
            $value = $_SESSION['flash_data'][$key];
            unset($_SESSION['flash_data'][$key]);
            return $value;
        }
        return null;
    }

    /**
     * Check if flash data exists without removing it.
     */
    public static function hasFlashData($key) {
        return isset($_SESSION['flash_data'][$key]);
    }

    // Check if an admin is logged in
    public static function isAdminLoggedIn() {
        return (self::get('is_logged_in') === true && self::get('user_role') === 'admin');
    }

    /**
     * Generate and store a CSRF token
     */
    public static function generateCsrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Get the current CSRF token
     */
    public static function getCsrfToken() {
        return $_SESSION['csrf_token'] ?? self::generateCsrfToken();
    }

    /**
     * Validate a submitted CSRF token
     */
    public static function validateCsrfToken($token) {
        $storedToken = self::getCsrfToken();
        return !empty($token) && hash_equals($storedToken, $token);
    }
}
