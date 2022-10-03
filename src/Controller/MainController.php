<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/products', name: 'pro_ducts')]
    public function products(): Response
    {
        return $this->render('main/products.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/details', name: 'de_tails')]
    public function details(): Response
    {
        return $this->render('main/details.html.twig');
    }
    #[Route('/panier', name: 'panier')]
    public function panier(): Response
    {
        return $this->render('main/panier.html.twig');
    }
    #[Route('/profile', name: 'profile')]
    public function profile(): Response
    {
        return $this->render('main/profile.html.twig');
    }

}


