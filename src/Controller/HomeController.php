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
        //$tricks = $repo->findFirstFour();
        $tricks = $repo->findAll();

        return $this->render(
            'home/index.html.twig',
            [
                'controller_name' => 'TrickController',
                'tricks' => $tricks,
            ]
        );
    }

    /**
     * Get the 4 next tricks in the database and create a Twig file with them that will be displayed via Javascript
     *
     * @Route("/{start}", name="loadMoreTricks", requirements={"start": "\d+"})
     */
    public function loadMoreTricks(TrickRepository $repo, $start = 4)
    {
        // Get 15 tricks from the start position
        $tricks = $repo->findBy([], ['createdAt' => 'DESC'], 15, $start);

        return $this->render('home/loadMoreTricks.html.twig', [
            'tricks' => $tricks
        ]);
    }

}
