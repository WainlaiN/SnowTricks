<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="trick")
     */
    public function index(TrickRepository $repo)
    {
        $tricks = $repo->findFirstFour();

        return $this->render(
            'trick/index.html.twig',
            [
                'controller_name' => 'TrickController',
                'tricks' => $tricks,
            ]
        );
    }

    public function loadMoreTricks(TrickRepository $repo, $start = 15)
    {
        // Get 15 tricks from the start position
        $tricks = $repo->findBy([], ['createdAt' => 'DESC'], 15, $start);

        return $this->render('home/loadMoreTricks.html.twig', [
            'tricks' => $tricks
        ]);
    }

}
