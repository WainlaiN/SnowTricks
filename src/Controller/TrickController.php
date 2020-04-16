<?php

namespace App\Controller;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/trick/edit", name="trick_edit")
     */
    public function edit(Request $request){
        $trick = new Trick();

        $form = $this->createFormBuilder($trick)
                    ->add('name')
                    ->add('description')
                    ->add('category')
                    //->add('createdAt')
                    ->add('image')
                    ->add('video')
                    ->getForm();

        return $this->render('trick/edit.html.twig', [
            'formTrick' => $form->createView()
        ]);

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
