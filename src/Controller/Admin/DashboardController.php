<?php

namespace App\Controller\Admin;

use App\Entity\Document;
use App\Entity\DocumentCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud ;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    public function __construct(private AdminUrlGenerator $adminUrlGenerator) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(CategoryCrudController::class)
            ->generateUrl() ;

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Polin Pieces');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Documentation') ;

        yield MenuItem::subMenu('Catégorie', 'fa-solid fa-bars')->setSubItems([
            menuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', DocumentCategory::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fa-solid fa-eye', DocumentCategory::class),
        ]) ;
        yield MenuItem::subMenu('Documents', 'fa-regular fa-folder-open')->setSubItems([
            menuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', Document::class)->setAction(Crud::PAGE_NEW),
            menuItem::linkToCrud('Liste','fa-solid fa-eye', Document::class),
        ]) ;

        yield MenuItem::section('Matériel') ;

        yield MenuItem::section('Utilisateurs') ;

        yield MenuItem::section('Devis') ;

        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
