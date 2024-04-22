<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Repository\StagiaireRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagiaireController extends AbstractController
{
    #[Route('/stagiaire', name: 'app_stagiaire')]
    public function index(StagiaireRepository $stagiaireRepository): Response
    {
        $stagiaires = $stagiaireRepository->findBy([],['nom'=>'ASC']);
        // dump($stagiaires->sessions);die;

        return $this->render('stagiaire/index.html.twig', [
            'stagiaires'=> $stagiaires
        ]);
    }

    #[Route('stagiaire/{id}', name: 'show_stagiaire')]
    public function show(Stagiaire $stagiaire){
        
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire'=> $stagiaire
        ]);
    }
}
