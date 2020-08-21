<?php

namespace App\Services;

class Slugify
{
    public static function slugify($str, $delimiter = '-')
    {
        $accents = '/&([A-Za-z]{1,2})(grave|acute|circ|cedil|uml|lig);/';
        $string_encoded = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
        $str = preg_replace($accents, '$1', $string_encoded);
        $str = strtolower(trim($str));
        $str = preg_replace('/[^A-Za-z0-9-]+/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);

        return rtrim($str, '-');
    }

}
