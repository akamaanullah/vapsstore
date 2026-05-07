<?php
namespace App\Core;

class Controller {
    
    /**
     * Load a view file and pass data to it.
     * 
     * @param string $view Path to the view (e.g., 'front/home' or 'admin/dashboard')
     * @param array $data Data to extract and pass to the view
     */
    protected function view($view, $data = []) {
        // Extract array keys into variables for the view
        extract($data);
        
        $viewFile = dirname(__DIR__, 2) . '/views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View does not exist: " . $viewFile);
        }
    }

    /**
     * Load a model instance
     * 
     * @param string $model Name of the model class
     * @return object
     */
    protected function model($model) {
        $modelClass = "App\\Models\\" . $model;
        if (class_exists($modelClass)) {
            return new $modelClass();
        } else {
            die("Model does not exist: " . $modelClass);
        }
    }

    /**
     * Redirect to a specific URL
     */
    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit;
    }

    /**
     * Generate a CSRF hidden input field for forms
     */
    protected function csrf_field() {
        $token = Session::getCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }

    /**
     * Validate CSRF token from POST request
     */
    protected function validateCsrf() {
        if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            $token = $_POST['csrf_token'] ?? '';
            
            if (empty($token)) {
                // Try various header formats
                $headers = function_exists('getallheaders') ? getallheaders() : [];
                $token = $headers['X-CSRF-TOKEN'] ?? $headers['x-csrf-token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
            }

            if (!Session::validateCsrfToken($token)) {
                http_response_code(403);
                die("CSRF token validation failed. Possible request forgery detected.");
            }
        }
    }
}
