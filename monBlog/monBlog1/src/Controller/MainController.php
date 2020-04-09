<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="Accueil")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/mentions-legales", name="mentions-legales")
     */
    public function mentionsLegales()
    {
        return $this->render('main/mentions-legales.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
   
}
