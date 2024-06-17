<?php

namespace App\Routing;

use App\Model\User;
use App\Controller\Authorization\Logging;
use App\Utility\Notification;

class Middleware {

    public function asGuest(){

        if(!User::getLogged()) return;

        Router::redirect("/hub");
    }

    public function asAuthorized(){

        if(User::getLogged()) return;

        Notification::setMessage(Logging::ACCESS_DENIED);
        Router::redirect("/login");
    }
}