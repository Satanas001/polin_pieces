<?php

namespace App\Controller;

use App\Repository\SparePartRepository;
use App\Entity\SparePart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailsController extends AbstractController
{
    public function __construct( private SparePartRepository $spareRepository)
    
    { 

    }
 
    #[Route('/details/{reference}', name: 'details_index')]
    public function index(SparePart $sparePart = null,$reference): Response
    {
        
        if ($sparePart === null || $sparePart->getReference() !== $reference  ) {
          
                return $this->redirectToRoute('main_index');
        }
        
        return $this->render('details/index.html.twig', [
            'sparePart' => $sparePart,
            'pageName' => 'Pièce détachée'
        ]);
    }

    #[Route('/details', name: 'detail_index')]
    public function details(): Response
    {           
            return $this->redirectToRoute('main_index');
    }

}
