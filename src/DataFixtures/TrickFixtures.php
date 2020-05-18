<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trick;


class TrickFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {

        //publish many tricks
        $this->createMany(Trick::class, 30, function (Trick $trick, $count) {

            $content = '<p>'.join($this->faker->paragraphs(2), '</p><p>').'</p>';


            $trick->setName($this->faker->sentence())
                ->setDescription($content)
                ->setCreatedAt($this->faker->dateTimeBetween('-6 months'))
                ->setCategory($this->getRandomReference(Category::class))
                ->setMainImage('1f4b10ecfb1273691b1d0a7c2ca32f38.jpeg');

        });

        $manager->flush();

    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }


}
