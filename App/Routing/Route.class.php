<?php

namespace App\Routing;

class Route {

    const GET = "GET";
    const POST = "POST";

    private string $alias;
    private string $method;
    private string $target;
    private string $middleware;

    public function __construct($alias, $target, $method){

        $this->alias = $alias;
        $this->method = $method;
        $this->target = $target;
    }

    public function getAlias(){

        return $this->alias;
    }
    public function getMethod(){

        return $this->method;
    }
    public function getTarget(){
        
        return $this->target;
    }
    public function getMiddleware(){

        return $this->middleware ?? null;
    }
    public function setMiddleware($value){
        
        $this->middleware = $value;
    }
}