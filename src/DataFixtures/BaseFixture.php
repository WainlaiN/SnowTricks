<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use App\Services\UploadHelper;

abstract class BaseFixture extends Fixture
{
    /** @var ObjectManager */
    protected $manager;

    /** @var Generator */
    protected $faker;

    private $referenceIndex = [];

    abstract protected function loadData(ObjectManager $manager);

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create('fr_FR');
        $this->loadData($manager);
    }

    protected function createMany(string $className, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = new $className;
            $factory($entity, $i);

            $this->manager->persist($entity);
            //store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference($className.'_'.$i, $entity);
        }
    }

    protected function getRandomReference(string $classname)
    {
        if (!isset($this->referenceIndex[$classname])) {
            $this->referenceIndex[$classname] = [];

            foreach ($this->referenceRepository->getReferences() as $key => $ref) {
                if (strpos($key, $classname.'_') === 0) {
                    $this->referenceIndex[$classname][] = $key;
                }
            }
        }

        if (empty($this->referenceIndex[$classname])) {
            throw new \Exception(sprintf('cannot find anu references for class "%s"', $classname));
        }

        $randomReferenceKey = $this->faker->randomElement($this->referenceIndex[$classname]);

        return $this->getReference($randomReferenceKey);
    }


}