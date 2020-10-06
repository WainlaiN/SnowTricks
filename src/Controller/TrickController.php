<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\User;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickType;

use Doctrine\ORM\EntityManagerInterface;
use http\Client\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\TrickService;

use App\Repository\TrickRepository;
use App\Entity\Trick;

class TrickController extends AbstractController
{


    /**
     * @Route("/trick/new", name="trick_create")
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @param TrickService $trickService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function trickCreate(Request $request, TrickService $trickService)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $user = $this->getUser();
        $form->handleRequest($request);

        //if form is valid, use service to persist value
        if ($form->isSubmitted() && $form->isValid()) {

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
     *
     * @param Request $request
     * @param TrickService $trickService
     * @param TrickRepository $repo
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function trickEdit(Request $request, TrickService $trickService, TrickRepository $repo, $slug)
    {
        $trick = $repo->findOneBySlug($slug);
        $form = $this->createForm(TrickType::class, $trick);
        $user = $this->getUser();
        $form->handleRequest($request);

        //if form is valid, use service to persist value
        if ($form->isSubmitted() && $form->isValid()) {

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
     *
     * @param Request $request
     * @param TrickService $trickService
     * @param TrickRepository $repo
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function trickShow(Request $request, TrickService $trickService, TrickRepository $repo, $slug)
    {
        if ($trick = $repo->findOneBySlug($slug)) {
            $comment = new Comment();
            $form = $this->createForm(CommentType::class, $comment);
            $user = $this->getUser();

            $form->handleRequest($request);

            //if form is valid, use service to persist value
            if ($form->isSubmitted() && $form->isValid()) {

                $trickService->createCommentTrick($trick, $user, $comment);

                return $this->redirectToRoute(
                    'trick_show',
                    ['slug' => $trick->getSlug()]
                );
            }


            return $this->render(
                'trick/show.html.twig',
                [
                    'trick' => $trick,
                    'formComment' => $form->createView(),
                ]
            );
        }

        throw $this->createNotFoundException('Le trick n\'existe pas');
    }

    /**
     * @Route("/trick/{slug}/delete", name="trick_delete")
     * @IsGranted("ROLE_USER")
     *
     * @param TrickRepository $repo
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function trickDelete(TrickRepository $repo, EntityManagerInterface $manager, $slug)
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
     *
     * @param Image $image
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return JsonResponse
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
     *
     * @param Video $video
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return JsonResponse
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