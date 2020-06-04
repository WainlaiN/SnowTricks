<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Image;
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
            $trick->setName(self::$tricksDemoNames[$i]);

            $content = '<p>'.join($this->faker->paragraphs(2), '</p><p>').'</p>';
            $trick->setDescription($content)
                ->setCreatedAt(new \DateTime())
                ->setSlug(Slugify::slugify($trick->getName()))
                ->setCategory($this->getRandomReference(Category::class));

            $image = self::$mainImages[$i];

            $fs = new Filesystem();
            $targetPath = sys_get_temp_dir().'/'.$image;
            $fs->copy(__DIR__.'/images/'.$image, $targetPath, true);

            $imageFileName = $this->uploadHelper->saveMainFile(new File($targetPath));
            $trick->setMainImage($imageFileName);

            $this->manager->persist($trick);
            //store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference(Trick::class.'_'.$i, $trick);
        }

        /**$this->createMany(Trick::class, 10, function (Trick $trick, $count) {
         *
         * $content = '<p>'.join($this->faker->paragraphs(2), '</p><p>').'</p>';
         * $trick->setName($this->faker->sentence())
         * ->setDescription($content)
         * ->setCreatedAt($this->faker->dateTimeBetween('-6 months'))
         * ->setCategory($this->getRandomReference(Category::class));
         *
         *
         * });**/
        $manager->flush();

    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }


}
