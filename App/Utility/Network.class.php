<?php

namespace App\Utility;

abstract class Network {

    public static function serverIp(){
        return getHostByName(getHostName()).":".$_SERVER["SERVER_PORT"];
    }
    public static function visitorIp(){
        return $_SERVER["REMOTE_ADDR"];
    }
}