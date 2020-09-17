<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class TrickService
{
    private $uploadHelper;
    private $videoHelper;
    private $router;
    private $session;

    public function __construct(
        EntityManagerInterface $manager,
        UploadHelper $uploadHelper,
        VideoHelper $videoHelper,
        RouterInterface $router,
        SessionInterface $session
    ) {
        $this->manager = $manager;
        $this->uploadHelper = $uploadHelper;
        $this->videoHelper = $videoHelper;
        $this->router = $router;
        $this->session = $session;

    }

    public function createFormTrick($form, $trick, $user)
    {
        foreach ($trick->getImages() as $image) {
            $image = $this->uploadHelper->saveImage($image);
            $image->setTrick($trick);
        }

        foreach ($trick->getVideos() as $video) {
            if (!$this->verifyURL($video, $trick)) {

                return false;
            }
        }

        $trick->setCreatedAt(new \DateTime())
            ->setMainImage($this->uploadHelper->saveMainFile($form->get('file')->getData()))
            ->setUserId($user);
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

            if (!$this->verifyURL($video, $trick)) {

                return false;
            }
        }

        if ($form->get('file')->getData()) {

            $trick->setMainImage($this->uploadHelper->saveMainFile($form->get('file')->getData()));
        }

        $trick->setUserId($user)
            ->setUpdatedAt(new \DateTime());
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

        return true;
    }
}