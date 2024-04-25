<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findBy([],['nom' => 'ASC']);

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/categorie/new', name:'new_categorie')]
    #[Route('/categorie/{id}/edit', name:'edit_categorie')]
    public function new_edit(Categorie $categorie = null, Request $request, EntityManagerInterface $entityManager): Response{

        if(!$categorie){
            $categorie = new Categorie();   
        }


        // Création du formulaire d'ajout ou d'édition
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $categorie = $form->getData();
            // Prepare PDO
           
            $entityManager->persist($categorie);
            // Execute PDO
            $entityManager->flush();

            // On passe l'id de la formation pour le redirect sur les modules de la formation
            return $this->redirectToRoute('app_categorie');
        }

        return $this->render('categorie/new.html.twig', [
            'formAddCategorie' => $form,
        ]);
    }

    #[Route('/categorie/{id}/delete', name:'delete_categorie')]
     public function delete(Categorie $categorie, EntityManagerInterface $entityManager){
         
         $entityManager->remove($categorie);
         $entityManager->flush();
 
         return $this->redirectToRoute('app_categorie');
 
     }

     #[Route('categorie/{id}', name: 'show_categorie')]
    public function show(Categorie $categorie, CategorieRepository $categorieRepository){

        
        return $this->render('categorie/show.html.twig', [
            'categorie'=> $categorie
        ]);
    }
}
