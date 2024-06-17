<?php

namespace App\Model\List;

use App\Database\Connection;
use App\Database\SQL;
use App\Model\User;
use PDO;

class Manager {

    const LIST_NOT_FOUND = "List does not exists.";

    private Body $archive;
    private array $customs;

    public function __construct(){

        $this->archive = new Body;
        $this->customs = self::all();

        $_SESSION[__CLASS__] = $this;
    }

    public static function get(){

        return $_SESSION[__CLASS__] ?? new self;
    }
    

    public function getList($id){
        
        return ($id ? $this->customs[$id] : $this->archive);
    }

    public static function all(){
        
        $userId = User::getLogged()->getId();

        $stmt = Connection::new()->prepare(SQL::SELECT_LISTS);
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();
        
        $customs = [];

        forEach($result as $key => $list){

            $customs[$list["id"]] = new Body($list["id"], $list["title"]);
        }

        return $customs;
    }

    public function printAsOption($skip = null){

        forEach($this->customs as $list){

            $id = $list->getListId();
            $title = $list->getTitle();

            if($id == $skip) continue;

            echo "<option value='$id'>$title</option>";
        }
    }

    public function printAsPanel(){

        forEach($this->customs as $list){

            require BASE_PATH . "/components/model/listTileList.class.html.php";
        }
    }

    public function printUserLists(){

        forEach($this->customs as $list){

            $list->print();
        }
    }
    
    public function printArchiveList(){

        $this->archive->print();
    }

    public function listAmount(){
        
        return count($this->customs);
    }

}