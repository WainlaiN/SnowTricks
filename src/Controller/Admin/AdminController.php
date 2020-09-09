<?php


namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController  extends AbstractController
{

    /**
     * @Route("/", name="admin_index", methods={"GET"})
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

}