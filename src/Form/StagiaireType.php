<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Stagiaire;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un nom!'
                    ]),
                    ],
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un prénom!'
                    ]),
                    ],
            ])
            ->add('dateNaissance', DateType::class,[
                'constraints' => [
                    new LessThan([
                        'value' => $options['date']
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez saisir une date de naissance!'
                    ]),
                    ],
                'widget' => 'choice',
                // Crée un tableau contenant une rangée d'élements, ici [2024 .... 1924]
                'years' => range(date('Y'), date('Y')- 100)
            ] )
            ->add('ville', TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une ville!'
                    ]),
                    ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un email!'
                    ]),
                    ],
            ])
            ->add('telephone', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[0-9]{10}$/',
                        'message' => 'Le format n\'est pas valide! Le numéro doit contenir 10 chiffres!'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez saisir un numéro de téléphone!'
                    ]),
                    ],
            ])
            ->add('sexe', ChoiceType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez choisir un sexe!'
                    ]),
                    ],
                'choices' => [
                    'Masculin' => 'M',
                    'Féminin' => 'F'
                ],
            ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
            'date' => false
        ]);
    }
}
