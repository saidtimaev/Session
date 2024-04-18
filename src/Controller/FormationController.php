<?php

namespace App\Controller;

use App\Repository\FormationRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
