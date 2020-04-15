<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Trick;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=1; $i <= 10; $i++){
            $trick = new Trick();
            $trick->setName("Titre de la figure n°$i")
                ->setDescription("<p>Description de la figure n°$i</p>")
                ->setImage("http://placehold.it/350x150")
                ->setCreatedAt(new \DateTime())
                ->setCategory("Categorie de la figure n°$i")
                ->setVideo("http://placehold.it/350x150");
            $manager->persist($trick);

        }

        $manager->flush();
    }
}
