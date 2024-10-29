<?php

namespace App\Form;

use App\Entity\Equipement;
use App\Entity\Gite;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Nom: ',
                'required' => false,

            ])
            ->add('region', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'placeholder' => 'Toutes les régions',

                'choices' => [
                    'Aquitaine' => 'aquitaine',
                    'Auvergne-Rhône-Alpes' => 'auvergne_rhône_alpes',
                    'Corse' => 'corse',
                    'Occitanie' => 'occitanie',
                ],
                'label' => 'Région: ',
                'required' => false,

            ])
            ->add('departement', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'placeholder' => 'Tous les départements',
                'choices' => [
                    'Corse-du-sud' => 'corse-du-sud',
                    'Dordogne' => 'dordogne',
                    'Gard' => 'gard',
                    'Gironde' => 'gironde',
                    'Haute-Savoie' => 'haute_savoie',
                    'Puy-de-dome' => 'puy_de_dome',
                ],
                'label' => 'Département: ',
                'required' => false,

            ])
            ->add('ville', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Nom: ',
                'required' => false,

            ])
            ->add('distanceMax', NumberType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Distance maximum: ',
                'required' => false])

            ->add('equipements', EntityType::class, [
                'class' => Equipement::class,
                'choice_label' => 'nom',
                'mapped' => true,
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'label' => 'Équipements: ',
                'attr' => ['class' => 'form-check'],
            ])
            ->add('services', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'nom',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'label' => 'Services: ',
                'attr' => ['class' => 'form-check'],
            ])
            ->add('accepte_animaux', CheckboxType::class, [
                'label' => 'Accepte les animaux (+50€)',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
            ])
            ->add('rechercher', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success rechercher'],
            ])
            ->add('latitude', NumberType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control-input'],

            ])
            ->add('longitude', NumberType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control-input'],

            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gite::class,
        ]);
    }
}
