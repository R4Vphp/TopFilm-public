<?php

use App\Routing\Router;
use App\Routing\Route;

session_start();

$router = new Router;

$router->get("/", "index");
$router->get("/login", "login")->only("asGuest");
$router->get("/register", "register")->only("asGuest");
$router->get("/hub", "hub")->only("asAuthorized");
$router->get("/archive", "archive")->only("asAuthorized");
$router->get("/manager", "manager")->only("asAuthorized");
$router->get("/profile", "profile")->only("asAuthorized");
$router->get("/profile/login-history", "loginhistory")->only("asAuthorized");

$router->post("/user-login", "user_login")->only("asGuest");
$router->post("/user-register", "user_register")->only("asGuest");
$router->post("/user-logout", "user_logout")->only("asAuthorized");

$router->post("/movie-upload", "movie_upload")->only("asAuthorized");
$router->post("/movie-rate", "movie_rate")->only("asAuthorized");
$router->post("/movie-selection-regroup", "movie_selection_regroup")->only("asAuthorized");

$router->post("/list-create", "list_create")->only("asAuthorized");
$router->post("/list-delete", "list_delete")->only("asAuthorized");
$router->post("/list-browse", "list_browse")->only("asAuthorized");

$router->route();