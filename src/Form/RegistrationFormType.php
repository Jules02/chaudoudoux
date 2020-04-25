<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur (prenom.nom sans aucun accent en miniscule, traits d\'unions et apostrophes supprimés ex. Léa Martin-Petit devient lea.martinpetit)'
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom (normal, avec majuscule au début et accents)'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom (pareil)'
            ])
            ->add('titre', ChoiceType::class, [
                'label' => 'Titre/fonction',
                'choices' => array(
                    'Élève' => "eleve",
                    'Enseignant' => "enseignant"
                ),
                'multiple' => false,
                'required' => true
            ])
            ->add('classe', TextType::class, array(
                'label' => 'Classe (ex. TES3)',
                'required' => false,
            ))
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe (cliquer sur le champ, il se génére tout seul et il est déjà copié dans le presse-papier',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Il faut entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit faire au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
