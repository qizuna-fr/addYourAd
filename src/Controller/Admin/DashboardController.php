<?php

namespace App\Controller\Admin;

use App\Entity\Ad;
use App\Controller\Admin\AdCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(AdCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('AddYourAd');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Ads', 'fa-solid fa-rectangle-ad', Ad::class);
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->overrideTemplates([
                'crud/edit' => 'ad/index.html.twig',
            ])
        ;
    }

    #[Route('/', name: 'rediect_admin')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function redirectAdmin(): Response
    {
        return $this->redirectToRoute('admin');
    }
}
