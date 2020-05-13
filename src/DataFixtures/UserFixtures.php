<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {

        //publish many users
        $this->createMany(User::class, 10, function (User $user, $count) {

            $user->setEmail($this->faker->email)
                ->setUsername($this->faker->userName)
                ->setPassword($this->faker->password)
                ->setPhoto("https://www.lepetitlitteraire.fr/uploads/images/author/anonyme.jpeg");

        });

        $manager->flush();
    }
}
