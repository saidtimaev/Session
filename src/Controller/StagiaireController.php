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
        // $stagiaires = $stagiaireRepository->findBy([],['nom'=>'ASC']);
        // dump($stagiaires->sessions);die;

        $dateActuelle = new \DateTime();

        $stagiairesSessionsPrevues = $stagiaireRepository->NbSessionsStagiaires($dateActuelle->format('Y-m-d'));

        // dd(($stagiairesSessionsPrevues));die;

        return $this->render('stagiaire/index.html.twig', [
            'stagiairesSessionsPrevues' => $stagiairesSessionsPrevues
        ]);
    }

    #[Route('stagiaire/{id}', name: 'show_stagiaire')]
    public function show(Stagiaire $stagiaire){
        
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire'=> $stagiaire
        ]);
    }
}
