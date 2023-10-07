<?php

namespace App\Form;

use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\Emprunteur;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'dateEmprunt',
                DateType::class,
                [
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'dateRetour',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'required' => false,
                ]
            )
            ->add('livre', EntityType::class, [
                'class' => Livre::class,
                'choice_label' => 'titre',
            ])
            ->add(
                'emprunteur',
                EntityType::class,
                [
                    'class' => Emprunteur::class,
                    'choice_label' => function (Emprunteur $emprunteur) {
                        return "{$emprunteur->getNom()} {$emprunteur->getPrenom()}";
                    },
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
