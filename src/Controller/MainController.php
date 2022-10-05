<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;

class MainController extends AbstractController
{
    public function __construct( private CategoryRepository $categoryRepository)
    {
        
    }

    #[Route('', name: 'main_index')]
    public function index(): Response
    {
         $categories = $this->categoryRepository->findBy([] , ['designation' => 'ASC']  );

        return $this->render('main/index.html.twig', [
            'categories' => $categories,
        ]);
    }
   

}


