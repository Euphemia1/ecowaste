<?php
/**
 * Simple Router Class for EcoWaste Application
 */

class Router {
    private $routes = [];
    private $middlewares = [];

    /**
     * Add GET route
     */
    public function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }

    /**
     * Add POST route
     */
    public function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }

    /**
     * Add route with method
     */
    private function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    /**
     * Dispatch current request
     */
    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove public from path if present
        $requestPath = str_replace('/public', '', $requestPath);
        
        // Remove trailing slash except for root
        if ($requestPath !== '/' && substr($requestPath, -1) === '/') {
            $requestPath = rtrim($requestPath, '/');
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $this->matchPath($route['path'], $requestPath)) {
                $this->handleRoute($route['handler'], $requestPath);
                return;
            }
        }

        // No route found - 404
        $this->handle404();
    }

    /**
     * Check if path matches route pattern
     */
    private function matchPath($routePath, $requestPath) {
        // Simple exact match for now
        if ($routePath === $requestPath) {
            return true;
        }
        
        // Handle parameters (basic implementation)
        $routePattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $routePath);
        $routePattern = '/^' . str_replace('/', '\/', $routePattern) . '$/';
        
        return preg_match($routePattern, $requestPath);
    }

    /**
     * Handle route execution
     */
    private function handleRoute($handler, $requestPath) {
        if (is_callable($handler)) {
            $handler();
        } elseif (is_string($handler) && strpos($handler, '@') !== false) {
            list($controllerName, $methodName) = explode('@', $handler);
            $this->callController($controllerName, $methodName);
        } else {
            throw new Exception("Invalid route handler");
        }
    }

    /**
     * Call controller method
     */
    private function callController($controllerName, $methodName) {
        $controllerFile = '../controllers/' . $controllerName . '.php';
        
        if (!file_exists($controllerFile)) {
            throw new Exception("Controller file not found: " . $controllerFile);
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            throw new Exception("Controller class not found: " . $controllerName);
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $methodName)) {
            throw new Exception("Controller method not found: " . $controllerName . '::' . $methodName);
        }

        $controller->$methodName();
    }

    /**
     * Handle 404 error
     */
    private function handle404() {
        http_response_code(404);
        if (file_exists('../views/errors/404.php')) {
            require_once '../views/errors/404.php';
        } else {
            echo "<h1>404 - Page Not Found</h1>";
        }
    }
}
?>