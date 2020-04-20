<?php

namespace App\Form;

use App\Entity\Chaudoudoux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChaudoudouxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('toUser', TextType::class, [
                'label'  => false,
                'attr' => array(
                    'class' => 'toUser-field',
                    'placeholder' => "Choisissez un élève, enseignant, personnel de l'administration, du lycée, etc."
                ),
            ])
            ->add('image', ChoiceType::class, [
                'label'  => false,
                'attr' => array(
                    'class' => 'image-field'
                ),
                'choices'  => [
                    'Photo Star wars' => "star-wars.jpg",
                    'Photo lycée' => "lycee.jpg",
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('text', TextareaType::class, [
                'label'  => false,
                'attr' => array(
                    'class' => 'text-field',
                    'placeholder' => "Soyez créatifs ;)",
                    'rows' => '10'
                ),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chaudoudoux::class,
        ]);
    }
}
