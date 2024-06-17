<?php

namespace App\Controller\Movie;

use App\Scrapping\Filmweb;
use App\Database\Connection;
use App\Database\SQL;
use App\Utility\Validator;
use App\Utility\Notification;
use PDO;

class Uploader extends Filmweb{

    const SUCCESS = "Movie uploaded successfully.";
    const MOVIE_ALREADY_EXISTS = "Movie already exists in database.";

    protected string $link;

    public function grabInputs(){

        $this->link = trim($_POST["filmWebLink"] ?? ""); 
    }

    public function handleErrors(){

        $link = $this->link;

        if(
            Validator::isEmpty($link, "Link") OR
            !Validator::isProperFilmWebLink($link)
        ){
            return false;
        }
        return true;
    }

    public function addMovie($movie){

        $director = $movie->getDirector();
        
        $directorId = $this->findDirector($director);

        if(!$directorId) $directorId = $director->upload();

        $stmt = Connection::new()->prepare(SQL::INSERT_MOVIE);
        $stmt->bindParam(":id", $movie->getId(), PDO::PARAM_INT);
        $stmt->bindParam(":orgTitle", $movie->getOriginalTitle(), PDO::PARAM_STR);
        $stmt->bindParam(":plTitle", $movie->getPolishTitle(), PDO::PARAM_STR);
        $stmt->bindParam(":year", $movie->getProductionYear(), PDO::PARAM_INT);
        $stmt->bindParam(":duration", $movie->getDuration(), PDO::PARAM_INT);
        $stmt->bindParam(":directorId", $directorId, PDO::PARAM_INT);
        $stmt->bindParam(":image", $movie->getImage(), PDO::PARAM_STR);
        $stmt->bindParam(":uploadAt", time(), PDO::PARAM_INT);

        try{
            $stmt->execute();
        }catch(PDOException $e){

            Notification::setMessage(self::MOVIE_ALREADY_EXISTS);
            header("Location: ../archive.php");
            exit();
        }
    
        Notification::setMessage(self::SUCCESS);
    }

    public function findDirector($director){

        $stmt = Connection::new()->prepare(SQL::SELECT_DIRECTOR);
        $stmt->bindParam(":names", $director->getFullName(), PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetchAll()[0] ?? null;
        return $result["id"] ?? 0;
    }
}