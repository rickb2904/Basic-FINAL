<?php

namespace App\Form;

use App\Entity\SeanceCollective;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeanceCollectiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nb_place', IntegerType::class, [
                'label' => 'Nombre de places',
            ])
            ->add('nomSeanceCollective', TextType::class, [
                'label' => 'Nom de la séance collective',
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
