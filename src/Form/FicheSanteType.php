<?php

namespace App\Form;

// FicheSanteType.php

use App\Entity\FicheSante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class FicheSanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('poids', IntegerType::class, [
                'label' => 'Poids (en kg) : ',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez spécifier le poids.']),
                    new Positive(['message' => 'Le poids doit être un nombre positif.']),
                ],
            ])
            ->add('taille', IntegerType::class, [
                'label' => 'Taille (en cm) : ',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez spécifier la taille.']),
                    new Positive(['message' => 'La taille doit être un nombre positif.']),
                ],
            ])
            ->add('date', DateTimeType::class, [ // Modifiez le type en DateTimeType
                'label' => 'Date et heure : ', // Mettez à jour le libellé du champ
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy HH:mm', // Spécifie le format d'affichage de la date et de l'heure
                'data' => new \DateTime(), // Définit la date et l'heure actuelles comme valeur par défaut
                'disabled' => true, // Désactive le champ pour empêcher la modification
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FicheSante::class,
        ]);
    }
}

