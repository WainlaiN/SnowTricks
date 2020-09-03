<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\User;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickType;

use App\Services\UploadHelper;
use App\Services\VideoHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\TrickService;

use App\Repository\TrickRepository;
use App\Entity\Trick;

class TrickController extends AbstractController
{
    /**
     * @Route("/trick/new2", name="trick_create2")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UploadHelper $uploadHelper
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    /**public function checkUser(User $user)
     * {
     *
     * }**/

    public function create(
        Request $request,
        EntityManagerInterface $manager,
        UploadHelper $uploadHelper,
        VideoHelper $videoHelper
    ) {

        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

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

    /**
     * @Route("/trick/new", name="trick_create")
     * @IsGranted("ROLE_USER")
     */
    public function createTest(EntityManagerInterface $manager, Request $request, TrickService $trickService)
    {

        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        $user = $this->getUser();

        $trickAdded = $trickService->createFormTrick($form, $trick, $user);

        if ($trickAdded[0] == "success") {
            $this->addFlash(
                '$trickAdded[0]',
                '$trickAdded[1]'
            );

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);

        }

        return $this->render(
            'trick/create.html.twig',
            ['formTrick' => $form->createView()]
        );


    }

    /**
     * @Route("/trick/{slug}/edit", name="trick_edit")
     * @IsGranted("ROLE_USER")
     */
    public
    function edit(
        Request $request,
        EntityManagerInterface $manager,
        UploadHelper $uploadHelper,
        TrickRepository $repo,
        $slug,
        VideoHelper $videoHelper
    ) {

        $trick = $repo->findOneBySlug($slug);
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($trick->getImages() as $image) {

                //check if it's a new uploaded file
                if ($image->getFile()) {
                    $image = $uploadHelper->saveImage($image);
                    $image->setTrick($trick);
                    $manager->persist($image);
                }
            }

            foreach ($trick->getVideos() as $video) {

                if ($video->getVideoURL()) {

                    if ($videoHelper->extractPlatformFromURL($video->getVideoURL()) !== false) {

                        $video->setVideoURL($videoHelper->extractPlatformFromURL($video->getVideoURL()));
                        $video->setTrick($trick);
                        $manager->persist($video);

                    } else {

                        $this->addFlash(
                            'danger',
                            "Problème lors de l'enregistrement des videos"
                        );

                        return $this->redirectToRoute('trick_edit', ['slug' => $trick->getSlug()]);

                    }
                }
            }

            $trick->setUserId($this->getUser());

            $uploadedMain = $form->get('file')->getData();

            if ($uploadedMain) {
                $mainImage = $uploadHelper->saveMainFile($uploadedMain);
                $trick->setMainImage($mainImage);
            }

            $trick->setUpdatedAt(new \DateTime());
            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre article a bien été modifié !'
            );

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
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
     * @Route("/trick/{slug}", name="trick_show")
     */
    public
    function show(
        TrickRepository $repo,
        Request $request,
        EntityManagerInterface $manager,
        $slug
    ) {
        $trick = $repo->findOneBySlug($slug);
        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);

        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $comment->setCreatedAt(new \DateTime());
            $comment->setTrick($trick);
            $comment->setUser($this->getUser());
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

    /**
     * @Route("/trick/{slug}/delete", name="trick_delete")
     * @IsGranted("ROLE_USER")
     */
    public
    function delete(
        TrickRepository $repo,
        Request $request,
        EntityManagerInterface $manager,
        $slug
    ) {
        $trick = $repo->findOneBySlug($slug);
        $manager->remove($trick);
        $manager->flush();

        $this->addFlash('success', "Le trick {$trick->getName()} a été supprimé avec succès !");

        return $this->redirectToRoute('trick');
    }

    /**
     * @Route("/delete/image/{id}", name="image_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public
    function deleteImage(
        Image $image,
        Request $request,
        EntityManagerInterface $manager
    ) {
        $data = json_decode($request->getContent(), true);

        //delete the image in directory
        unlink($this->getParameter('uploads-directory').'/'.$image->getImageFilename());

        //remove image from database
        $manager->remove($image);
        $manager->flush();

        //json response
        return new JsonResponse(['success' => 1]);
    }

    /**
     * @Route("/delete/video/{id}", name="video_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public
    function deleteVideo(
        Video $video,
        Request $request,
        EntityManagerInterface $manager
    ) {
        $data = json_decode($request->getContent(), true);

        //remove video from database
        $manager->remove($video);
        $manager->flush();

        //json response
        return new JsonResponse(['success' => 1]);
    }

}
