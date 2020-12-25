<?php


namespace App\Classes;


class Tools {
    public static function dieObject($object, $kill = true) {
        var_dump($object);

        if ($kill)
            die('END');

        return $object;
    }

    public static function dieOrLog($msg, $kill = true) {
        if ($kill) {
            header('HTTP/1.1 500 Internal Server Error', true, 500);
            die($msg);
        }
    }
}