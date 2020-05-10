<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Element;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


use App\Repository\TrickRepository;
use App\Entity\Trick;

class TrickController extends AbstractController
{

    /**
     * @Route("/trick/new", name="trick_create")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $trick = new Trick();

        // dummy code - add some example images/videos to the task
        // (otherwise, the template will render an empty list of images/videos)
        $image = new Image();

        $trick->getImages()->add($image);
        //$video = new Video();
        //$trick->getVideos()->add($video);
        // end dummy code

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        $imageFile = $form->get('images')->getData();


        if ($form->isSubmitted() && $form->isValid()) {

            if ($imageFile) {


                $newFilename .= '-'.uniqid().'.'.$imageFile->guessExtension();

            }

            dump($imageFile,$newFilename );
            die();

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
    public
    function edit(
        Trick $trick,
        Request $request,
        EntityManagerInterface $manager
    ) {
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render(
            'trick/edit.html.twig',
            [
                'formTrick' => $form->createView(),
                'editMode' => $trick->getId() !== null,
            ]
        );

    }

    /**
     * @Route("/trick/{id}", name="trick_show")
     */
    public
    function show(
        Trick $trick
    ) {
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
