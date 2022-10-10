<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\SparePartRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    #[Route('/home', name: 'main_index')]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request, SparePartRepository $sparePartRepository): Response
    {
        $categories = $this->categoryRepository->findAll();
        // ([], ['designation' => 'ASC','isEnabled']);

        $form = $this->createFormBuilder(null)
            ->add('search', TextType::class, [
                'attr' => [
                    'class' => 'form-control form-control-lg text-center ',
                    'placeholder' => 'référence article'
                ],
                'label' => false,
            ])
            ->add('Enter', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success mt-4',
                ],
                'label' => 'VALIDER'
            ])
            ->getForm();

        $serchbyReference = $request->get('form');

        $reference = $sparePartRepository->findOneByReference($serchbyReference);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($reference) {
                // todo faire une redirection vers la page detail avec lid 
                return $this->redirectToRoute('details_index', ['reference' =>  $reference->getReference()]);
            } 
            else {
                $this->addFlash(
                    'danger',
                    "Référence inconnue."
                );
                
            }
        }

        return $this->render('main/index.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(),
            'pageName' => 'Accueil'
        ]);
    }
}
