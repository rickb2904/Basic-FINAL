<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserTypeAdherent extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $array = array('coach, adherent');
        $builder

            ->add('email', EmailType::class, [
                'label' => "E-Mail : ",
            ])

            ->add('nom', TextType::class, [
                'label' => "Nom : ",
            ])

            ->add('prenom',TextType::class, [
                'label' => "Prénom : ",
            ])

            ->add('role', HiddenType::class, [
                'data' => 'adherent'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe : '],
                'second_options' => ['label' => 'Confirmer le mot de passe : ']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}