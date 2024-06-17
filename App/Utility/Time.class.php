<?php

namespace App\Utility;

class Time {

    const SECOND = 1;
    const MINUTE = 60;
    const HOUR = self::MINUTE * 60;
    const DAY = self::HOUR * 24;
    const WEEK = self::DAY * 7;
    const MONTH = self::DAY * 31;
    const YEAR = self::DAY * 365;

    public static function formatDate($unix){

        return date("d/m/Y", $unix - 60*60);
    }
    public static function formatTime($unix){

        return date("H:i:s", $unix - 60*60);
    }
    public static function formatDateTime($unix){

        return date("H:i:s d/m/Y", $unix - 60*60);
    }

}