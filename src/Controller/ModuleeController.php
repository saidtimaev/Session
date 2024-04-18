<?php

namespace App\Controller;

use App\Repository\ModuleeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModuleeController extends AbstractController
{
    #[Route('/modulee', name: 'app_modulee')]
    public function index(ModuleeRepository $moduleeRepository): Response
    {
        $modulees = $moduleeRepository->findBy([],['intitule' => 'ASC']);

        return $this->render('modulee/index.html.twig', [
            'modulees' => $modulees,
        ]);
    }
}
