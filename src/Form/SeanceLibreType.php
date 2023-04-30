<?php

namespace App\Form;

use App\Entity\SeanceLibre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeanceLibreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nb_activite', IntegerType::class, [
                'label' => "Nombre de places :",
            ])
            ->add('nomSeanceLibre', TextType::class, [
                'label' => "Nom de la séance libre :",
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeanceLibre::class,
        ]);
    }
}
