<?php

namespace App\Model;

use App\Database\Connection;
use App\Database\SQL;
use PDO;

class User {

    private string $id;
    private string $username;
    private string $passwordHash;
    private int $registerDate;
    private int $permissions;

    public function __construct($id, $username, $passwordHash, $registerDate, $permissions){

        $this->id = $id;
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->registerDate = $registerDate;
        $this->permissions = $permissions;
    }

    public static function load($username){

        $stmt = Connection::new()->prepare(SQL::SELECT_USER);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetchAll()[0] ?? [];

        return new User(
            $result["id"] ?? 0,
            $result["username"] ?? "%USER_NOT_FOUND%",
            $result["password"] ?? "",
            $result["createdAt"] ?? 0,
            $result["permissions"] ?? 0
        );
    }

    public static function getLogged(){

        return $_SESSION[User::class] ?? false;
    }

    public function getId(){
        return $this->id;
    }
    public function getUsername(){
        return $this->username;
    }
    public function getPasswordHash(){

        $hash = $this->passwordHash;
        unset($this->passwordHash);
        return $hash;
    }
    public function getRegisterDate(){
        return $this->registerDate;
    }
    public function getWatchedTime(){

        $stmt = Connection::new()->prepare(SQL::SELECT_USER_WATCHED_TIME);
        $stmt->bindParam(":userId", $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll()[0]["watchedTime"];
    }
}