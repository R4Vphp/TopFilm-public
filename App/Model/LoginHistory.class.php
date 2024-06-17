<?php

namespace App\Model;

use App\Database\Connection;
use App\Database\SQL;
use PDO;

class LoginHistory {

    const LOGIN_SUCCEEDED = "Login successfully.";
    const LOGIN_FAILED = "Login failed.";

    public static function load(){

        $userId = User::getLogged()->getId();

        $stmt = Connection::new()->prepare(SQL::SELECT_LOGINS);
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function printElements($elements){

        forEach($elements as $e){

            include BASE_PATH . "/components/model/listTileHistory.class.html.php";
        }
    }
}