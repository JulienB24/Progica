<?php
namespace App\Controller;

use App\Form\GiteType;
use App\Repository\EquipementRepository;
use App\Repository\GiteRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormulaireController extends AbstractController
{
    #[Route('/recherche', name: 'recherche', methods: ['GET', 'POST'])]

    public function formulaire(Request $request, GiteRepository $giteRepository, EquipementRepository $equipementRepository, ServiceRepository $serviceRepository): Response
    {
        // Créer et gérer le formulaire
        $form = $this->createForm(GiteType::class);
        $form->handleRequest($request);

        $gites = [];
        $equipements = [];
        $services = [];
        $selectedEquipements = [];
        $selectedServices = [];
        $latitude = $request->request->get('latitude');
        $longitude = $request->request->get('longitude');
        $distanceMax = $request->request->get('distanceMax');

        if ($form->isSubmitted() && $form->isValid()) {
            $critere = $form->getData();

            // Récupérer la distance maximale depuis le formulaire
            $distanceMax = $form->get('distanceMax')->getData(); // Assurez-vous que 'distanceMax' est le bon champ du formulaire
            $latitude = $form->get('latitude')->getData(); // Assurez-vous que 'latitude' est le bon champ du formulaire
            $longitude = $form->get('longitude')->getData(); // Assurez-vous que 'longitude' est le bon champ du formulaire

            // Récupérer les équipements et services sélectionnés depuis le formulaire
            $selectedEquipements = $critere->getEquipements(); // Collection d'objets Equipement
            $selectedServices = $critere->getServices(); // Collection d'objets Service

            // Convertir les collections en tableaux de IDs
            $equipementIds = array_map(fn($e) => $e->getId(), $selectedEquipements->toArray());
            $serviceIds = array_map(fn($s) => $s->getId(), $selectedServices->toArray());

            // Récupérer les objets équipements et services depuis leurs repositories
            if (!empty($equipementIds)) {
                $equipements = $equipementRepository->findBy(['id' => $equipementIds]);
            }

            if (!empty($serviceIds)) {
                $services = $serviceRepository->findBy(['id' => $serviceIds]);
            }

            // Appeler la méthode de recherche avec latitude, longitude et distanceMax
            $gites = $giteRepository->rechercheGite($critere, $equipements, $services, $latitude, $longitude, $distanceMax);

        }

        return $this->render('formulaire/index.html.twig', [
            'form' => $form->createView(),
            'gites' => $gites,
            'selectedEquipements' => $selectedEquipements,
            'selectedServices' => $selectedServices,
            'Equipements' => $equipements,
            'Services' => $services,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'distanceMax' => $distanceMax,
        ]);
    }

}
