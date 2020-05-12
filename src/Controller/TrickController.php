<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\TrickType;

use App\Services\UploadImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


use App\Repository\TrickRepository;
use App\Entity\Trick;

class TrickController extends AbstractController
{

    /**
     * @Route("/trick/new", name="trick_create")
     */
    public function create(Request $request, EntityManagerInterface $manager, UploadImage $uploadImage)
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick->setCreatedAt(new \DateTime());
            $uploads_directory = $this->getParameter('uploads-directory');

            foreach ($trick->getImages() as $image) {

                $image = $uploadImage->saveImage($image, $uploads_directory);
                $image->setTrick($trick);

            }

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Votre article a bien été ajouté !'
            );

            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);

        }

        return $this->render(
            'trick/create.html.twig',
            ['formTrick' => $form->createView()]
        );

    }

    /**
     * @Route("/trick/{id}/edit", name="trick_edit")
     */
    public function edit(Trick $trick,Request $request,EntityManagerInterface $manager,UploadImage $uploadImage,TrickRepository $repo) {
        //$trick = $repo->findBy($id);

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick->setUpdatedAt(new \DateTime());
            $uploads_directory = $this->getParameter('uploads-directory');

            foreach ($trick->getImages() as $image) {

                $image = $uploadImage->saveImage($image, $uploads_directory);
                $image->setTrick($trick);

            }

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Votre article a bien été ajouté !'
            );

            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);

        }

        return $this->render(
            'trick/edit.html.twig',
            [
                'formTrick' => $form->createView(),

            ]
        );
    }

    /**
     * @Route("/trick/{id}", name="trick_show")
     */
    public function show(Trick $trick)
    {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        return $this->render(
            'trick/show.html.twig',
            [
                'trick' => $trick,
                'commentForm' => $form->createView(),
            ]
        );
    }

}
