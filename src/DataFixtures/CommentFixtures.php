<?php

namespace App\DataFixtures;


use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {

        //publish many comments
        $this->createMany(Comment::class, 50, function (Comment $comment, $count) {

            $comment->setContent($this->faker->sentence())
                ->setCreatedAt($this->faker->dateTimeBetween('-6 months'))
                ->setTrick($this->getRandomReference(Trick::class))
                ->setUser($this->getRandomReference(User::class));

        });

        $manager->flush();

    }

    public function getDependencies()
    {
        return [UserFixtures::class, TrickFixtures::class];
    }
}
