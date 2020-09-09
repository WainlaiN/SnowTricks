<?php


namespace App\Services;


use Doctrine\ORM\EntityManagerInterface;

class TrickManager
{

    protected $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function persistAndFlush($data)
    {
        $this->manager->persist($data);
        $this->manager->flush();
    }

}