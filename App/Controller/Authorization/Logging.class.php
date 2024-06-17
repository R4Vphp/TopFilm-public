<?php

namespace App\Controller\Authorization;

use App\Model\User;
use App\Model\List\Manager;
use App\Database\Connection;
use App\Database\SQL;
use App\Utility\Validator;
use App\Utility\Notification;
use PDO;

class Logging {

    const SUCCESS = "You are logged successfully.";
    const LOGOUT = "Logged out successfully.";
    const ACCESS_DENIED = "Login to get access.";

    const ACCOUNT_NOT_FOUND = "Username not found";

    private string $username;
    private string $password;

    public function grabInputs(){

        $this->username = trim($_POST["username"] ?? "");
        $this->password = $_POST["password"] ?? "";
    }

    public function handleErrors(){

        $user = User::load($this->username);

        $password = $this->password;

        if(
            Validator::isEmpty($user->getUsername(), "Username")
        ){
            return false;
        }
        if(
            Validator::isEmpty($password, "Password") OR
            !Validator::verifyPassword($password, $user->getPasswordHash())
        ){
            self::log($user->getId(), 0);
            return false;
        }

        self::log($user->getId(), 1);

        return $user;
    }

    public function loginAccount($user){

        $_SESSION[User::class] = $user;
        Notification::setMessage(self::SUCCESS);
    }

    public static function logoutAccount(){

        unset($_SESSION[User::class]);
        unset($_SESSION[Manager::class]);
        Notification::setMessage(self::LOGOUT);
    }

    private static function log($userId, $status){

        if(!$userId){
            return;
        }

        $stmt = Connection::new()->prepare(SQL::INSERT_LOGIN);
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $stmt->bindParam(":ipAddress", $_SERVER["REMOTE_ADDR"], PDO::PARAM_STR);
        $stmt->bindParam(":occuredAt", time(), PDO::PARAM_INT);
        $stmt->bindParam(":succeeded", $status, PDO::PARAM_INT);

        $stmt->execute();
    }
}