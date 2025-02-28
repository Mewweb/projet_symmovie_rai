<?php

namespace App\Form;

use App\Entity\Film;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label'=> "Le titre du film"])
            ->add('image', TextType::class, ['label' => "La photo du film"])
            ->add('description', TextType::class, ['label' => "La description du film"])
            ->add('dateSortie', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => "La date de sortie du film"
            ])
            ->add('genre', TextType::class, ['label' => "Le genre du film"])
            ->add( 'sauvegarder', SubmitType::class, ['label' => "Sauvegarder"]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
