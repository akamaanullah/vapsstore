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
            require $viewFile;
        } else {
            throw new \Exception("View does not exist: " . $view);
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
            throw new \Exception("Model does not exist: " . $modelClass);
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
     * Send a JSON response
     */
    protected function jsonResponse($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    /**
     * Generate a CSRF hidden input field for forms
     */
    protected function csrf_field() {
        $token = \App\Core\Session::getCsrfToken();
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

            if (!\App\Core\Session::validateCsrfToken($token)) {
                http_response_code(403);
                $this->jsonResponse(['status' => 'error', 'message' => 'CSRF token validation failed.'], 403);
            }
        }
    }
}
