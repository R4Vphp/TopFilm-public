<?php

namespace App\Scrapping;

use App\Model\Movie;
use App\Model\Director;
use DOMDocument;
use DOMXPath;

class Filmweb {

    const URL_PREFIX = "https://www.filmweb.pl";
    
    const IMG_PREFIX = "https://fwcdn.pl/fpo/";
    const IMG_SUFFIX = "_1.6.jpg";

    const LINK_NOT_TRACKED = "Movie not found.";
    
    private DOMXPath $xPath;

    public function trackMovie(){

        $this->xPath = $this->initXPath();

        if($this->scrapError()){
            Notification::setMessage(self::LINK_NOT_TRACKED);
            return false;
        }

        $link = $this->link;
        $id = substr($link, strrpos("-$link", '-'));

        $plTitle = $this->scrapPolishTitle();
        $orgTitle = $this->scrapOriginalTitle();
        if(!$orgTitle ? $orgTitle = $plTitle : $orgTitle);

        $prodYear = $this->scrapProductionYear();
        
        $duration = $this->scrapDuration();
        
        $director = $this->scrapDirector();

        $image = $this->scrapImage();

        return new Movie($id, $orgTitle, $plTitle, $prodYear, $duration, $director, 0, 0, $image, time());
    }

    private function scrapError(){

        return $this->xPath->query("//*[@class='error__description']")[0]->nodeValue ?? null;
    }
    private function scrapPolishTitle(){

        return $this->xPath->query("//*[@class='filmCoverSection__title ']")[0]->nodeValue ?? $this->xPath->query("//*[@class='filmCoverSection__title filmCoverSection__title--large']")[0]->nodeValue ?? null;
    }
    private function scrapOriginalTitle(){

        return $this->xPath->query("//*[@class='filmCoverSection__originalTitle']")[0]->nodeValue ?? null;
    }
    private function scrapProductionYear(){

        return $this->xPath->query("//*[@class='filmCoverSection__year']")[0]->nodeValue ?? null;
    }
    private function scrapDuration(){

        try{
            $duration = $this->xPath->query("//*[@class='filmCoverSection__duration']")[0]->getAttribute('data-duration') ?? null;
        }catch(Throwable $e){
            return 0;
        }
        return $duration;
    }
    private function scrapDirector(){

        $director = $this->xPath->query("//*[@itemprop='director']")[0]->nodeValue ?? null;
        $director = explode(" ", $director);

        return new Director(0,
            $director[0],
            implode(' ', array_slice($director, 1))
        );
    }
    private function scrapImage(){

        try{
            $fullPath = $this->xPath->query("//*[@id='filmPoster']")[0]->getAttribute('src') ?? null;
        } 

        catch(Throwable $e){
            return null;
        }
        
        return str_replace(self::IMG_SUFFIX, "", substr($fullPath, strrpos("/$fullPath", '/')));
    }

    private function initXPath(){
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($ch);
        curl_close($ch);

        $dom = new DOMDocument();
        try{
            @$dom->loadHTML($html, LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED);
        }catch(Throwable $e){
            Notification::setMessage(self::LINK_NOT_TRACKED);
            header("Location: ../archive.php");
            exit();
        }
        return new DOMXPath($dom);
    }
}