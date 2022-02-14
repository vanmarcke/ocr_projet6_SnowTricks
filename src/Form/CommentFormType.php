<?php

namespace App\Form;

use App\Entity\SnowComment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('content', TextareaType::class, [
            'label' => 'Votre commentaire : ',
            'attr' => [
                'class' => 'form-control placeholder_message',
                'rows' => 6,
                'placeholder' => 'Saisissez votre commentaire',
            ],
            'constraints' => [
                new Regex([
                    'pattern' => '/[^<->()]$/',
                    'message' => 'Caractère spécial interdit',
                ]),
            ],

        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SnowComment::class,
        ]);
    }
}
