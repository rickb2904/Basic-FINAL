<?php

namespace App\Form;

use App\Entity\SeanceCollective;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeanceCollectiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('datecollective', DateTimeType::class, [
                'label' => 'Date et heure : ',
                'date_format' => 'dd MMMM yyyy',
                'date_widget' => 'choice',
                'time_widget' => 'choice',
                'data' => new \DateTime(), // Utilise la date et l'heure actuelles par défaut
            ])

            ->add('nb_place', IntegerType::class, [
                'label' => 'Nombre de places : ',
            ])
            ->add('nomSeanceCollective', TextType::class, [
                'label' => 'Nom de la séance collective : ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeanceCollective::class,
        ]);
    }
}
