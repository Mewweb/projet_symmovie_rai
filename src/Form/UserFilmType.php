<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\User;
use App\Entity\UserFilm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateAjout', null, [
                'widget' => 'single_text',
            ])
            ->add('abonne', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('film', EntityType::class, [
                'class' => Film::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserFilm::class,
        ]);
    }
}
