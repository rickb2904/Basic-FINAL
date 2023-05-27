<?php

namespace App\Form;

use App\Entity\Inscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

            $builder->add('date', DateType::class, [
                'label' => 'Date : ',
                'format' => 'dd MMMM yyyy',
                'data' => new \DateTime(), // Utilise la date du jour par défaut

            ])
            ->add('adherent', null, [
                'label' => 'Adhérent : ',
            ])
            ->add('seancecollective', null, [
                'label' => 'Choisir la séance collective : ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
