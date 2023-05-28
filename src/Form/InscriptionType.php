<?php

namespace App\Form;

use App\Entity\Inscription;
use App\Entity\User;
use App\Entity\SeanceCollective;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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

        $builder
            ->add('adherent', EntityType::class, [
                'label' => 'Adhérent : ',
                'class' => User::class,
                'data' => $user, // Set the currently logged in user
                'choice_label' => 'email',
                'disabled' => true,
            ])

            ->add('seancecollective', EntityType::class, [
                'label' => 'Choisir la séance collective : ',
                'class' => SeanceCollective::class,
                'choice_label' => 'nomSeanceCollective',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
