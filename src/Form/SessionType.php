<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThan;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un intitulé de session!'
                    ]),
                    ],
            ])
            ->add('dateDebut', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('dateFin', DateType::class, [
                'required' => false,
                'constraints' => [
                    new GreaterThan([
                        'propertyPath' => 'parent.all[dateDebut].data',
                        'message' => 'La date de fin doit être supérieure à la date de début!'
                    ]),
                    ],
                'widget' => 'single_text',
            ])
            ->add('places', IntegerType::class, [
                'required' => false,
                'constraints' => [
                    new Positive([
                        'message' => 'Le nombre de places doit être supérieur à 0!'
                    ]),
                    ],
            ])
            ->add('formateur', EntityType::class, [
                'required' => false,
                'class' => Formateur::class,
                'choice_label' => function ($formateur) {
                    return $formateur->getPrenom(). ' ' .strtoupper($formateur->getNom());
                },
                'placeholder' => 'Selectionnez un formateur',
            ])
            ->add('valider', SubmitType::class);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
