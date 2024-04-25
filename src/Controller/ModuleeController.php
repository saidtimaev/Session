<?php

namespace App\Controller;

use App\Entity\Modulee;
use App\Entity\Categorie;
use App\Form\ModuleeType;
use App\Form\ModuleeCatType;
use App\Repository\ModuleeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/modulee/new', name:'new_modulee')]
    #[Route('/modulee/{id}/new', name:'new_modulee_cat')]
    #[Route('/modulee/{id}/edit', name:'edit_modulee')]
    public function new_edit(Modulee $modulee = null, Categorie $categorie = null, Request $request, EntityManagerInterface $entityManager): Response{

        if(!$modulee){
            $modulee = new Modulee();   
        }

        
        if(!$categorie){
            
            // Création du formulaire d'ajout ou d'édition
            $form = $this->createForm(ModuleeType::class, $modulee);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                $modulee = $form->getData();
                // Prepare PDO
            
                $entityManager->persist($modulee);
                // Execute PDO
                $entityManager->flush();

                // On passe l'id de la formation pour le redirect sur les modules de la formation
                return $this->redirectToRoute('app_modulee');
            } 
        } else {

            // Création du formulaire d'ajout ou d'édition
            $form = $this->createForm(ModuleeCatType::class, $modulee);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                $modulee = $form->getData();
                // Prepare PDO

                $modulee->setCategorie($categorie);
            
                $entityManager->persist($modulee);
                // Execute PDO
                $entityManager->flush();

                // On passe l'id de la formation pour le redirect sur les modules de la formation
                return $this->redirectToRoute('show_categorie', ['id' => $categorie->getId()]);
            } 
        }      

        return $this->render('modulee/new.html.twig', [
            'formAddModulee' => $form,
            'categorie' => $categorie
        ]);
    }

    #[Route('/modulee/{id}/delete', name:'delete_modulee')]
     public function delete(Modulee $modulee, EntityManagerInterface $entityManager){

        $categorie = $modulee->getCategorie()->getId();
         
         $entityManager->remove($modulee);
         $entityManager->flush();
 
         return $this->redirectToRoute('show_categorie', ['id' => $categorie]);
 
     }
}
