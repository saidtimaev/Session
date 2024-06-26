<?php

namespace App\Form;

use App\Entity\Modulee;
use App\Entity\Programme;
use App\Entity\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duree', IntegerType::class, [
                'required' => false,
                'constraints' => [
                    new Positive([
                        'message' => 'La durée doit être supérieure à 0!'
                    ]),
                    ],
            ])
            ->add('modulee', EntityType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez choisir un module!'
                    ]),
                    ],
                'class' => Modulee::class,
                'choice_label' => 'intitule',
            ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}
