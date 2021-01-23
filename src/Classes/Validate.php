<?php


namespace App\Classes;

use \DateTime;

class Validate {

    public static function isDate($date) : bool {
        $dt = DateTime::createFromFormat('Y-m-d', $date);
        return $dt !== false && !array_sum($dt::getLastErrors());
    }

    public static function isPesel($pesel) : bool {
        $pattern = '/^[0-9]{11}$/';
        if (!preg_match($pattern, $pesel))
            return false;
        else {
            $digits = str_split($pesel);
            $checksum = 0;

            if ((intval(substr($pesel, 4, 2)) > 31
                || intval(substr($pesel, 2, 2)) > 12))
                return false;

            for ($i = 0; $i < 10; $i++) {
                if ($i === 0
                    || $i === 4
                    || $i === 8)
                    $checksum += intval($digits[$i]);
                elseif ($i === 1
                    || $i === 5
                    || $i === 9)
                    $checksum += 3 * intval($digits[$i]);
                elseif ($i === 2 || $i === 6)
                    $checksum += 7 * intval($digits[$i]);
                else
                    $checksum += 9 * intval($digits[$i]);
            }
            $checksum %= 10;
            if ($checksum === 0)
                $checksum = 10;
            $checksum = 10 - $checksum;
            return intval($digits[10]) === $checksum;
        }
    }

    public static function isPassword(string $passwd = '') : bool {
        if (strlen($passwd)) {
            $uppercase = preg_match('#[A-Z]+#', $passwd);
            $lowercase = preg_match('#[a-z]+#', $passwd);
            $number    = preg_match('#[0-9]+#', $passwd);
            $specialChars = preg_match('#[\w]+#', $passwd);

            return $uppercase
                && $lowercase
                && $number
                && strlen($passwd) > 7
                && strlen($passwd) <= 32;
        }
        return false;
    }

    public static function isName(string $name = '') : bool {
        if (strlen($name) >= 3 && strlen($name) <= 32)
            return (!preg_match('/\W/', $name)
                && preg_match('/[a-zA-Z]{3,}/', $name)
                && !preg_match('/\d/', $name));

        return false;
    }
}