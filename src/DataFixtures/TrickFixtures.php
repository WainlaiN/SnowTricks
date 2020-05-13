<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trick;


class TrickFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        //$faker = Factory::create('fr_FR');

        $this->createMany(Trick::class, 50, function (Trick $trick, $count) use ($faker) {

            //publish many tricks
            $content = '<p>'.join($this->faker->paragraphs(5), '</p><p>').'</p>';

            $trick->setName($this->faker->sentence())
                ->setDescription($content)
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setCategory($this->getReference(Category::class.'-'.$this->faker->numberBetween(0,3)));


        });

        $manager->flush();

    }
}
