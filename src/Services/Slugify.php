<?php

namespace App\Services;

class Slugify
{
    public static function slugify($str, $delimiter = '-')
    {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        return rtrim($str, '-');


    }
    /**{
        $text = strtolower(
            trim(
                preg_replace(
                    '/[\s-]+/',
                    $delimiter,
                    preg_replace(
                        '/[^A-Za-z0-9-]+/',
                        $delimiter,
                        preg_replace(
                            '/[&]/',
                            'and',
                            preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $text))
                        )
                    )
                ),
                $delimiter
            )
        );

        return $text;

    }**/

}
