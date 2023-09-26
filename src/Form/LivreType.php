<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('anneeEdition')
            ->add('nombrePage')
            ->add('codeIsbn')
            ->add('genres' , EntityType::class, [
                'class' => Genre::class,
                'attr' => ['class' => 'form_scrollable-checkboxes'],
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('auteur' , EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
