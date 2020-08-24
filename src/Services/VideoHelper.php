<?php


namespace App\Services;


class VideoHelper
{
    const YOUTUBE_URL = "https://www.youtube.com/embed/";
    const DAILYMOTION_URL = "https://www.dailymotion.com/embed/video/";

    public function extractPlatformFromURL($url)
    {
        if (strpos($url, "youtu") !== false) {
            return $this->encodeYoutube($url);

        } elseif (strpos($url, "dailymotion") !== false || strpos($url, "dai.ly") !== false) {
            return $this->encodeDailymotion($url);
        }

    }

    private function encodeYoutube($url)
    {
        if (strpos($url, "v=") !== false) {

            $id = substr($url, strpos($url, "v=") + 2, 11);

            return self::YOUTUBE_URL.$id;

        } elseif (strpos($url, "embed/") !== false) {

            $id = substr($url, strpos($url, "embed/") + 6, 11);

            return self::YOUTUBE_URL.$id;

        } elseif (strpos($url, "youtu.be/") !== false) {

            $id = substr($url, strpos($url, "youtu.be/") + 9, 11);

            return self::YOUTUBE_URL.$id;

        }
    }

    private function encodeDailymotion($url)
    {
        if (strpos($url, "video/")) {

            $id = substr($url, strpos($url, "video/") + 6, 7);

            return self::DAILYMOTION_URL.$id;

        } elseif (strpos($url, "dai.ly/")) {

            $id = substr($url, strpos($url, "dai.ly/") + 7, 7);

            return self::DAILYMOTION_URL.$id;

        }
    }
}
