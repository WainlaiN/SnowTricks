<?php


namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use App\Entity\Trick;


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
        Router $router,
        Session $session
    ) {
        $this->manager = $manager;
        $this->uploadHelper = $uploadHelper;
        $this->videoHelper = $videoHelper;
        $this->router = $router;
        $this->session = $session;
    }

    public function createFormTrick($form)
    {
        $trick = new Trick();
        $user = new User();

        if ($form->isSubmitted() && $form->isValid()) {

            $trick->setCreatedAt(new \DateTime());
            $UploadedMain = $form->get('file')->getData();
            $mainImage = $uploadHelper->saveMainFile($UploadedMain);

            $trick->setMainImage($mainImage);
            $trick->setUserId($this->getUser());

            foreach ($trick->getImages() as $image) {
                $image = $uploadHelper->saveImage($image);
                $image->setTrick($trick);
            }

            foreach ($trick->getVideos() as $video) {

                try {
                    $user
                        ->setToken($token)
                        ->setPasswordRequestedAt(new \DateTime());
                    $entityManager->flush();
                } catch (\Exception $e) {
                    $this->addFlash('warning', $e->getMessage());

                    return $this->redirectToRoute('security_login');
                }

                if ($videoHelper->extractPlatformFromURL($video->getVideoURL()) !== false) {

                    $video->setVideoURL($videoHelper->extractPlatformFromURL($video->getVideoURL()));
                    $video->setTrick($trick);
                    $manager->persist($video);

                } else {

                    $this->session->getFlashBag()->add(
                        'danger',
                        "Problème lors de l'enregistrement des videos"
                    );


                    return $this->router->generate('trick_create');
                    //redirectToRoute('trick_create');
                }
            }

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre article a bien été ajouté !'
            );

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
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