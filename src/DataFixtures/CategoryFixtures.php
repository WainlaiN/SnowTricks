<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class CategoryFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        //$faker = Factory::create('fr_FR');

        $this->createMany(Category::class, 3, function (Category $category, $count) {

            //publish many categories
            $category->setTitle($this->faker->sentence())
                ->setDescription($this->faker->paragraph());



        });

        $manager->flush();
    }
}
