<?php

namespace App\Routing;

class Router {

    private array $routes = [];

    public function get($uri, $target){

        $this->routes[$uri] = new Route($uri, $target, Route::GET);

        return $this;
    }
    public function post($uri, $target){

        $this->routes[$uri] = new Route($uri, $target, Route::POST);

        return $this;
    }

    public function only($condition){
    
        $this->routes[array_key_last($this->routes)]->setMiddleware($condition);
    }

    public function route(){

        $uri = parse_url($_SERVER["REQUEST_URI"])["path"];

        if(!$route = $this->routes[$uri] ?? false) $this->abort();

        $target = $route->getTarget();
        $method = $route->getMethod();

        if($middleware = $route->getMiddleware() ?? null) (new Middleware)->$middleware();

        if($method == Route::GET) $this->view($target);

        elseif($method == Route::POST AND $_SERVER["REQUEST_METHOD"] == Route::POST) $this->controller($target);

        else $this->abort(403);
    }

    private function view($target){

        include_once BASE_PATH . "/views/$target.view.php";
    }
    private function controller($target){

        include_once BASE_PATH . "/controllers/$target.php";
    }

    private function abort($code = 404){

        http_response_code($code);
        $this->view("error$code");
        exit();
    }

    public static function redirect($url = "/"){

        header("Location: $url");
        exit();
    }
}