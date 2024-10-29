<?php

namespace App\Controller;

use App\Entity\Gite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GiteController extends AbstractController
{
    #[Route('/', name: 'app_gite')]

    public function ViewCat(EntityManagerInterface $entityManager): Response
    {
        $gites = $entityManager->getRepository(Gite::class)->findAll();

        return $this->render('home/index.html.twig', [
            'gites' => $gites,
        ]);
    }
}