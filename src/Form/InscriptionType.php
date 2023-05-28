<?php

namespace App\Form;

use App\Entity\Inscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class InscriptionType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        $builder->add('date', DateTimeType::class, [
            'label' => 'Date et heure : ',
            'date_format' => 'dd MMMM yyyy',
            'date_widget' => 'choice',
            'time_widget' => 'choice',
            'data' => new \DateTime(), // Utilise la date et l'heure actuelles par défaut
        ])

            ->add('adherent', null, [
                'label' => 'Adhérent : ',
                'disabled' => true, // Désactive le champ pour empêcher la modification
                'data' => $user,  // Pass the User object, not the email
            ])
            ->add('seancecollective', null, [
                'label' => 'Choisir la séance collective : ',
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
