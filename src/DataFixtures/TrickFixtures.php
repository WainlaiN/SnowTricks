<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Services\Slugify;
use App\Services\UploadHelper;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trick;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;


class TrickFixtures extends BaseFixture implements DependentFixtureInterface
{
    private static $tricksDemoNames = [
        'Mute',
        'Indy',
        '360',
        '720',
        'Backflip',
        'Tail slide',
        'Method air',
        'Backside air',
    ];
    private static $mainImages = [
        'mute.jpg',
        'Indy.jpg',
        '360.jpg',
        '720.jpg',
        'backflip.jpg',
        'tailslide.jpg',
        'methodair.jpg',
        'backsideair.jpg',
    ];
    private static $description = [
        'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant',
        'Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière',
        'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant',
        'Saisie de la carre backside de la planche entre les deux pieds avec la main arrière',
        'Saisie de la partie arrière de la planche, avec la main arrière',
        'Saisie de la partie avant de la planche, avec la main avant',
        'Saisie de la carre backside de la planche entre les deux pieds avec la main arrière',
        'Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière',
    ];

    private $uploadHelper;

    public function __construct(UploadHelper $uploadHelper)
    {
        $this->uploadHelper = $uploadHelper;
    }

    public function loadData(ObjectManager $manager)
    {
        //publish many tricks
        for ($i = 0; $i <= 7; $i++) {
            $trick = new Trick();
            $trick->setName(self::$tricksDemoNames[$i])
                ->setDescription(self::$description[$i])
                ->setCreatedAt(new \DateTime())
                ->setSlug(Slugify::slugify($trick->getName()))
                ->setCategory($this->getRandomReference(Category::class))
                ->setUserId($this->getRandomReference(User::class));

            $image = self::$mainImages[$i];

            $fs = new Filesystem();
            $targetPath = sys_get_temp_dir().'/'.$image;
            $fs->copy(__DIR__.'/mainImage/'.$image, $targetPath, true);

            $imageFileName = $this->uploadHelper->saveMainFile(new File($targetPath));
            $trick->setMainImage($imageFileName);

            $this->manager->persist($trick);
            //store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference(Trick::class.'_'.$i, $trick);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class, UserFixtures::class];
    }


}
