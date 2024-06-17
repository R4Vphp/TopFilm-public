<?php

namespace App\Utility;

abstract class Notification {

    const GENERAL_ERROR = "Coś poszło nie tak - spróbuj ponownie.";

    public static function listen(){

        if(!($_SESSION[__CLASS__] ?? false)) return;
        
        self::popOut($_SESSION[__CLASS__]);
        unset($_SESSION[__CLASS__]);
    }

    public static function setMessage($message){

        $_SESSION[__CLASS__] = $message;
    }

    private static function popOut($message){

        echo "<div class='notification'><p>$message</p></div>";
    }
}