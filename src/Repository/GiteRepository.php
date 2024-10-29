<?php
namespace App\Repository;

use App\Entity\Gite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gite::class);
    }

    public function rechercheGite(
        Gite $critere,
        array $equipements = [],
        array $services = [],
        ?float $latitude = null,
        ?float $longitude = null,
        ?float $distanceMax = null
    ) {
        $qb = $this->createQueryBuilder('g');

        // Filtrer par nom
        if ($critere->getNom()) {
            $qb->andWhere('g.nom LIKE :nom')
                ->setParameter('nom', '%' . $critere->getNom() . '%');
        }

        // Filtrer par région
        if ($critere->getRegion()) {
            $qb->andWhere('g.region LIKE :region')
                ->setParameter('region', '%' . $critere->getRegion() . '%');
        }

        // Filtrer par département
        if ($critere->getDepartement()) {
            $qb->andWhere('g.departement LIKE :departement')
                ->setParameter('departement', '%' . $critere->getDepartement() . '%');
        }

        // Filtrer par ville
        if ($critere->getVille()) {
            $qb->andWhere('g.ville LIKE :ville')
                ->setParameter('ville', '%' . $critere->getVille() . '%');
        }

        // Filtrer par accepte_animaux
        if ($critere->isAccepteAnimaux() === true) {
            $qb->andWhere('g.accepte_animaux = :accepte_animaux')
                ->setParameter('accepte_animaux', true);
        }

        // Filtrer par équipements (tous les équipements doivent être présents)
        if (!empty($equipements)) {
            $equipementIds = array_map(fn($e) => $e->getId(), $equipements);
            $qb->innerJoin('g.equipements', 'e')
                ->andWhere('e.id IN (:equipements)')
                ->setParameter('equipements', $equipementIds);
        }

        // Filtrer par services (tous les services doivent être présents)
        if (!empty($services)) {
            $serviceIds = array_map(fn($s) => $s->getId(), $services);
            $qb->innerJoin('g.services', 's')
                ->andWhere('s.id IN (:services)')
                ->setParameter('services', $serviceIds);
        }

        // Filtrer par distance maximale
        if ($latitude !== null && $longitude !== null && $distanceMax !== null) {
            // Calcul des coordonnées limites
            $carre = $this->calculcarre($latitude, $longitude, $distanceMax);

// Appliquer le filtrage par coordonnées limites
            $qb->andWhere('g.latitude BETWEEN :south AND :north')
                ->andWhere('g.longitude BETWEEN :west AND :east')
                ->setParameter('north', $carre['north'])
                ->setParameter('south', $carre['south'])
                ->setParameter('east', $carre['east'])
                ->setParameter('west', $carre['west']);

        }

        // Grouper par gîte
        $qb->groupBy('g.id');

        // Application des conditions HAVING si nécessaire
        if (!empty($equipements)) {
            $qb->having('COUNT(DISTINCT e.id) = :equipement_count')
                ->setParameter('equipement_count', count($equipementIds));
        }

        if (!empty($services)) {
            if (!empty($equipements)) {
                $qb->andHaving('COUNT(DISTINCT s.id) = :service_count');
            } else {
                $qb->having('COUNT(DISTINCT s.id) = :service_count');
            }
            $qb->setParameter('service_count', count($serviceIds));
        }

        return $qb->getQuery()->getResult();
    }

    private function calculcarre($latitude, $longitude, $distanceMax)
    {
        $earthRadius = 6371; // Rayon de la Terre en kilomètres

        // Calcul de la différence en latitude
        $latDelta = $distanceMax / $earthRadius;
        $latDelta = rad2deg($latDelta); // Convertir les radians en degrés

        // Calcul de la différence en longitude
        // La distance en longitude dépend de la latitude
        $lonDelta = $distanceMax / ($earthRadius * cos(deg2rad($latitude)));
        $lonDelta = rad2deg($lonDelta); // Convertir les radians en degrés

        // Calcul des coordonnées limites
        $north = $latitude + $latDelta;
        $south = $latitude - $latDelta;
        $east = $longitude + $lonDelta;
        $west = $longitude - $lonDelta;

        return [
            'north' => $north,
            'south' => $south,
            'east' => $east,
            'west' => $west,
        ];
    }
}
