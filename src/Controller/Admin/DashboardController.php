<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Company;
use App\Entity\DeviceModel;
use App\Entity\DeviceType;
use App\Entity\Document;
use App\Entity\DocumentCategory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud ;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

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

        yield MenuItem::section('Matériel') ;

        yield MenuItem::subMenu('Catégorie', 'fa-solid fa-bars')->setSubItems([
            menuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', Category::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fa-solid fa-eye', Category::class),
        ]) ;
        yield MenuItem::subMenu('Type', 'fa-solid fa-bars')->setSubItems([
            menuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', DeviceType::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fa-solid fa-eye', DeviceType::class),
        ]) ;
        yield MenuItem::subMenu('Modèle', 'fa-solid fa-fan')->setSubItems([
            menuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', DeviceModel::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fa-solid fa-eye', DeviceModel::class),
        ]) ;

        yield MenuItem::section('Documentation') ;

        yield MenuItem::subMenu('Catégorie', 'fa-solid fa-bars')->setSubItems([
            menuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', DocumentCategory::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fa-solid fa-eye', DocumentCategory::class),
        ]) ;
        yield MenuItem::subMenu('Documents', 'fa-regular fa-folder-open')->setSubItems([
            menuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', Document::class)->setAction(Crud::PAGE_NEW),
            menuItem::linkToCrud('Liste','fa-solid fa-eye', Document::class),
        ]) ;

        yield MenuItem::section('Utilisateurs') ;

        yield MenuItem::subMenu('Sociétés', 'fa-regular fa-building')->setSubItems([
            menuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', Company::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fa-solid fa-eye', Company::class),
        ]) ;

        yield MenuItem::section('Devis') ;

        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
