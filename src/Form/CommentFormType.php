<?php

namespace App\Form;

use App\Entity\SnowComment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Contracts\Translation\TranslatorInterface;

class CommentFormType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('content', TextareaType::class, [
            'label' => $this->translator->trans('Your comment :'),
            'attr' => [
                'class' => 'form-control placeholder_message',
                'rows' => 6,
                'placeholder' => $this->translator->trans('Enter your comment'),
            ],
            'constraints' => [
                new Regex([
                    'pattern' => '/[^<->()]$/',
                    'message' => $this->translator->trans('Special character prohibited'),
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
