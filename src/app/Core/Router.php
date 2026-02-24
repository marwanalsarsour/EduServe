<?php


class Router {
    protected $routes = [];

    public function add($method, $route, $callback) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'route'  => $route,
            'callback' => $callback
        ];
    }

    public function run() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['route'] === $uri && $route['method'] === $method) {
                return call_user_func($route['callback']);
            }
        }

        http_response_code(404);
        
        echo "404 - عذراً، الصفحة غير موجودة";
    }
}