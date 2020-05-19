<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Image;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trick;


class TrickFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {

        //publish many tricks
        $this->createMany(Trick::class, 10, function (Trick $trick, $count) {

            $content = '<p>'.join($this->faker->paragraphs(2), '</p><p>').'</p>';


            $trick->setName($this->faker->sentence())
                ->setDescription($content)
                ->setCreatedAt($this->faker->dateTimeBetween('-6 months'))
                ->setCategory($this->getRandomReference(Category::class));


        });

        $manager->flush();

    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }


}
