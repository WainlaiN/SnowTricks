<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Trick;
use App\Services\UploadHelper;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class ImageFixtures extends BaseFixture implements DependentFixtureInterface
{
    private static $mainImages = [
        '1.jpg',
        '2.jpg',
        '3.jpg',
        '4.jpg',
        '5.jpg',
        '6.jpg',
        '7.jpg',
        '8.jpg',
        '9.jpg',
        '10.jpg',
        '11.jpg',
        '12.jpg',
        '13.jpg',
        '14.jpg',
        '15.jpg',
        '16.jpg',
        '17.jpg',
        '18.jpg',
        '19.jpg',
        '20.jpg',
        '21.jpg',
        '22.jpg',
        '23.jpg',
        '24.jpg',
        '25.jpg',
        '26.jpg',
    ];

    private $uploadHelper;

    public function __construct(UploadHelper $uploadHelper)
    {
        $this->uploadHelper = $uploadHelper;
    }


    public function loadData(ObjectManager $manager)
    {
        //publish many tricks
        for ($i = 0; $i <= 25; $i++) {
            $image = new Image();
            $image->setTrick($this->getRandomReference(Trick::class));

            $imageFile = self::$mainImages[$i];

            $fileSystem = new Filesystem();
            $targetPath = sys_get_temp_dir().'/'.$imageFile;
            $fileSystem->copy(__DIR__.'/images/'.$imageFile, $targetPath, true);

            $imageFileName = $this->uploadHelper->saveMainFile(new File($targetPath));
            $image->setImageFilename($imageFileName);

            $this->manager->persist($image);
            //store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference(Image::class.'_'.$i, $image);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [TrickFixtures::class];
    }
}
