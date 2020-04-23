<?php

namespace App\Controller;




use Doctrine\ORM\EntityManagerInterface;
use MongoDB\Driver\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
     * @Route("/trick/new", name="trick_create")
     * @Route("/trick/{id}/edit", name="trick_edit")
     */
    public function form(Trick $trick = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$trick){
            $trick = new Trick();
        }

        $form = $this->createFormBuilder($trick)
            ->add('name')
            ->add('description')
            ->add('category')
            ->add('createdAt')
            ->add('image')
            ->add('video')

            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if (!$trick->getId()) {
                $trick->setCreatedAt(new \DateTime());
            }

            $manager->persist($trick);
            $manager->flush();

            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);

        }

        return $this->render(
            'trick/edit.html.twig',
            [
                'formTrick' => $form->createView(),
                'editMode' => $trick->getId() !== null
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
