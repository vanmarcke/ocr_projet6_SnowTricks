<?php

namespace App\Form;

use App\Entity\SnowUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProfileFormType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('newavatar', FileType::class, [
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '48k',
                    'maxSizeMessage' => $this->translator->trans('The file must not be larger than 2MB'),
                ]),
            ],
        ])
        ->add('newpseudo', TextType::class, [
            'mapped' => false,
            'required' => false,
        ])
        ->add('passwordold', PasswordType::class, [
            'mapped' => false,
            'required' => true,
        ])
        ->add('newpassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_name' => 'pass',
            'second_name' => 'confirm',
            'first_options' => [
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => $this->translator->trans('Your password must be at least {{ limit }} characters long.'),
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ],
            'second_options' => [
            ],
            'invalid_message' => $this->translator->trans('Password fields must match.'),
            'mapped' => false,
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SnowUser::class,
        ]);
    }
}
