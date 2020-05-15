<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {

        //publish many Images
        $this->createMany(Image::class,100,function (Image $image, $count) {

                $image->setImageFilename("http://via.placeholder.com/300x150")
                    ->setTrick($this->getRandomReference(Trick::class));


        });

        $manager->flush();

    }

    public function getDependencies()
    {
        return [TrickFixtures::class];
    }
}
