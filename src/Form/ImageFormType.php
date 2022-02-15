<?php

namespace App\Form;

use App\Entity\SnowImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image as ConstraintsImage;

class ImageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('file', FileType::class, [
            'label' => false,
            'attr' => ['placeholder' => 'Déposer votre image'],
            'required' => false,
            'constraints' => [
                new ConstraintsImage(),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SnowImage::class,
        ]);
    }
}
