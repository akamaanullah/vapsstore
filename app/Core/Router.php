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
                
                return $this->executeAction($route['action'], array_values($params));
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
                throw new \Exception("Method {$methodName} not found in controller {$controllerClass}");
            }
        } else {
            throw new \Exception("Controller class {$controllerClass} not found");
        }
    }

    protected function dispatchDynamicSeoRoute($url) {
        $db = Database::getInstance()->getConnection();
        $cleanUrl = ltrim($url, '/');
        
        // Pretty URL Optimization: Extract filters if present
        $filters = null;
        if (strpos($cleanUrl, '/filters/') !== false) {
            list($basePath, $filterString) = explode('/filters/', $cleanUrl, 2);
            $cleanUrl = $basePath;
            $filters = $filterString;
        }

        // Strip common prefixes to match root-level slugs in DB
        $prefixes = ['collection/', 'collections/', 'page/', 'pages/', 'brand/', 'brands/', 'products/', 'product/'];
        foreach ($prefixes as $prefix) {
            if (strpos($cleanUrl, $prefix) === 0) {
                $cleanUrl = substr($cleanUrl, strlen($prefix));
                break;
            }
        }

        $sql = "
            (SELECT 'blog' as entity_type, id FROM blog_posts WHERE custom_url_path = ? AND is_active = 1)
            UNION ALL
            (SELECT 'collection' as entity_type, id FROM collections WHERE custom_url_path = ? AND is_active = 1)
            UNION ALL
            (SELECT 'product' as entity_type, id FROM products WHERE custom_url = ? AND status = 'published')
            UNION ALL
            (SELECT 'page' as entity_type, id FROM pages WHERE custom_url_path = ? AND is_active = 1)
            LIMIT 1
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute([$cleanUrl, $cleanUrl, $cleanUrl, $cleanUrl]);
        $result = $stmt->fetch();

        if ($result) {
            $entityType = $result['entity_type'];
            $expectedPrefix = '';
            
            switch ($entityType) {
                case 'collection': $expectedPrefix = 'collection/'; break;
                case 'page':       $expectedPrefix = 'page/'; break;
                case 'product':    $expectedPrefix = 'products/'; break;
                case 'brand':      $expectedPrefix = 'brands/'; break;
                case 'blog':       $expectedPrefix = 'blog/'; break;
            }

            // SEO: 301 Redirect to canonical URL if prefix is missing
            $currentUrl = ltrim($url, '/');
            if ($expectedPrefix && strpos($currentUrl, $expectedPrefix) !== 0) {
                $canonicalUrl = BASE_URL . '/' . $expectedPrefix . $cleanUrl;
                if ($filters) $canonicalUrl .= '/filters/' . $filters;
                
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: " . $canonicalUrl);
                exit;
            }

            $params = [$cleanUrl];
            if ($filters) $params[] = $filters;

            switch ($entityType) {
                case 'page':
                    return $this->executeAction('Front\PageController@show', $params);
                case 'collection':
                    return $this->executeAction('Front\CollectionController@show', $params);
                case 'product':
                    return $this->executeAction('Front\ProductController@show', $params);
                case 'blog':
                    return $this->executeAction('Front\BlogController@show', $params);
            }
        }


        return false;
    }


    protected function send404() {
        http_response_code(404);
        $code = 404;
        $message = "The requested URL was not found on this server.";
        
        // Use the global settings for the header/footer
        $settings = \App\Helpers\UIHelper::getSettings();
        
        // Image helper for previews (from settings.php logic)
        $img = function($key, $default) use ($settings) {
            $val = $settings[$key] ?? '';
            if (empty($val)) return BASE_URL . '/' . $default;
            return (strpos($val, 'http') === 0) ? $val : BASE_URL . '/' . $val;
        };

        require dirname(__DIR__, 2) . "/views/front/error.php";
        exit;
    }
}
