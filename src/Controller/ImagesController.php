<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 */
class ImagesController extends AbstractController
{
    /**
     * @Route("/images", name="images")
     */
    public function index(): Response
    {
        return $this->render('images/index.html.twig', [
            'controller_name' => 'ImagesController',
        ]);
    }
}
