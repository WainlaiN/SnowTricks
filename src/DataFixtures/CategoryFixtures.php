<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;


class CategoryFixtures extends BaseFixture
{
    private static $categoriesDemoName = ['Grabs', 'Rotations', 'Flips', 'Slides', 'One foot'];
    private static $categoriesDemoDescription = [
        'Un grab consiste à attraper la planche avec la main pendant le saut',
        'On désigne par le mot rotation uniquement des rotations horizontales',
        'Un flip est une rotation verticale',
        'Un slide consiste à glisser sur une barre de slide',
        'Figures réalisée avec un pied décroché de la fixation',
    ];

    public function loadData(ObjectManager $manager)
    {

        //publish many categories
        for ($i = 0; $i <= 4; $i++) {
            $category = new Category();
            $category->setTitle(self::$categoriesDemoName[$i]);
            $category->setDescription(self::$categoriesDemoDescription[$i]);
            $this->manager->persist($category);
            //store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference(Category::class.'_'.$i, $category);
        }

        $manager->flush();
    }
}
