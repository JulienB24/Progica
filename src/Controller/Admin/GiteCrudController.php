<?php

// src/Controller/Admin/GiteCrudController.php

namespace App\Controller\Admin;

use App\Entity\Gite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gite::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new ('nom', 'Nom'),
            TextField::new ('adresse', 'Adresse'),
            TextField::new ('region', 'Région'),
            TextField::new ('departement', 'Département'),
            TextField::new ('ville', 'Ville'),
            HiddenField::new ('latitude', 'Latitude'),
            HiddenField::new ('longitude', 'Longitude'),

            NumberField::new ('surface_habitable', 'Surface Habitable'),
            NumberField::new ('nombre_chambre', 'Nombre de Chambres'),
            NumberField::new ('nombre_couchage', 'Nombre de Couchages'),
            NumberField::new ('tarif_hebdo', 'Tarif Hebdomadaire'),
            BooleanField::new ('accepte_animaux', 'Accepte les Animaux'),
            AssociationField::new ('proprietaire', 'Propriétaire')->setRequired(true),
            AssociationField::new ('contact', 'Contact')->setRequired(true),

            AssociationField::new ('equipements', 'Équipements')
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'multiple' => true,
                ]),
            AssociationField::new ('services', 'Services')
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'multiple' => true,
                ]),

        ];
    }
}
