<?php

namespace App\Form;
use App\Entity\SparePart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference',null,
            [
            'attr' => [
                'class' =>'form-control form-control-lg form-control-borderless'
            ],
            'label' => false,
            'placeholder'=>'Article',
            ])
            ->add('submit',SubmitType::class)
            
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           'data_class' => SparePart ::class,
        ]);
    }
}
