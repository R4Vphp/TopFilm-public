<?php

use App\Controller\Authorization\Logging;
use App\Routing\Router;

$controler = new Logging;

$controler->grabInputs();

if($user = $controler->handleErrors()){

    $controler->loginAccount($user);
    Router::redirect("/hub");

}else{

    Router::redirect("/login");
}