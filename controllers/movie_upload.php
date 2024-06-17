<?php

use App\Controller\Movie\Uploader;
use App\Routing\Router;

$controler = new Uploader;

$controler->grabInputs();

if($controler->handleErrors() AND $movie = $controler->trackMovie()){

    $controler->addMovie($movie);
}
Router::redirect("/archive");

