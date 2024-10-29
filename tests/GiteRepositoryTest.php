<?php

namespace App\Tests\Repository;

use App\Entity\Gite;
use App\Repository\GiteRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GiteRepositoryTest extends KernelTestCase
{
    public function testRechercheGiteParNom()
    {
        // Démarrage du kernel Symfony pour charger les services (incluant le GiteRepository)
        self::bootKernel();
        $container = self::getContainer();

        // Récupération du repository GiteRepository depuis le container
        $giteRepository = $container->get(GiteRepository::class);

        // Création d'un gîte fictif pour la recherche
        $gite = new Gite();
        $gite->setNom('Le Chalet');

        // Exécution de la méthode de recherche
        $resultats = $giteRepository->rechercheGite($gite);

        // Vérifications
        $this->assertCount(1, $resultats);  // Vérifie qu'il y a bien 1 résultat
        $this->assertEquals('Le Chalet', $resultats[0]->getNom());  // Vérifie que le nom du gîte est correct
    }
}
