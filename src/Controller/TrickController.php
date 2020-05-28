<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Form\CommentType;
use App\Form\TrickType;

use App\Services\UploadHelper;
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
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UploadHelper $uploadHelper
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, EntityManagerInterface $manager, UploadHelper $uploadHelper)
    {

        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick->setCreatedAt(new \DateTime());

            //get MainImage in form
            $UploadedMain = $form->get('mainImage')->getData();
            //save MainImage in directory
            $mainImage = $uploadHelper->saveImage($UploadedMain);
            //set MainImage to Trick
            $trick->setMainImage($mainImage);
            //$mainImage->setTrick($trick);

            //$manager->persist($mainImage);

            dump($trick);

            foreach ($trick->getImages() as $image) {

                $image = $uploadHelper->saveImage($image);
                $image->setTrick($trick);

            }

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'success',
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
    public function edit(
        Trick $trick,
        Request $request,
        EntityManagerInterface $manager,
        UploadHelper $uploadHelper,
        TrickRepository $repo
    ) {

        $trick = $repo->find($trick);

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);
        //dump($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $form->get('images')->getData();

            if ($uploadedFiles) {

                foreach ($trick->getImages() as $image) {

                    $image->setTrick($trick);
                    $image = $uploadHelper->saveImage($image);
                    $image->setTrick($trick);
                    $manager->persist($image);
                }
            }
            $trick->setUpdatedAt(new \DateTime());

            //get MainImage in form
            $uploadedMain = $form->get('mainImage')->getData();

            if ($uploadedMain) {
                //save MainImage in directory
                $mainImage = $uploadHelper->saveImage($uploadedMain);
                //set MainImage to Trick
                $trick->setMainImage($mainImage);
                $mainImage->setTrick($trick);

            }


            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre article a bien été modifié !'
            );

            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);

        }

        return $this->render(
            'trick/edit.html.twig',
            [
                'formTrick' => $form->createView(),
                'trick' => $trick,

            ]
        );
    }

    /**
     * @Route("/trick/{id}", name="trick_show")
     */
    public function show($id, TrickRepository $repo, Request $request, EntityManagerInterface $manager)
    {
        $trick = $repo->find($id);
        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);

        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $comment->setCreatedAt(new \DateTime());
            $comment->setTrick($trick);
            $comment->setUser($request->getUser());

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre commentaire a bien été enregistré !'
            );

        }

        return $this->render(
            'trick/show.html.twig',
            [
                'trick' => $trick,
                'formComment' => $formComment->createView(),
            ]
        );
    }

}
