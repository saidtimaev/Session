<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Formation;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    

    #[Route('/session/{id}/new', name:'new_session')]
    #[Route('/session/{id}/edit', name:'edit_session')]
    // Ajout ou édition session
    public function new_edit(Session $session = null, Formation $formation = null,  Request $request, EntityManagerInterface $entityManager): Response{

        if(!$session){
            $session = new Session();   
        }


        // Création du formulaire d'ajout ou d'édition
        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $session = $form->getData();
            // Prepare PDO
            //On passe l'objet formation manuellement
            $session->setFormation($formation);

            $entityManager->persist($session);
            // Execute PDO
            $entityManager->flush();

            // On passe l'id de la formation pour le redirect sur les sessions de la formation
            return $this->redirectToRoute('sessionsParFormation',['id' => $formation->getId()]);
        }

        return $this->render('session/new.html.twig', [
            'formAddSession' => $form,
        ]);
    }

    #[Route('/session/{id}/delete', name:'delete_session')]
     public function delete(Session $session, EntityManagerInterface $entityManager){
        
        $formation = $session->getFormation()->getId();

         $entityManager->remove($session);
         $entityManager->flush();
 
         return $this->redirectToRoute('sessionsParFormation',['id' => $formation]);
    }

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


