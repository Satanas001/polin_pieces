<?php

namespace App\Controller;

use App\Entity\DeviceModel;
use App\Entity\DeviceType;
use App\Entity\SparePart;
use App\Repository\DeviceTypeRepository;
use App\Repository\SparePartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
  

    #[Route('/category/{designation}', name: 'app_category')]
    public function index(SparePart $sparePart , DeviceType $deviceType, DeviceModel $deviceModel, Request $request,SparePartRepository $spareRepository,DeviceTypeRepository $deviceTypeRepository): Response

    {
        $form = $this->createFormBuilder(null)
        ->add('search', TextType ::class,[
            'attr' => ['class' =>'form-control form-control-lg  text-center my-3',
        
            'placeholder'=> 'référence pièce'
        ],
            'label' => false ,
            
        ])        
        ->getForm(); 
        
        return $this->render('category/index.html.twig', [
            'sparePart' => $sparePart,  
            'deviceType' => $deviceType,
            'deviceModel' => $deviceModel,
            'form' => $form->createView(),
            
        ]);
    }       
}
