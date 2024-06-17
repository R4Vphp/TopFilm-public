<?php

use App\Controller\List\Creator;
use App\Routing\Router;

$controler = new Creator;

$controler->grabInputs();

if($controler->handleErrors()) $controler->createList();

Router::redirect("/archive");