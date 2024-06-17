<?php

use App\Controller\List\Browser;
use App\Routing\Router;

$controler = new Browser;

$controler->grabInputs();
$controler->setBrowser();
Router::redirect($_SERVER["HTTP_REFERER"] ?? "/archive");