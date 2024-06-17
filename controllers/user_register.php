<?php

use App\Controller\Authorization\Registration;
use App\Routing\Router;

$controler = new Registration;

$controler->grabInputs();

if($controler->handleErrors()){

    $controler->createAccount();
    Router::redirect("/login");

}else{
    Router::redirect("/register");
}