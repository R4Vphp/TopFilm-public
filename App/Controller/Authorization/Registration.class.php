<?php

namespace App\Controller\Authorization;

use App\Database\Connection;
use App\Database\SQL;
use App\Utility\Validator;
use App\Utility\Notification;
use PDO;

class Registration {

    const SUCCESS = "Account created successfully.";

    private string $username;
    private string $password;
    private string $confirmPassword;
    private string $registrationToken;

    public function grabInputs(){

        $this->username = trim($_POST["username"] ?? "");
        $this->password = $_POST["password"] ?? "";
        $this->confirmPassword = $_POST["confirmPassword"] ?? "";
        $this->registrationToken = trim($_POST["registrationToken"] ?? "");

    }

    public function handleErrors(){

        $username = $this->username;
        $pass1 = $this->password;
        $pass2 = $this->confirmPassword;
        $token = $this->registrationToken;

        if(
            Validator::isEmpty($username, "Username") OR
            Validator::inproperLen($username, "Username", 3, 32) OR
            Validator::alreadyTaken($username, "Username", "users", "username") OR
            Validator::bannedSymbols($username, "Username")
        ){
            return false;
        }
        if(
            Validator::isEmpty($pass1, "Password") OR
            !Validator::doMatch($pass1, $pass2, "Password") OR
            Validator::inproperLen($pass1, "Password", 8, 100)
        ){
            return false;
        }
        if(
            Validator::isEmpty($token, "Registration token")
        ){
            return false;
        }
        if(
            !Validator::checkRegistrationToken($token)
        ){
            return false;
        }
        return true;

    }

    public function createAccount(){

        $username = $this->username;
        $password = password_hash($this->password, PASSWORD_BCRYPT);
        $registerDate = time();

        $stmt = Connection::new()->prepare(SQL::INSERT_USER);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->bindParam(":createdAt", $registerDate, PDO::PARAM_INT);
        $stmt->execute();

        Notification::setMessage(self::SUCCESS);
        return $id;

    }

}