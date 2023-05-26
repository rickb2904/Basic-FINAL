<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\SeanceLibre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SeanceLibreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nomSeanceLibre', TextType::class, [
                'label' => "Nom de la séance libre : ",
            ])
            ->add('dateseancelibre', DateType::class, [
                'label' => 'Date de la séance libre : ',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner une date.']),
                ],
                'data' => new \DateTime(), // Utilise la date du jour par défaut
            ])

            ->add('activites', EntityType::class, [
                'class' => Activite::class,
                'label' => "Sélectionner la/les Activités : ",
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'nom_activite',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeanceLibre::class,
        ]);
    }
}
