<?php


namespace App\Services;


class VideoHelper
{
    const YOUTUBE_URL = "https://www.youtube.com/embed/";
    const DAILYMOTION_URL = "https://www.dailymotion.com/embed/video/";

    public function getIdFromUrl($url)
    {

        if (strpos($url, "youtu") !== false) {

            if (strpos($url, "v=") !== false) {

                $id = substr($url, strpos($url, "v=") + 2, 11);

                return self::YOUTUBE_URL.$id;

            } elseif (strpos($url, "embed/") !== false) {

                $id = substr($url, strpos($url, "embed/") + 6, 11);

                return self::YOUTUBE_URL.$id;
            }

        } elseif (strpos($url, "dailymotion") !== false) {

            if (strpos($url, "video/")) {

                $id = substr($url, strpos($url, "video/") + 6, 7);

                //dump($id);

                return self::DAILYMOTION_URL.$id;
            }

        }
    }


    public function getPlatformFromUrl($url)
    {
        if (strpos($url, "youtu") !== false) {

            return $platform = 'youtube';

        } elseif (strpos($url, "dailymotion")) {

            return $platform = 'dailymotion';
        }


    }

}