<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Trick;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 3; $i++) {
            $category = new Category();
            $category->setTitle($faker->sentence())
                ->setDescription($faker->paragraph());

            $manager->persist($category);

            for ($j = 1; $j <= mt_rand(4, 6); $j++) {
                $trick = new Trick();

                $content = '<p>'.join($faker->paragraphs(5), '</p><p>').'</p>';

                $trick->setName($faker->sentence())
                    ->setDescription($content)
                    ->setImage($faker->imageUrl())
                    ->setVideo($faker->imageUrl())
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);

                $manager->persist($trick);

                for ($k = 1; $k >= mt_rand(4, 10); $k++) {
                    $comment = new Comment();
                    $content2 = '<p>'.join($faker->paragraphs(2), '</p><p>').'</p>';

                    $days = (new \DateTime())->diff($trick->getCreatedAt())->days;

                    $comment->setAuthor($faker->name)
                        ->setContent($content2)
                        ->setCreatedAt($faker->dateTimeBetween('-'.$days.' days'))
                        ->setTrick($trick);

                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}
