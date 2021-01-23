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

    public static function isEmail(string $email = '') : bool {
        return (strlen($email) >= 3
            && strlen($email) <= 180
            && filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    public static function isCleanHtml($html, $allow_iframe = false) {
        $events = 'onmousedown|onmousemove|onmmouseup|onmouseover|onmouseout|onload|onunload|onfocus|onblur|onchange';
        $events .= '|onsubmit|ondblclick|onclick|onkeydown|onkeyup|onkeypress|onmouseenter|onmouseleave|onerror|onselect|onreset|onabort|ondragdrop|onresize|onactivate|onafterprint|onmoveend';
        $events .= '|onafterupdate|onbeforeactivate|onbeforecopy|onbeforecut|onbeforedeactivate|onbeforeeditfocus|onbeforepaste|onbeforeprint|onbeforeunload|onbeforeupdate|onmove';
        $events .= '|onbounce|oncellchange|oncontextmenu|oncontrolselect|oncopy|oncut|ondataavailable|ondatasetchanged|ondatasetcomplete|ondeactivate|ondrag|ondragend|ondragenter|onmousewheel';
        $events .= '|ondragleave|ondragover|ondragstart|ondrop|onerrorupdate|onfilterchange|onfinish|onfocusin|onfocusout|onhashchange|onhelp|oninput|onlosecapture|onmessage|onmouseup|onmovestart';
        $events .= '|onoffline|ononline|onpaste|onpropertychange|onreadystatechange|onresizeend|onresizestart|onrowenter|onrowexit|onrowsdelete|onrowsinserted|onscroll|onsearch|onselectionchange';
        $events .= '|onselectstart|onstart|onstop';

        if (preg_match('/<[\s]*script/ims', $html) || preg_match('/(' . $events . ')[\s]*=/ims', $html) || preg_match('/.*script\:/ims', $html)) {
            return false;
        }

        if (!$allow_iframe && preg_match('/<[\s]*(i?frame|form|input|embed|object)/ims', $html)) {
            return false;
        }

        return true;
    }
}