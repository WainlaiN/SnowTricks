<?php

namespace App\Services;

class Slugify
{
    public static function slugify($str, $delimiter = '-')
    {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^A-Za-z0-9-]+/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);

        return rtrim($str, '-');
    }

}
