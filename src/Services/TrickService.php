<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class TrickService
{
    private $trickManager;
    private $uploadHelper;
    private $videoHelper;
    private $router;
    private $session;

    public function __construct(
        EntityManagerInterface $manager,
        //TrickManager $trickManager,
        UploadHelper $uploadHelper,
        VideoHelper $videoHelper,
        RouterInterface $router,
        SessionInterface $session
    ) {
        //parent::__construct($manager);
        //$this->trickManager = $trickManager;
        $this->manager = $manager;
        $this->uploadHelper = $uploadHelper;
        $this->videoHelper = $videoHelper;
        $this->router = $router;
        $this->session = $session;


    }

    public function createFormTrick($form, $trick, $user)
    {
        $trick->setCreatedAt(new \DateTime());
        $UploadedMain = $form->get('file')->getData();
        $mainImage = $this->uploadHelper->saveMainFile($UploadedMain);

        $trick->setMainImage($mainImage);
        $trick->setUserId($user);

        foreach ($trick->getImages() as $image) {
            $image = $this->uploadHelper->saveImage($image);
            $image->setTrick($trick);
        }

        foreach ($trick->getVideos() as $video) {

            $this->verifyURL($video, $trick);

        }

        //$this->trickManager->persistAndFlush($trick);
        $this->manager->persist($trick);
        $this->manager->flush();
        $this->session->getFlashBag()->add('success', 'Votre article a bien été ajouté !');

        return true;
    }

    public function editFormTrick($form, $trick, $user)
    {
        foreach ($trick->getImages() as $image) {

            //check if it's a new uploaded file
            if ($image->getFile()) {
                $image = $this->uploadHelper->saveImage($image);
                $image->setTrick($trick);
                $this->manager->persist($image);
            }
        }
        foreach ($trick->getVideos() as $video) {

            $this->verifyURL($video, $trick);

        }

        $trick->setUserId($user);
        $uploadedMain = $form->get('file')->getData();

        if ($uploadedMain) {
            $mainImage = $this->uploadHelper->saveMainFile($uploadedMain);
            $trick->setMainImage($mainImage);
        }

        $trick->setUpdatedAt(new \DateTime());
        $this->manager->persist($trick);
        $this->manager->flush();

        $this->session->getFlashBag()->add('success', 'Votre article a bien été modifié !');

        return true;
    }


    public function createCommentTrick($trick, $user, $comment)
    {

        $comment->setCreatedAt(new \DateTime())
            ->setTrick($trick)
            ->setUser($user);
        $this->manager->persist($comment);
        $this->manager->flush();

        $this->session->getFlashBag()->add('success', 'Votre commentaire a bien été enregistré !');

        return true;
    }

    private function verifyURL($data, $trick)
    {
        if ($this->videoHelper->extractPlatformFromURL($data->getVideoURL())) {
            $data->setVideoURL($this->videoHelper->extractPlatformFromURL($data->getVideoURL()))
                ->setTrick($trick);
            $this->manager->persist($data);

        } else {

            $this->session->getFlashBag()->add('danger', "Vérifier vos URLs de videos");

            return false;
        }
    }
}