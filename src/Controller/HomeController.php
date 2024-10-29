<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    // #[Route('/recherche', name: 'recherche')]
    // public function recherche(): Response
    // {

    //     return $this->render('formulaire/index.html.twig', [
    //         'controller_name' => 'FormulaireController',
    //     ]);
    // }
}