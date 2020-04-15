<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\TrickRepository;
use App\Entity\Trick;

class TrickController extends AbstractController
{
    /**
     * @Route("/", name="trick")
     */
    public function index(TrickRepository $repo)
    {
        $tricks = $repo->findAll();

        return $this->render(
            'trick/index.html.twig',
            [
                'controller_name' => 'TrickController',
                'tricks' => $tricks,
            ]
        );
    }

    /**
     * @Route("/trick/{id}", name="trick_show")
     */
    public function show(Trick $trick)
    {
        return $this->render(
            'trick/show.html.twig',
            [
                'trick' => $trick,
            ]
        );
    }

}
