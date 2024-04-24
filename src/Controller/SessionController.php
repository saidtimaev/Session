<?php

namespace App\Controller;

use App\Entity\Modulee;
use App\Entity\Session;
use App\Entity\Formation;
use App\Entity\Programme;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use App\Form\ProgrammeType;
use App\Repository\SessionRepository;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SessionController extends AbstractController
{
    

    
   

    #[Route('/session/{id}', name: 'show_session')]

    public function show(Session $session, SessionRepository $sessionRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $stagiaires = $sessionRepository->StagiairesNonInscrits($session);

        $form = $this->createForm(ProgrammeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $programme = $form->getData();
            // Prepare PDO
            //On passe l'objet session manuellement
            $programme->setSession($session);

            $entityManager->persist($programme);
            // Execute PDO
            $entityManager->flush();

            // On passe l'id de la session pour le redirect sur les infos de la session
            return $this->redirectToRoute('show_session',['id' => $session->getId()]);
        }

        return $this->render('session/show.html.twig', [
            'session' => $session,
            'stagiaires' => $stagiaires,
            'formAddProgramme' => $form
        ]);
    }   

    #[Route('/session/stagiaire/delete/{id}/{idStagiaire}', name: 'delete_stagiaire_from_session')]
    public function deleteStagiaire(Session $session, #[MapEntity(id: 'idStagiaire')] Stagiaire $stagiaire, EntityManagerInterface $entityManager): RedirectResponse
    {
        $session->removeStagiaire($stagiaire);
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($session);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('show_session',['id'=>$session->getId()]); 
    }  

    #[Route('/session/stagiaire/add/{id}/{idStagiaire}', name: 'add_stagiaire')]
    public function add(Session $session, #[MapEntity(id: 'idStagiaire')] Stagiaire $stagiaire, EntityManagerInterface $entityManager): RedirectResponse
    {
        $session->addStagiaire($stagiaire);
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($session);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('show_session',['id'=>$session->getId()]); 
    }  

    #[Route('/session/{id}/delete', name:'delete_session')]
    public function delete(Session $session, EntityManagerInterface $entityManager){
       
       $formation = $session->getFormation()->getId();

        $entityManager->remove($session);
        $entityManager->flush();

        return $this->redirectToRoute('sessionsParFormation',['id' => $formation]);
   }

   #[Route('/session/{id}/programme/delete', name:'delete_programme')]
    public function deleteProgramme(Programme $programme, EntityManagerInterface $entityManager){
       
       $session = $programme->getSession()->getId();

        $entityManager->remove($programme);
        $entityManager->flush();

        return $this->redirectToRoute('show_session',['id' => $session]);
   }

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


}


