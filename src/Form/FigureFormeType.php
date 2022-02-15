<?php

namespace App\Form;

use App\Entity\SnowCategory;
use App\Entity\SnowFigure;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class FigureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                        new Regex([
                            'pattern' => '/[a-zA-z]{3,}[a-zA-Z-0-9\-]*/',
                            'message' => 'Le titre doit contenir au moins 3 lettres'
                        ])]
                ])  
            ->add('description')
            ->add('publish')
            ->add('snowCategory', EntityType::class, [
                'class' => SnowCategory::class,
                'choice_label' => function ($category) {
                    return $category->getName();
                }
              ])
            ->add('images', CollectionType::class, [
                'entry_type'    => ImageFormType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
            ])  
            ->add('videos', CollectionType::class, [
                'entry_type'    => VideoFormType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
            ])  
            ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SnowFigure::class,
        ]);
    }
}
