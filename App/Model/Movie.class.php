<?php

namespace App\Model;

use App\Model\User;
use App\Database\Connection;
use App\Database\SQL;
use App\Scrapping\Filmweb;
use PDO;

class Movie {

    const NOVELTY_TIME = 172800;

    private int $id;
    private string $originalTitle;
    private string $polishTitle;
    private int $productionYear;
    private int $duration;
    private Director $director;
    private bool $watched;
    private int $rating;
    private ?string $image;
    private int $uploadAt;
    private int $originListId;

    public function __construct($id, $orgTitle, $plTitle, $prodYear, $duration, $director, $watched, $rating, $image, $uploadAt){

        $this->id = $id;
        $this->originalTitle = $orgTitle;
        $this->polishTitle = $plTitle;
        $this->productionYear = $prodYear;
        $this->duration = $duration;
        $this->director = $director;
        $this->watched = $watched ?? false;
        $this->rating = $rating ?? 0;
        $this->image = $image;
        $this->uploadAt = $uploadAt;
    }
    public function setOrigin($origin){
        $this->originListId = $origin;
    }
    public function getOrigin(){
        return $this->originListId ?? 0;
    }

    public function __toString(){

        return require BASE_PATH . "/components/model/listTileMovie.class.html.php";
    }

    public static function download($movieId){

        $userId = User::getLogged()->getId();

        $stmt = Connection::new()->prepare(SQL::SELECT_MOVIE);
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $stmt->bindParam(":movieId", $movieId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll()[0] ?? 0;

        if(!$result){
            return self::dummy();    
        }

        return new Movie(
            $result["movieId"],
            $result["originalTitle"],
            $result["polishTitle"],
            $result["productionYear"],
            $result["duration"] ?? 0,
            new Director(
                $result["directorId"],
                $result["firstName"],
                $result["lastName"]
            ),
            $result["watched"],
            $result["rating"],
            $result["image"],
            time(),
        );

    }

    public function getId(){
        return $this->id;
    }
    public function getPolishTitle(){
        return $this->polishTitle;
    }
    public function getOriginalTitle(){
        return $this->originalTitle;
    }
    public function getProductionYear(){
        return $this->productionYear;
    }
    public function getDuration(){
        return $this->duration;
    }
    public function getRating(){
        return $this->rating;
    }
    public function isWatched(){
        return $this->watched;
    }
    public function getDirector(){
        return $this->director;
    }
    public function generateLink(){
        return Filmweb::URL_PREFIX."/film"."/".urlencode($this->polishTitle)."-".$this->productionYear."-".$this->id;
    }
    public function getImage(){
        return $this->image;
    }
    public function getUploadAt(){
        return $this->uploadAt;
    }
    public function generateImage(){

        $id = strval($this->id);

        $path = ["A" => "00", "B" => "00", "AB" => "00"];

        $path["AB"] = $id;

        $id = "0000".$id;

        $path["B"] = substr($id, -2);
        $path["A"] = substr($id, -4, 2);

        $path = array_filter($path);

        return Filmweb::IMG_PREFIX.implode("/", $path)."/".$this->image.Filmweb::IMG_SUFFIX;
    }

    public static function dummy(){
        return new Movie(
            0, "%ORIGINAL_TITLE%", "%POLISH_TITLE%", 0, 0,
            new Director(
                0,
                "%FIRST_NAME%",
                "%LAST_NAME%"
            ), 0, 0, "", time()
        );
    }

    private function isNew(){

        return ((time() - $this->uploadAt) < self::NOVELTY_TIME);
    }
}