<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\SessionRepository;
use App\Repository\StagiaireRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session/{id}', name: 'show_session')]
    public function show(Session $session, SessionRepository $sessionRepository): Response
    {
        $stagiaires = $sessionRepository->StagiairesNonInscrits($session);

        return $this->render('session/show.html.twig', [
            'session' => $session,
            'stagiaires' => $stagiaires
        ]);
    }   

    

}
