<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagiaireController extends AbstractController
{
    #[Route('/stagiaire', name: 'app_stagiaire')]
    public function index(StagiaireRepository $stagiaireRepository): Response
    {
        // $stagiaires = $stagiaireRepository->findBy([],['nom'=>'ASC']);
        // dump($stagiaires->sessions);die;

        $dateActuelle = new \DateTime();

        $stagiairesSessionsPrevues = $stagiaireRepository->NbSessionsStagiaires($dateActuelle->format('Y-m-d'));

        // dd(($stagiairesSessionsPrevues));die;

        return $this->render('stagiaire/index.html.twig', [
            'stagiairesSessionsPrevues' => $stagiairesSessionsPrevues
        ]);
    }

    #[Route('/stagiaire/new', name:'new_stagiaire')]
    #[Route('/stagiaire/{id}/edit', name:'edit_stagiaire')]
    // Ajout ou édition stagiaire
    public function new_edit( Stagiaire $stagiaire = null, Request $request, EntityManagerInterface $entityManager): Response{

        if(!$stagiaire){
            $stagiaire = new Stagiaire();   
        }

        // Création du formulaire d'ajout ou d'édition
        $form = $this->createForm(StagiaireType::class, $stagiaire);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $stagiaire = $form->getData();
            // Prepare PDO
            $entityManager->persist($stagiaire);
            // Execute PDO
            $entityManager->flush();

            return $this->redirectToRoute('app_stagiaire');
        }

        return $this->render('stagiaire/new.html.twig', [
            'formAddStagiaire' => $form,
        ]);
    }

    // Supprimer un stagiaire
    #[Route('/stagiaire/{id}/delete', name:'delete_stagiaire')]
    public function delete(Stagiaire $stagiaire, EntityManagerInterface $entityManager){
        
        $entityManager->remove($stagiaire);
        $entityManager->flush();

        return $this->redirectToRoute('app_stagiaire');

    }

    #[Route('stagiaire/{id}', name: 'show_stagiaire')]
    public function show(Stagiaire $stagiaire){
        
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire'=> $stagiaire
        ]);
    }

    
}
