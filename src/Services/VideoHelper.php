<?php


namespace App\Services;


class VideoHelper
{
    public function getIdFromUrl($url) {
         $test = preg_match("#([\/|\?|&]vi?[\/|=]|youtu\.be\/|embed\/)([a-zA-Z0-9_-]+)#", $link, $matches);
        //var_dump(end($matches));
        dd($test);
    }

    public function encodeURL($id) {

    }

}