<?php

use App\Controller\List\Regrouper;
use App\Routing\Router;

$controler = new Regrouper;

$controler->grabInputs();
if($controler->handleErrors()){

    $controler->execute();
}

Router::redirect($_SERVER["HTTP_REFERER"] ?? "/archive");