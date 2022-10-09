<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\DeviceModel;
use App\Entity\DeviceType;
use App\Entity\SparePart;
use App\Repository\CategoryRepository;
use App\Repository\DeviceModelRepository;
use App\Repository\DeviceTypeRepository;
use App\Repository\SparePartRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
  
    #[Route('/category/{designation}', name: 'category_index')]
    public function index(SparePart $sparePart , DeviceType $deviceType, DeviceModel $deviceModel,Category $category, Request $request,SparePartRepository $sparePartRepository,DeviceTypeRepository $deviceTypeRepository, DeviceModelRepository $deviceModelRepository,CategoryRepository $categoryRepository ): Response

    {
        $form = $this->createFormBuilder()
                            // ['deviceType'=> $deviceTypeRepository->find(2)]
                            // ->addEventListener(FormEvents ::PRE_SET_DATA,function (FormEvent $event) use ($deviceModelRepository) { 
                            //     $deviceType=($event->getData())['deviceType'] ?? null;

                            //     // show All model in deviceType

                            //              $event->getForm()   ->add('matricule', EntityType::class, [
                            //                 'class' => DeviceModel::class,
                            //                 'attr' => ['class' =>'form-control form-control-lg  text-center my-3',                     
                            //                      ],
                            //                 'label' => false ,
                            //                 // 'choise'  =>  $models,  
                            //                 'query_builder' => function(DeviceModelRepository $deviceModelRepository) use ($deviceType ){
                            //                      return $deviceModelRepository->createQueryBuilder('d')
                            //                     ->andWhere('d.deviceType = :deviceType')
                            //                     ->setParameter('deviceType', $deviceType)
                            //                     ;
                            //                 },
                                            
                            //                 'placeholder'=> 'matricule machine',
                                            
                            //                     ]);
                            // })

        ->add('matricule', EntityType::class, [
            'class' => DeviceModel::class,
            'attr' => ['class' =>'form-control form-control-lg  text-center my-3',                     
                 ],
            'label' => false ,
            'query_builder' => function(DeviceModelRepository $deviceModelRepository) use ($deviceType ){
                 return $deviceModelRepository->createQueryBuilder('d')
                ->andWhere('d.deviceType = :deviceType')
                ->setParameter('deviceType', $deviceType)
                ;
            },
            
            'placeholder'=> 'matricule machine',
            
                ])

        ->add('deviceType', EntityType ::class,[   
            'placeholder'=> 'type machine/liste',
            'class' => DeviceType ::class,
            'attr' => ['class' =>'form-control form-control-lg  text-center my-3'
        ],
            'label' => false ,
            'query_builder' => function(DeviceTypeRepository $deviceTypeRepository) use ($category ){
                return $deviceTypeRepository->createQueryBuilder('d')
               ->andWhere('d.category = :category')
               ->setParameter('category', $category)
               ;
           },
           
            

                ])   
            ->add('reference', EntityType ::class,[
                'class' => SparePart ::class,
                            'attr' => ['class' =>'form-control form-control-lg  text-center my-3',
                            'placeholder'=> 'référence pièce'
                        ],
                            'label' => false ,
                     
                            
            ]) 
            ->add('Rechercher', SubmitType ::class, [
                'attr' => [
                    'class' =>'btn btn-light text-center mt-4 '
                ]
            ])
          ->getForm();  
          

        $serchbyCategorie = $request->get('form');

        $reference = $sparePartRepository->findOneByReference($serchbyCategorie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
              // rehcerche les Articles correspondants aux refrences  

              if( $reference  ){
                return $this->redirectToRoute('details_index', ['reference' =>  $reference->getReference()]);
            }
            else {
            $this->addFlash('warning', 
            "Erreur de référence !");
                
            }
        }
        
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'sparePart' => $sparePart,  
            'deviceType' => $deviceTypeRepository->findAll(),
            'deviceModel' => $deviceModel,
            'category' => $category,
            'form' => $form->createView(),
            
        ]);
    }       
}
