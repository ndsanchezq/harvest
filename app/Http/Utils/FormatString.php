<?php

namespace App\Http\Utils;

class FormatString
{
    /**
     * fill string with a character till a specific lenght
     */
    public static function fill($string, $character, $length, $fill_after = false)
    {
        if (strlen($string) < $length) {
            return $fill_after
                ? $string . str_repeat($character, $length - strlen($string)) // fill character after string
                : str_repeat($character, $length - strlen($string)) . $string; // fill character before string
        }

        if (strlen($string) > $length) {
            return substr($string, 0, $length);
        }

        return $string;
    }
}
