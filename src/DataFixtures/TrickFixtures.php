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


        /**$faker = \Faker\Factory::create('fr_FR');
         *
         *
         * for ($i = 1; $i <= 3; $i++) {
         * $category = new Category();
         * $category->setTitle($faker->sentence())
         * ->setDescription($faker->paragraph());
         *
         * $manager->persist($category);
         *
         * for ($j = 1; $j <= 40; $j++) {
         * $trick = new Trick();
         *
         * $content = '<p>'.join($faker->paragraphs(5), '</p><p>').'</p>';
         *
         * $trick->setName($faker->sentence())
         * ->setDescription($content)
         * ->setCreatedAt($faker->dateTimeBetween('-6 months'))
         * ->setCategory($category);
         *
         *
         * $manager->persist($trick);
         *
         * for ($k = 1; $k <= mt_rand(4, 10); $k++) {
         * $comment = new Comment();
         * $content2 = '<p>'.join($faker->paragraphs(2), '</p><p>').'</p>';
         *
         * $days = (new \DateTime())->diff($trick->getCreatedAt())->days;
         *
         * $comment->setUser($faker->name)
         * ->setContent($content2)
         * ->setCreatedAt($faker->dateTimeBetween('-'.$days.' days'))
         * ->setTrick($trick);
         *
         * $manager->persist($comment);
         * }
         * }
         * }
         *
         * for ($k = 1; $k <= 10; $k++) {
         * $user = new User();
         * $user->setEmail($faker->email)
         * ->setUsername($faker->userName)
         * ->setPassword('testtest');
         *
         * for ($j = 1; $j <= mt_rand(2, 10); $j++) {
         * $comment = new comment();
         * $comment->setTrick($faker->numberBetween(102, 117))
         * ->setCreatedAt()
         *
         *
         *
         * $manager->persist($user);
         * }
         *
         * $manager->flush();
         * }**/
    }
}
