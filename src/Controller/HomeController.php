<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(SessionRepository $sessionRepository): Response
    {
        $dateActuelle = new \DateTime();

        $sessionsPassees = $sessionRepository->findSessionsPassees($dateActuelle->format('Y-m-d'));

        $sessionsEnCours = $sessionRepository->findSessionsEnCours($dateActuelle->format('Y-m-d'));

        $sessionsPrevues = $sessionRepository->findSessionsPrevues($dateActuelle->format('Y-m-d'));

        return $this->render('home/index.html.twig', [
            'sessionsPassees' => $sessionsPassees,
            'sessionsEnCours' => $sessionsEnCours,
            'sessionsPrevues' => $sessionsPrevues
        ]);
    }



}
