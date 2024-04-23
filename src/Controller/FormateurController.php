<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Form\FormateurType;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    #[Route('/formateur', name: 'app_formateur')]
    public function index(FormateurRepository $formateurRepository): Response
    {
        $formateurs = $formateurRepository->findBy([],['nom'=>'ASC']);

        // $dateActuelle = new \DateTime();

        // $formateursSessionsPrevues = $formateurRepository->NbSessionsFormateurs($dateActuelle->format('Y-m-d'));
        
        return $this->render('formateur/index.html.twig', [
            'formateurs'=> $formateurs
        ]);
    }

    #[Route('/formateur/new', name:'new_formateur')]
    #[Route('/formateur/{id}/edit', name:'edit_formateur')]
    // Ajout ou édition formateur
    public function new_edit( Formateur $formateur = null, Request $request, EntityManagerInterface $entityManager): Response{

        if(!$formateur){
            $formateur = new Formateur();   
        }

        // Création du formulaire d'ajout ou d'édition
        $form = $this->createForm(FormateurType::class, $formateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $formateur = $form->getData();
            // Prepare PDO
            $entityManager->persist($formateur);
            // Execute PDO
            $entityManager->flush();

            return $this->redirectToRoute('app_formateur');
        }

        return $this->render('formateur/new.html.twig', [
            'formAddFormateur' => $form,
        ]);
    }

     // Supprimer un formateur
     #[Route('/formateur/{id}/delete', name:'delete_formateur')]
     public function delete(Formateur $formateur, EntityManagerInterface $entityManager){
         
         $entityManager->remove($formateur);
         $entityManager->flush();
 
         return $this->redirectToRoute('app_formateur');
 
     }

    #[Route('formateur/{id}', name: 'show_formateur')]
    public function show(Formateur $formateur){
        
        return $this->render('formateur/show.html.twig', [
            'formateur'=> $formateur
        ]);
    }
}
