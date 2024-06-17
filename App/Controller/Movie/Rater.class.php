<?php

namespace App\Controller\Movie;

use App\Model\User;
use App\Database\Connection;
use App\Database\SQL;
use App\Utility\Notification;
use PDO;

class Rater {

    const SUCCESS = "Selected movie successfully rated at ";

    public function execute(){

        $userId = User::getLogged()->getId();
        $movieId = $_POST["RATE"] ?? 0;
        $rating = min(max($_POST["movieRating"] ?? 0, 0), 10);

        $stmt = Connection::new()->prepare(SQL::UPDATE_RATING);
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $stmt->bindParam(":movieId", $movieId, PDO::PARAM_INT);
        $stmt->bindParam(":rating", $rating, PDO::PARAM_INT);
        $stmt->execute();

        Notification::setMessage(self::SUCCESS.$rating);
    }

    public static function options($selected){

        forEach(range(0, 10) as $rating) echo "<option value='$rating' ".($selected == $rating ? "selected" : null).">$rating</option>";
    }
}