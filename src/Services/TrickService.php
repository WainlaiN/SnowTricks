<?php


namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Trick;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class TrickService
{
    private $manager;
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

        if ($form->isSubmitted() && $form->isValid()) {

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

                if ($this->videoHelper->extractPlatformFromURL($video->getVideoURL()) !== false) {

                    $video->setVideoURL($this->videoHelper->extractPlatformFromURL($video->getVideoURL()));
                    $video->setTrick($trick);
                    $this->manager->persist($video);

                } else {

                    $this->session->getFlashBag()->add(
                        'danger',
                        "Problème lors de l'enregistrement des videos"
                    );


                    return $this->router->generate('trick_create');
                    //redirectToRoute('trick_create');
                }
            }

            $this->manager->persist($trick);
            $this->manager->flush();

            $this->session->getFlashBag()->add(
                'success',
                'Votre article a bien été ajouté !'
            );

            return $this->router->generate('trick_show', ['slug' => $trick->getSlug()]);

        }

        return $this->render(
          'trick/create.html.twig',
          ['formTrick' => $form->createView()]
          );


    }

    public function editFormTrick($form)
    {

    }

    public function createCommentTrick($form)
    {

    }

    public function deleteFormTrick($form)
    {

    }

}