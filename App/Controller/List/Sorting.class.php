<?php

namespace App\Controller\List;

use App\Database\SQL;

class Sorting {

    public string $title;
    public string $query;

    private function __construct($title, $query){

        $this->title = $title;
        $this->query = $query;
    }

    public static function all(){

        return [
            new Sorting("Po tytule, alfabetycznie", SQL::BY_TITLE." ".SQL::ASC),
            new Sorting("Po tytule, odwrotnie-alfabetycznie", SQL::BY_TITLE." ".SQL::DESC),
            new Sorting("Po roku produkcji, od najstarszych", SQL::BY_YEAR." ".SQL::ASC),
            new Sorting("Po roku produkcji, od najnowszych", SQL::BY_YEAR." ".SQL::DESC),
            new Sorting("Po długości, od najkrótszych", SQL::BY_DURATION." ".SQL::ASC),
            new Sorting("Po długości od najdłuższych", SQL::BY_DURATION." ".SQL::DESC),
            new Sorting("Po ocenie, od najlepszych", SQL::BY_RATING." ".SQL::DESC),
            new Sorting("Po ocenie, od najgorszych", SQL::BY_RATING." ".SQL::ASC),
            new Sorting("Po czasie dodania, od najstarszych", SQL::BY_UPLOAD." ".SQL::ASC),
            new Sorting("Po czasie dodania, od najnowszych", SQL::BY_UPLOAD." ".SQL::DESC)
        ];

    }

    public static function print($current = null){

        forEach(self::all() as $key => $option) echo "<option value='$key' ".($current == $key ? "selected" : null).">".$option->title."</option>";
    }

}