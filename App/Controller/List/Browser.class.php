<?php

namespace App\Controller\List;

use App\Model\List\Manager;

class Browser {

    private int $listId;
    private string $query;
    private string $orderBy;

    public function grabInputs(){

        $this->listId = $_POST["initialList"] ?? 0;
        $this->query = $_POST["userQuery"] ?? "";
        $this->orderBy = $_POST["orderBy"] ?? "title asc";
    }

    public function setBrowser(){

        Manager::get()->getList($this->listId)->getBrowser()->setQuery($this->query);
        Manager::get()->getList($this->listId)->getBrowser()->setSorting($this->orderBy);
    }

    public static function get($listId){

        return $_SESSION[__CLASS__][$listId] ?? [];
    }
}