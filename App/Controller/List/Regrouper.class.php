<?php

namespace App\Controller\List;

use App\Model\User;
use App\Model\List\Body;
use App\Database\Connection;
use App\Database\SQL;
use App\Utility\Notification;
use PDO;

class Regrouper {

    const SUCCESS_COPIED = "Selected movies copied successfully to target list.";
    const SUCCESS_MOVED = "Selected movies moved successfully to target list.";
    const SUCCESS_DELETED = "Selected movies deleted successfully from this list.";
    const SUCCESS_STATUS_UPDATE = "Selected movies status successfully updated.";

    const INITIAL_LIST_NOT_FOUND = "Initial list not found.";
    const TARGET_LIST_NOT_FOUND = "Target list has to be selected.";
    const NO_MOVIES_SELECTED = "At least one movie has to be selected.";

    private array $selectedMovieIds;
    private string $operation;

    private int $initialListId;
    private int $targetListId;
    private int $groupStatus;

    public function grabInputs(){

        $this->initialListId = $_POST["initialList"] ?? 0;
        $this->targetListId = $_POST["targetList"] ?? 0;
        $this->operation = $_POST["operation"] ?? 0;
        $this->selectedMovieIds = $_POST["selectedMovies"] ?? [];
        $this->groupStatus = !!($_POST["groupStatus"] ?? 0);
    }

    public function handleErrors(){

        if(!count($this->selectedMovieIds)){

            Notification::setMessage(self::NO_MOVIES_SELECTED);
            return false;

        }elseif($this->initialListId AND !Body::verifyOwner($this->initialListId)){

            Notification::setMessage(self::INITIAL_LIST_NOT_FOUND);
            return false;

        }elseif($this->operation != "DELETE" AND $this->operation != "STATUS" AND (!$this->targetListId OR !Body::verifyOwner($this->targetListId))){

            Notification::setMessage(self::TARGET_LIST_NOT_FOUND);
            return false;
        }
        return true;
    }

    private function deleteFromList(){

        $conn = Connection::new();

        forEach($this->selectedMovieIds as $movieId){

            $stmt = $conn->prepare(SQL::DELETE_LIST_CONTENT);
            $stmt->bindParam(":listId", $this->initialListId, PDO::PARAM_INT);
            $stmt->bindParam(":movieId", $movieId, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    private function insertIntoList(){

        $conn = Connection::new();

        forEach($this->selectedMovieIds as $movieId){

            $stmt = $conn->prepare(SQL::INSERT_LIST_CONTENT);
            $stmt->bindParam(":listId", $this->targetListId, PDO::PARAM_INT);
            $stmt->bindParam(":movieId", $movieId, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public function execute(){

        $operation = $this->operation;

        if($operation == "COPY"){
            
            $this->insertIntoList();
            Notification::setMessage(self::SUCCESS_COPIED);

        }elseif($operation == "DELETE"){

            $this->deleteFromList();
            Notification::setMessage(self::SUCCESS_DELETED);

        }elseif($operation == "MOVE"){

            $this->insertIntoList();
            $this->deleteFromList();
            Notification::setMessage(self::SUCCESS_MOVED);

        }elseif($operation == "STATUS"){

            $this->setGroupStatus($this->groupStatus);
            Notification::setMessage(self::SUCCESS_STATUS_UPDATE);
        }
    }

    private function setGroupStatus($status){

        $conn = Connection::new();

        $userId = User::getLogged()->getId();

        forEach($this->selectedMovieIds as $movieId){

            $stmt = $conn->prepare(SQL::UPDATE_WATCHED);
            $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
            $stmt->bindParam(":movieId", $movieId, PDO::PARAM_INT);
            $stmt->bindParam(":watched", $status, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
}