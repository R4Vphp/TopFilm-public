<?php

namespace App\Controller\List;

use App\Model\User;
use App\Model\List\Manager;
use App\Database\Connection;
use App\Database\SQL;
use App\Utility\Validator;
use App\Utility\Notification;
use PDO;

class Creator {

    const SUCCESS = "List created successfully.";

    private string $title;
    private int $userId;

    public function grabInputs(){
        
        $this->title = trim($_POST["listTitle"] ?? "");
        $this->userId = User::getLogged()->getId();
    }

    public function handleErrors(){

        $title = $this->title;

        if(
            Validator::isEmpty($title, "Title") OR
            Validator::inproperLen($title, "Title", 3, 64)
        ){
            return false;
        }
        return true;

    }

    public function createList(){

        $title = htmlspecialchars($this->title);

        $stmt = Connection::new()->prepare(SQL::INSERT_LIST_HEADER);
        $stmt->bindParam(":userId", $this->userId, PDO::PARAM_INT);
        $stmt->bindParam(":title", $title, PDO::PARAM_STR);
        $stmt->bindParam(":createdAt", time(), PDO::PARAM_INT);
        $stmt->execute();

        new Manager();
        
        Notification::setMessage(self::SUCCESS);
    }
}