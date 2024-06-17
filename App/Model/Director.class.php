<?php

namespace App\Model;

use App\Database\Connection;
use App\Database\SQL;
use PDO;

class Director {

    private int $id;
    private string $firstName;
    private string $lastName;

    public function __construct($id, $first, $last){

        $this->id = $id;
        $this->firstName = $first;
        $this->lastName = $last;
    }

    public function getLastName(){
        return $this->lastName;
    }
    public function getFullName(){
        return $this->firstName." ".$this->lastName;
    }

    public function upload(){

        $conn = Connection::new();
        $stmt = $conn->prepare(SQL::INSERT_DIRECTOR);
        $stmt->bindParam(":first", $this->firstName, PDO::PARAM_STR);
        $stmt->bindParam(":last", $this->lastName, PDO::PARAM_STR);
        $stmt->execute();

        return $conn->lastInsertId();
    }
}