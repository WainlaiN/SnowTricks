<?php

namespace App\DataFixtures;

use App\Entity\Video;
use App\Entity\Trick;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {

        //publish many videos
        $this->createMany(Video::class,30,function (Video $video, $count) {

            $video->setVideoURL("https://www.youtube.com/embed/1TJ08caetkw")
                ->setTrick($this->getRandomReference(Trick::class));


        });

        $manager->flush();

    }

    public function getDependencies()
    {
        return [TrickFixtures::class];
    }
}
