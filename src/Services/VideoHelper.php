<?php


namespace App\Services;


class VideoHelper
{
    public function getIdFromUrl($url)
    {
        //$test = preg_match("#([\/|\?|&]vi?[\/|=]|youtu\.be\/|embed\/)([a-zA-Z0-9_-]+)#", $url, $matches);

        if (strpos($url, "youtu") !== false) {

            if (strpos($url, "v=") !== false) {

                $id = substr($url, strpos($url, "v=") + 2, 11);
                return $id;

            } elseif (strpos($url, "embed/") !== false) {

                $id = substr($url, strpos($url, "embed/") + 6, 11);
                return $id;
            }

        } elseif (strpos($url, "dailymotion")) {

            $id = substr($url, strpos($url, "embed/video/") + 12, 11);
        }
    }


    public function encodeURL($id)
    {

    }

}