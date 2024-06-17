<?php

namespace App\Model\List;

use App\Model\User;
use App\Model\Movie;
use App\Model\Director;
use App\Controller\List\Sorting;
use App\Database\Connection;
use App\Database\SQL;
use PDO;

class Body {

    const DEFAULT_TITLE = "Archiwum";

    private int $id;
    private string $title;

    private int $owner;
    private Browser $browser;
    
    private int $size = 0;

    public function __construct($id = 0, $title = null){

        $this->id = $id;
        $this->owner = User::getLogged()->getId();
        $this->title = ($id ? $title : self::DEFAULT_TITLE);
        $this->browser = new Browser;
    }

    public function load(){

        $query = "%".implode("%", explode(" ", $this->browser->getQuery() ?? ""))."%";

        $sql = ($this->id ? SQL::SELECT_USERLIST_QUERY : SQL::SELECT_ARCHIVE_QUERY);

        $stmt = Connection::new()->prepare($sql ." ". (Sorting::all()[$this->browser->getSorting()]->query));
        $stmt->bindParam(":userId", $this->owner, PDO::PARAM_INT);
        $stmt->bindParam(":query", $query, PDO::PARAM_STR);

        if($this->id) $stmt->bindParam(":listId", $this->id, PDO::PARAM_INT);

        $stmt->execute();
        $this->size = $stmt->rowCount();

        return $stmt->fetchAll();
    }

    public function printElements($elements){

        return implode($elements);
    }

    public function setElements($result){

        forEach($result as $key => $r){

            $result[$key] = new Movie(
                $r["movieId"],
                $r["originalTitle"],
                $r["polishTitle"],
                $r["productionYear"],
                $r["duration"] ?? 0,
                new Director(
                    $r["directorId"],
                    $r["firstName"],
                    $r["lastName"]
                ),
                $r["watched"],
                $r["rating"],
                $r["image"],
                $r["uploadAt"]
            );
            $result[$key]->setOrigin($this->id);
        }
        return $result;
    }

    public function print(){

        include BASE_PATH . "/components/model/panelMovieList.class.html.php";
    }

    public static function verifyOwner($listId){
        
        $userId = User::getLogged()->getId();
        
        $stmt = Connection::new()->prepare(SQL::SELECT_LIST_OWNER);
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $stmt->bindParam(":listId", $listId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll()[0] ?? false;   
    }

    public function getElementsCount(){
        return $this->size;
    }

    public function getBrowser(){
        return $this->browser;
    }
    public function getListId(){
        return $this->id;
    }
    public function getTitle(){
        return $this->title;
    }
}