<?php

namespace App\Form;

use App\Entity\Chaudoudoux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChaudoudouxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('toUser', HiddenType::class)
            ->add('toUserFull', HiddenType::class)
            ->add('image', ChoiceType::class, [
                'label'  => false,
                'attr' => array(
                    'class' => 'image-field'
                ),
                'choices'  => [
                    'Photo Adam' => 'adam.jpg',
                    'Photo Roi Arouf' => 'arouf.jpg',
                    'Photo Bébé Yoda' => 'bebe-yoda.jpg',
                    'Photo Pablo Escobar' => 'escobar.jpg',
                    'Photo Hamon' => 'hamon.jpg',
                    'Photo Hamon 2' => 'hamon2.jpg',
                    'Illustration' => 'illustration.jpg',
                    'Photo Joconde masqué' => 'joconde-masque.jpg',
                    'Photo Keanu' => 'keanu.jpg',
                    'Photo Liberté guidant le peuple' => 'liberte-delacroix.jpg',
                    'Logo 1' => 'logo1.jpg',
                    'Logo 2' => 'logo2.jpg',
                    'Logo 3' => 'logo3.jpg',
                    'Logo 4' => 'logo4.jpg',
                    'Photo lycée' => 'lycee.jpg',
                    'Photo lycée aérienne' => 'lycee-air.jpg',
                    'Photo Mélenchon' => 'melenchon.jpg',
                    'Photo restez chez vous' => 'restez-chez-vous.jpg',
                    'Photo Social Distancing' => 'social-distancing.jpg',
                    'Photo Star wars' => 'star-wars.jpg',
                    'Photo Stonks' => 'stonks.jpg',
                    'Photo respectful meme' => 'think.jpg',
                    'Photo vacances été' => 'vacances-ete.jpg',
                    'Photo Vitruve' => 'vitruve.jpg',
                    'Photo Yvick' => 'yvick.jpg',
                    'Photo OSS 117' => 'oss117.jpg',
                    'Photo Comrade' => 'comrade.jpg',
                    'Photo ne lachez rien' => 'ne-lachez-rien.jpg',
                    'Photo Jul' => 'jul.jpg',
                    'Photo Oneal' => 'oneal.jpg'

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
