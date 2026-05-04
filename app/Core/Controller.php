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
}
