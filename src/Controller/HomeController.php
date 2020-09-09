<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="trick")
     *
     * @param TrickRepository $repo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(TrickRepository $repo)
    {
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
     * @Route("/mentions-legales", name="mentions")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mentions()
    {
        return $this->render('home/mentions.html.twig');
    }
}
