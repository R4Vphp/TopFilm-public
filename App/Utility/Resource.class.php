<?php

namespace App\Utility;

abstract class Resource {


    public static function load($resource){

        return "http://".Network::serverIp().$resource;
    }
}