<?php

namespace App\Form;

use App\Entity\ImageFigure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageFigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image',FileType::Class,
                [
                'label'=>'Image figure',
                'attr'=>['class'=>'form-control']
            ])

            ->add('figureimage'
       );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImageFigure::class,
        ]);
    }
}
