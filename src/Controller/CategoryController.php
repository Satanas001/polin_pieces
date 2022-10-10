<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\DeviceType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
  
    #[Route('/category/{designation}', name: 'category_index')]
    public function index(Category $category, Request $request): Response
    {
        return $this->render('category/index.html.twig', [
            'category' => $category,
            'pageName' => $category->getDesignation(),
        ]);
    }     
    
    #[Route('/deviceType/{id}', name: 'category_device_type')]
    public function deviceType(DeviceType $deviceType): Response
    {
        $models = $deviceType->getDeviceModels() ;
        $data = [] ;
        foreach ($models as $key => $model) {
            $data[$key]['designation'] = $model->getDesignation() ;
            $data[$key]['id'] = $model->getId() ;
        }
        
        return new JsonResponse(['data' => $data]) ;
    }
}
