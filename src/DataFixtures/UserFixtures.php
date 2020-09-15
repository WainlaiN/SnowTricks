<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Services\UploadHelper;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    private $encoder;

    public function __construct(UploadHelper $uploadHelper, UserPasswordEncoderInterface $encoder)
    {
        $this->uploadHelper = $uploadHelper;
        $this->encoder = $encoder;
    }

    public function loadData(ObjectManager $manager)
    {

        //publish many users
        for ($i = 0; $i <= 9; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email)
                ->setUsername($this->faker->userName)
                ->setPassword($this->faker->password)
                ->setRoles();

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

        //Add user and admin access to test
        $role_user= new User();
        $role_user->setEmail("user@gmail.com")
            ->setUsername("User")
            ->setPassword($this->encoder->encodePassword($role_user, "user"))
            ->setRoles();
        $this->manager->persist($role_user);

        $role_admin= new User();
        $role_admin->setEmail("admin@gmail.com")
            ->setUsername("Admin")
            ->setPassword($this->encoder->encodePassword($role_admin, "admin"))
            ->setAdminRoles();
        $this->manager->persist($role_admin);

        $manager->flush();
    }
}

