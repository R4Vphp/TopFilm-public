<?php

namespace App\Model\List;

use App\Controller\Sorting;

class Browser {

    private string $query;
    private int $sorting;

    public function __construct(){
        $this->query = "";
        $this->sorting = 0;
    }

    public function getQuery(){
        return $this->query;
    }
    public function getSorting(){
        return $this->sorting;
    }

    public function setQuery($query){
        $this->query = $query;
    }
    public function setSorting($sorting){
        $this->sorting = $sorting;
    }
}