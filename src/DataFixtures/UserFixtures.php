<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Services\UploadHelper;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class UserFixtures extends BaseFixture
{
    private static $picture = [
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
    ];

    private $uploadHelper;

    public function __construct(UploadHelper $uploadHelper)
    {
        $this->uploadHelper = $uploadHelper;
    }

    public function loadData(ObjectManager $manager)
    {

        //publish many tricks
        for ($i = 0; $i <= 9; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email)
                ->setUsername($this->faker->userName)
                ->setPassword($this->faker->password);

            $picture = self::$picture[$i];

            $fileSystem = new Filesystem();
            $targetPath = sys_get_temp_dir().'/'.$picture;
            $fileSystem->copy(__DIR__.'/pictures/'.$picture, $targetPath, true);

            $photo = $this->uploadHelper->savePicture(new File($targetPath));
            $user->setPhoto($photo);

            $this->manager->persist($user);
            //store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference(User::class.'_'.$i, $user);
        }

        $manager->flush();
    }
}

