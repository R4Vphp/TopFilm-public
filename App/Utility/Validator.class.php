<?php

namespace App\Utility;

use App\Database\Connection;
use App\Database\SQL;
use App\Scrapping\Filmweb;
use PDO;

abstract class Validator {

    const INPUT_NULL = " has to be specified.";
    const INPUT_TOO_LONG = " cannot be longer than ";
    const INPUT_TOO_SHORT = " cannot be shorter than ";
    const INPUT_EXISTS = " already exists.";
    const INPUT_INVALID = " contains invalid symbols.";
    const INPUT_NOT_DIGIT = " has to be digit.";
    const INPUTS_NOT_MATCH = " do not match.";
    const INPUT_NOT_EMAIL = "Invalid email format.";
    
    const PASSWORD_INCORRECT = "Incorrect username or password.";
    const INVALID_TOKEN = "Registration token is invalid.";
    const INVALID_FILMWEB_LINK = "Provided link is not valid.";

    const ALLOWED_SYMBOLS = "abcdefghijklmnopqrstuvwxyz_0123456789";

    public static function alreadyTaken($input, $name = "Name", $table, $row){

        $stmt = Connection::new()->prepare("SELECT * FROM $table WHERE $row = ?");
        $stmt->execute([
            $input
        ]);

        if($stmt->rowCount()){
            Notification::setMessage($name.self::INPUT_EXISTS);
            return true;
        }
        return false;
    }

    public static function isProperEmail($input){

        if(filter_var($input, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        Notification::setMessage(self::INPUT_NOT_EMAIL);
        return false;
    }

    public static function isProperFilmWebLink($input){

        if(strpos($input, Filmweb::URL_PREFIX."/film") === 0){
            return true;
        }
        Notification::setMessage(self::INVALID_FILMWEB_LINK);
        return false;
    }

    public static function doMatch($input1, $input2, $name = "Name"){

        if($input1 === $input2){
            return true;
        }
        Notification::setMessage($name.self::INPUTS_NOT_MATCH);
        return false;
    }

    public static function inproperLen($input, $name = "Name", $min = 3, $max = 64){

        if(strlen($input) > $max){
            $info = $max." chars.";
            Notification::setMessage($name.self::INPUT_TOO_LONG.$info);
            return true;
        }elseif(strlen($input) < $min){
            $info = $min." chars.";
            Notification::setMessage($name.self::INPUT_TOO_SHORT.$info);
            return true;
        }else{
            return false;
        }
    }

    public static function bannedSymbols($input, $name = "Name"){

        $input = str_split(strtolower($input), 1);

        forEach($input as $symbol){
            if(strpos(self::ALLOWED_SYMBOLS, $symbol) === false){
                Notification::setMessage($name.self::INPUT_INVALID);
                return true;
            }
        }
        return false;
    }

    public static function isEmpty($input, $name = "Name"){

        if(empty($input)){
            Notification::setMessage($name.self::INPUT_NULL);
            return true;
        }
        return false;
    }

    public static function isDigit($input, $name = "Name"){

        if(!is_float($input) OR !is_int($input)){
            return false;
            Notification::setMessage($name.self::INPUT_NOT_DIGIT);
        }
        
        return true;
    }

    public static function verifyPassword($password, $hash){

        if(!password_verify($password, $hash)){
            Notification::setMessage(self::PASSWORD_INCORRECT);
            return false;
        }
        return true;
    }

    public static function checkRegistrationToken($token){

        $stmt = Connection::new()->prepare(SQL::DELETE_REGISTRATION_TOKEN);
        $stmt->bindParam(":token", $token, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount()){
            return true;
        }
        Notification::setMessage(self::INVALID_TOKEN);
        return false;
    }
}