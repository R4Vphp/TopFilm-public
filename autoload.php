<?php

const BASE_PATH = __DIR__;

spl_autoload_register(function($class){

    include_once str_replace("\\", "/", $class) . ".class.php";
});