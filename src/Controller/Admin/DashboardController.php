<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Company;
use App\Entity\Category;
use App\Entity\Document;
use App\Entity\Quotation;
use App\Entity\SparePart;
use App\Entity\DeviceType;
use App\Entity\DeviceModel;
use App\Entity\DocumentCategory;
use App\Repository\UserRepository;
use App\Repository\CompanyRepository;
use App\Repository\CategoryRepository;
use App\Repository\DocumentRepository;
use App\Repository\SparePartRepository;
use App\Repository\DeviceTypeRepository;
use App\Repository\DeviceModelRepository;
use App\Repository\DocumentCategoryRepository;
use App\Repository\QuotationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud ;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator, 
        private UserRepository $userRepository,
        private CategoryRepository $categoryRepository,
        private DeviceTypeRepository $deviceTypeRepository,
        private DeviceModelRepository $deviceModelRepository,
        private SparePartRepository $sparePartRepository,
        private DocumentCategoryRepository $documentCategoryRepository,
        private DocumentRepository $documentRepository,
        private CompanyRepository $companyRepository,
        private QuotationRepository $quotationRepository,
        ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // $url = $this->adminUrlGenerator
        //     ->setController(CategoryCrudController::class)
        //     ->generateUrl() ;

        // return $this->redirect($url);
        return $this->render('admin/home_admin.html.twig', [
            'userCount' => $this->userRepository->userCount(),
            'categoryCount' => $this->categoryRepository->categoryCount(),
            'typeCount' => $this->deviceTypeRepository->typeCount(),
            'modelCount' => $this->deviceModelRepository->modelCount(),
            'partCount' => $this->sparePartRepository->partCount(),
            'documentCategoryCount' => $this->documentCategoryRepository->categoryCount(),
            'documentCount' => $this->documentRepository->documentCount(),
            'companyCount' => $this->companyRepository->companyCount(),
            'quotationCount' => $this->quotationRepository->quotationCount(),
            'quotationNotValidatedCount' => $this->quotationRepository->quotationNotValidatedCount(),
        ]) ;
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Polin Pieces');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');

        yield MenuItem::section('Matériel') ;

        yield MenuItem::subMenu('Catégorie', 'fa-solid fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', Category::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fa-solid fa-eye', Category::class),
        ]) ;
        yield MenuItem::subMenu('Type', 'fa-solid fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', DeviceType::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fa-solid fa-eye', DeviceType::class),
        ]) ;
        yield MenuItem::subMenu('Modèle', 'fa-solid fa-fan')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', DeviceModel::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fa-solid fa-eye', DeviceModel::class),
        ]) ;
        yield MenuItem::subMenu('Pièces détachées', 'fa-solid fa-puzzle-piece')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', SparePart::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fa-solid fa-eye', SparePart::class),
        ]) ;

        yield MenuItem::section('Documentation') ;

        yield MenuItem::subMenu('Catégorie', 'fa-solid fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', DocumentCategory::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fa-solid fa-eye', DocumentCategory::class),
        ]) ;
        yield MenuItem::subMenu('Documents', 'fa-regular fa-folder-open')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', Document::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste','fa-solid fa-eye', Document::class),
        ]) ;

        yield MenuItem::section('Utilisateurs') ;

        yield MenuItem::subMenu('Sociétés', 'fa-regular fa-building')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fa-solid fa-plus', Company::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fa-solid fa-eye', Company::class),
        ]) ;
        yield MenuItem::subMenu('Utilisateurs', 'fa-solid fa-users')->setSubItems([
            MenuItem::linkToCrud('Ajouter','fa-solid fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste','fa-solid fa-eye', User::class),
        ]) ;

        yield MenuItem::section('Devis') ;

        yield MenuItem::linkToCrud('Liste','fa-solid fa-eye', Quotation::class) ;


        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
