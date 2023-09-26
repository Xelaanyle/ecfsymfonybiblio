<?php

namespace App\Form;

use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\Emprunteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateEmprunt')
            ->add('dateRetour')
            ->add('livre', EntityType::class, [
                'class' => Livre::class,
                'choice_label' => 'titre',
            ])
            ->add('emprunteur' , EntityType::class, [
                'class' => Empruteur::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
