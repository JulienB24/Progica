<?php

namespace App\Controller\Admin;

use App\Controller\Admin\GiteCrudController;
use App\Entity\Contact;
use App\Entity\Equipement;
use App\Entity\Gite;
use App\Entity\Proprietaire;
use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(GiteCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new ()
            ->setTitle('PROGICA');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Gites', 'fas fa-gite', Gite::class);
        yield MenuItem::linkToCrud('Equipements', 'fas fa-gite', Equipement::class);
        yield MenuItem::linkToCrud('Services', 'fas fa-gite', Service::class);
        yield MenuItem::linkToCrud('Proprietaires', 'fas fa-gite', Proprietaire::class);
        yield MenuItem::linkToCrud('Contacts', 'fas fa-gite', Contact::class);

    }
}