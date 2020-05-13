<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;


class CategoryFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {

        //publish many categories
        $this->createMany(Category::class, 3, function (Category $category, $count) {

            $category->setTitle($this->faker->sentence())
                ->setDescription($this->faker->paragraph());

        });

        $manager->flush();
    }
}
