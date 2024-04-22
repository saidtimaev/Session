<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Repository\FormateurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    #[Route('/formateur', name: 'app_formateur')]
    public function index(FormateurRepository $formateurRepository): Response
    {
        // $formateurs = $formateurRepository->findBy([],['nom'=>'ASC']);

        $dateActuelle = new \DateTime();

        $formateursSessionsPrevues = $formateurRepository->NbSessionsFormateurs($dateActuelle->format('Y-m-d'));
        
        return $this->render('formateur/index.html.twig', [
            'formateurs'=> $formateursSessionsPrevues
        ]);
    }

    #[Route('formateur/{id}', name: 'show_formateur')]
    public function show(Formateur $formateur){
        
        return $this->render('formateur/show.html.twig', [
            'formateur'=> $formateur
        ]);
    }
}
