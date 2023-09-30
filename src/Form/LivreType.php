<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Genre;
use Doctrine\ORM\EntityRepository;
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
                'choice_label' => function(Genre $genre) {
                    return "{$genre->getNom()}";
                },
                'attr' => ['class' => 'form_scrollable-checkboxes'],
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                    ->orderby('g.nom', 'ASC');
                },
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
