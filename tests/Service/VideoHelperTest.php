<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Services\VideoHelper;

class VideoHelperTest extends TestCase
{
    public function testIsEncodedYoutubeCorrectly()
    {
        $string = "https://www.youtube.com/watch?v=sxcvaT5mua0";
        $string2 = "https://youtu.be/sxcvaT5mua0";
        $string3 = "<iframe width=\"1280\" height=\"720\" src=\"https://www.youtube.com/embed/sxcvaT5mua0\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
        $correctYoutubeUrl = "https://www.youtube.com/embed/sxcvaT5mua0";

        $videoHelper = new VideoHelper();
        $this->assertEquals($videoHelper->extractPlatformFromURL($string), $correctYoutubeUrl);
        $this->assertEquals($videoHelper->extractPlatformFromURL($string2), $correctYoutubeUrl);
        $this->assertEquals($videoHelper->extractPlatformFromURL($string3), $correctYoutubeUrl);

    }

    public function testIsEncodedDailymotionCorrectly()
    {
        $string = "https://www.dailymotion.com/video/xcegta";
        $string2 = "https://dai.ly/xcegta";
        $correctDailymotionUrl = "https://www.dailymotion.com/embed/video/xcegta";
        $correctDailymotionUrl = "<div style=\"position:relative;padding-bottom:56.25%;height:0;overflow:hidden;\"> <iframe style=\"width:100%;height:100%;position:absolute;left:0px;top:0px;overflow:hidden\" frameborder=\"0\" type=\"text/html\" src=\"https://www.dailymotion.com/embed/video/xcegta\" width=\"100%\" height=\"100%\" allowfullscreen > </iframe> </div>
";

        $videoHelper = new VideoHelper();
        $this->assertEquals($videoHelper->extractPlatformFromURL($string), $correctDailymotionUrl);
        $this->assertEquals($videoHelper->extractPlatformFromURL($string2), $correctDailymotionUrl);

    }
}
