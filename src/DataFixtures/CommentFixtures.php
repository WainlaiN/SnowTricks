<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends BaseFixture implements DependentFixtureInterface
{
    private static $tricksComments = [
        'Très difficile à réaliser!',
        'Figure très dangereuse mais magnifique à voir!!',
        'Super',
        'Génial',
        'Je commence à la maitriser',
        'Merci pour ce site. J\'ai enfin les informations intéressantes concernant le monde du snowboard',
        'Merci pour les infos, il ne reste plus qu\'à pratiquer',
        'Figure trop difficile pour un débutant',
        'C\'est la figure de Tony Hawk!!',
        'Quelqu\'un pourrait expliquer la figure en détail?',
    ];

    public function loadData(ObjectManager $manager)
    {

        //publish many comments
        $this->createMany(
            Comment::class,
            50,
            function (Comment $comment, $count) {

                $randkeys = array_rand(self::$tricksComments);

                $comment->setContent(self::$tricksComments[$randkeys])
                    ->setCreatedAt($this->faker->dateTimeBetween('-6 months'))
                    ->setTrick($this->getRandomReference(Trick::class))
                    ->setUser($this->getRandomReference(User::class));

            }
        );

        $manager->flush();

    }

    public function getDependencies()
    {
        return [UserFixtures::class, TrickFixtures::class];
    }
}
