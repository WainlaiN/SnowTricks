<?php


namespace App\Services;

use App\Repository\TrickRepository;
use App\Services\UploadHelper;
use App\Services\VideoHelper;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\UploadHelper;
use App\Services\VideoHelper;
use Symfony\Component\HttpFoundation\Request;


class Trick
{

    public function __construct(
        //Request $request,
        EntityManagerInterface $manager,
        UploadHelper $uploadHelper,
        VideoHelper $videoHelper
    ) {
    }

    public function createFormTrick($form)
    {
        $trick = new \App\Entity\Trick();

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

                try{
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

                    $this->addFlash(
                        'danger',
                        "Problème lors de l'enregistrement des videos"
                    );

                    return $this->redirectToRoute('trick_create');
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