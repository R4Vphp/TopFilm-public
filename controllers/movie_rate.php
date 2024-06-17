<?php

use App\Controller\Movie\Rater;
use App\Routing\Router;

$controler = new Rater;

$controler->execute();

Router::redirect($_SERVER["HTTP_REFERER"] ?? "/archive");