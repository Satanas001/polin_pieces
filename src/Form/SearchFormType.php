<?php

namespace App\Form;

use App\Entity\DeviceModel;
use App\Entity\DeviceType;
use App\Entity\SparePart;
use App\Repository\DeviceModelRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function __construct(private DeviceModelRepository $deviceModelRepository){}
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

                // ->addEventListener(FormEvents::PRE_SET_DATA,function (FormEvent $event) {
                //     $deviceType = $event->getData() ['deviceType' ]?? null;
                //     $models = $deviceType === null ? [] : $this->deviceModelRepository->findByDeviceType($deviceType,['name' =>'ASC']);


                //     $event->GetForm()->add('matricule', EntityType::class, [
                //         'class' => DeviceModel::class,
                //         'attr' => ['class' =>'form-control form-control-lg  text-center my-3',
                //              ],
                //         'label' => false ,
                //         'choice_label' => 'name',
                       
                //         'placeholder'=> 'matricule machine',
                //         'choices' => $models
                //     ]);
                // } )
                
                ->add('matricule', EntityType::class, [
                    'class' => DeviceModel::class,
                    'attr' => ['class' =>'form-control form-control-lg  text-center my-3',
                         ],
                    'label' => false ,
                  
         
                    'placeholder'=> 'matricule machine',
                    
                ])

        ->add('deviceType', EntityType ::class,[   
            'placeholder'=> 'type machine/liste',
            'class' => DeviceType ::class,
            'attr' => ['class' =>'form-control form-control-lg  text-center my-3'
        ],
            'label' => false ,

                ])   


            ->add('search', TextType ::class,[
                            'attr' => ['class' =>'form-control form-control-lg  text-center my-3',
                            'placeholder'=> 'référence pièce'
                        ],
                            'label' => false ,
                            
             ]) 
             ->add('Rechercher', SubmitType ::class, [
                'attr' => [
                    'class' =>'btn btn-light text-center mt-4 '
                ]
            ]); 
    


    // $builder->addEventListener(
    //     FormEvents::PRE_SET_DATA,
    //     function (FormEvent $event) use ($formModifier) {
    //         $data = $event->getData();

    //         $formModifier($event->getForm(), $data->getDeviceModel());
    //     }
    // );

    // $builder->get('deviceTypes')->addEventListener(
    //     FormEvents::POST_SUBMIT,
    //     function (FormEvent $event) use ($formModifier) {
    //         $deviceType = $event->getForm()->getData();

    //         $formModifier($event->getForm()->getParent(), $deviceType);
    //     }
    // );
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
     
        ]);
    }
}
