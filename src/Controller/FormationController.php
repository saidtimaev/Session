<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use Doctrine\ORM\EntityRepository;
use App\Repository\SessionRepository;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/formation/new', name:'new_formation')]
    #[Route('/formation/{id}/edit', name:'edit_formation')]
    // Ajout ou édition formation
    public function new_edit( Formation $formation = null, Request $request, EntityManagerInterface $entityManager): Response{

        if(!$formation){
            $formation = new Formation();   
        }

        // Création du formulaire d'ajout ou d'édition
        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $formation = $form->getData();
            // Prepare PDO
            $entityManager->persist($formation);
            // Execute PDO
            $entityManager->flush();

            return $this->redirectToRoute('app_formation');
        }

        return $this->render('formation/new.html.twig', [
            'formAddFormation' => $form,
        ]);
    }

     // Supprimer une formation
     #[Route('/employe/{id}/delete', name:'delete_formation')]
     public function delete(Formation $formation, EntityManagerInterface $entityManager){
         
         $entityManager->remove($formation);
         $entityManager->flush();
 
         return $this->redirectToRoute('app_formation');
 
     }

    #[Route('/formation/{id}', name: 'sessionsParFormation')]
    public function sessionsParFormation(Formation $formation): Response
    {
        return $this->render('formation/sessionsParFormation.html.twig', [
            'formation' => $formation
        ]);
    }

   
}
