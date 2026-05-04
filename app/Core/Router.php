<?php
namespace App\Core;

class Router {
    protected $routes = [];

    // Add a GET route
    public function get($route, $controllerAction) {
        $this->addRoute('GET', $route, $controllerAction);
    }

    // Add a POST route
    public function post($route, $controllerAction) {
        $this->addRoute('POST', $route, $controllerAction);
    }

    protected function addRoute($method, $route, $controllerAction) {
        // Convert route string to a regular expression for dynamic parameters
        $routeRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $route);
        $routeRegex = "#^" . $routeRegex . "$#";
        
        $this->routes[] = [
            'method' => $method,
            'pattern' => $routeRegex,
            'action' => $controllerAction
        ];
    }

    public function dispatch($url) {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = '/' . ltrim($url, '/'); // Ensure leading slash

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $url, $matches)) {
                // Remove numeric keys from matches to leave only named parameters
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                return $this->executeAction($route['action'], $params);
            }
        }

        // ------------------------------------------------------------------
        // DEEP SEO ROUTING FALLBACK
        // If no static route matches, check the database for custom URLs
        // ------------------------------------------------------------------
        if ($this->dispatchDynamicSeoRoute($url)) {
            return;
        }

        // If no route matches at all, send 404
        $this->send404();
    }

    protected function executeAction($action, $params = []) {
        list($controllerName, $methodName) = explode('@', $action);
        
        $controllerClass = "App\\Controllers\\" . $controllerName;

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $methodName)) {
                call_user_func_array([$controller, $methodName], $params);
                return true;
            } else {
                die("Method {$methodName} not found in controller {$controllerClass}");
            }
        } else {
            die("Controller class {$controllerClass} not found");
        }
    }

    protected function dispatchDynamicSeoRoute($url) {
        $db = Database::getInstance()->getConnection();
        $cleanUrl = ltrim($url, '/'); // DB stores without leading slash e.g. "collections/shop/vapes"

        // Check Pages table
        $stmt = $db->prepare("SELECT id FROM pages WHERE custom_url_path = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$cleanUrl]);
        if ($stmt->fetch()) {
            return $this->executeAction('Front\PageController@show', ['url' => $cleanUrl]);
        }

        // Check Collections table
        $stmt = $db->prepare("SELECT id FROM collections WHERE custom_url_path = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$cleanUrl]);
        if ($stmt->fetch()) {
            return $this->executeAction('Front\CollectionController@show', ['url' => $cleanUrl]);
        }

        // Check Products table
        $stmt = $db->prepare("SELECT id FROM products WHERE custom_url = ? AND status = 'published' LIMIT 1");
        $stmt->execute([$cleanUrl]);
        if ($stmt->fetch()) {
            return $this->executeAction('Front\ProductController@show', ['url' => $cleanUrl]);
        }

        // Check Blog Posts table
        $stmt = $db->prepare("SELECT id FROM blog_posts WHERE custom_url_path = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$cleanUrl]);
        if ($stmt->fetch()) {
            return $this->executeAction('Front\BlogController@show', ['url' => $cleanUrl]);
        }

        return false;
    }

    protected function send404() {
        http_response_code(404);
        // In a real app, render a beautiful 404 view here
        echo "<h1>404 - Page Not Found</h1>";
        echo "<p>The requested URL was not found on this server.</p>";
    }
}
