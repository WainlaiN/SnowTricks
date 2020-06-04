<?php

namespace App\DataFixtures;

use App\Entity\Video;
use App\Entity\Trick;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends BaseFixture implements DependentFixtureInterface
{
    private static $tricksDemoVideos = [
        'https://www.youtube.com/embed/n0F6hSpxaFc',
        'https://www.youtube.com/embed/R2Cp1RumorU',
        'https://www.youtube.com/embed/SFYYzy0UF-8',
        'https://www.youtube.com/embed/crDzvmi91XQ',
        'https://www.youtube.com/embed/V9xuy-rVj9w',
        'https://www.youtube.com/embed/dSZ7_TXcEdM',
        'https://www.youtube.com/embed/m2jMAbjfSII',
        'https://www.youtube.com/embed/2iYibvfBiXE',
        'https://www.youtube.com/embed/JiVKdWt_92c',
        'https://www.youtube.com/embed/YgH8bQC_Oxg',
        'https://www.youtube.com/embed/bEIRN6FY6mg',
        'https://www.youtube.com/embed/FPxUcCTfFVk',
        'https://www.youtube.com/embed/qtF3_KELVVI',
        'https://www.youtube.com/embed/vZhf03Prvec',
        'https://www.youtube.com/embed/7b_o94_Xw0o',
        'https://www.youtube.com/embed/kb1WRcEn6FQ',
    ];


    public function loadData(ObjectManager $manager)
    {

        for ($i = 0; $i <= 15; $i++) {
            $randKeys = array_rand(self::$tricksDemoVideos);

            $video = new Video();
            $video->setVideoURL(self::$tricksDemoVideos[$randKeys])
                ->setTrick($this->getRandomReference(Trick::class));
            $this->manager->persist($video);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return [TrickFixtures::class];
    }
}
