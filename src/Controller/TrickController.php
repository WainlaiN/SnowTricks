<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
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
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UploadImage $uploadImage
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, EntityManagerInterface $manager, UploadImage $uploadImage)
    {

        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $trick->setCreatedAt(new \DateTime());

            //get MainImage in form
            $UploadedMain = $form->get('mainImage')->getData();
            //save MainImage in directory
            $mainImage = $uploadImage->saveImage($UploadedMain);
            //set MainImage to Trick
            $trick->setMainImage($mainImage);

            $manager->persist($mainImage);

            foreach ($trick->getImages() as $image) {

                $image = $uploadImage->saveImage($image);
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
    public function edit(
        Trick $trick,
        Request $request,
        EntityManagerInterface $manager,
        UploadImage $uploadImage,
        TrickRepository $repo
    ) {

        $trick = $repo->find($trick);

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick->setUpdatedAt(new \DateTime());

            foreach ($trick->getImages() as $image) {

                $image = $uploadImage->saveImage($image);
                $image->setTrick($trick);

            }

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'notice',
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
    public function show($id, TrickRepository $repo)
    {

        $trick = $repo->find($id);

        return $this->render(
            'trick/show.html.twig',
            [
                'trick' => $trick,
            ]
        );
    }

}
