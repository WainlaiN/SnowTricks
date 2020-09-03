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
     * @Route("/trick/new", name="trick_create")
     * @IsGranted("ROLE_USER")
     */
    public function trickCreate(Request $request, TrickService $trickService)
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $user = $this->getUser();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //if form is valid, use service to persist value
            if ($trickService->createFormTrick($form, $trick, $user)) {

                return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
            }

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
    public function trickEdit(Request $request, TrickService $trickService, TrickRepository $repo, $slug)
    {
        $trick = $repo->findOneBySlug($slug);
        $form = $this->createForm(TrickType::class, $trick);
        $user = $this->getUser();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //if form is valid, use service to persist value
            if ($trickService->editFormTrick($form, $trick, $user)) {

                return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
            }
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
    public function trickShow(Request $request, TrickService $trickService, TrickRepository $repo, $slug)
    {
        $trick = $repo->findOneBySlug($slug);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $user = $this->getUser();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //if form is valid, use service to persist value
            $trickService->createCommentTrick($trick, $user, $comment);
        }

        return $this->render(
            'trick/show.html.twig',
            [
                'trick' => $trick,
                'formComment' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/trick/{slug}/delete", name="trick_delete")
     * @IsGranted("ROLE_USER")
     */
    public function delete(TrickRepository $repo, Request $request, EntityManagerInterface $manager, $slug)
    {
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
    public function deleteImage(Image $image, Request $request, EntityManagerInterface $manager)
    {
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
    public function deleteVideo(Video $video, Request $request, EntityManagerInterface $manager)
    {
        $data = json_decode($request->getContent(), true);

        //remove video from database
        $manager->remove($video);
        $manager->flush();

        //json response
        return new JsonResponse(['success' => 1]);
    }
}