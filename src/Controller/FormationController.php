<?php

namespace App\Controller;

use App\Entity\Formation;
use Doctrine\ORM\EntityRepository;
use App\Repository\SessionRepository;
use App\Repository\FormationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(FormationRepository $formationRepository): Response
    {
        $formations = $formationRepository->findBy([],["intitule" => "ASC"]);

        return $this->render('formation/index.html.twig', [
            'formations' => $formations
        ]);
    }

    #[Route('/formation/{id}', name: 'sessionsParFormation')]
    public function sessionsParFormation(Formation $formation): Response
    {
        return $this->render('formation/sessionsParFormation.html.twig', [
            'formation' => $formation
        ]);
    }
}
