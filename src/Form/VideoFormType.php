<?php

namespace App\Form;

use App\Entity\SnowVideo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Contracts\Translation\TranslatorInterface;

class VideoFormType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('url', TypeTextType::class, [
            'label' => false,
            'attr' => ['placeholder' => $this->translator->trans('Enter an embed link. eg: https://www.youtube.com/embed/........')],
            'constraints' => [
                new Regex([
                    'pattern' => '/embed/',
                    'match' => 'false',
                    'message' => $this->translator->trans('The link must contain "embed" . eg: https://www.youtube.com/embed/CA5bURVJ5zk'),
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SnowVideo::class,
        ]);
    }
}
