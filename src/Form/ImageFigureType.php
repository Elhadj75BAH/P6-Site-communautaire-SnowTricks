<?php

namespace App\Form;

use App\Entity\ImageFigure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageFigureType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImageFigure::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'imageFile',
                FileType::class,
                [
                'label' => false,
                'required' => false,
                // 'attr'=>['class'=>'form-control'],

                /*  'constraints'=>[
                    new File([
                        'maxSize'=>'8M',
                    ])
                ],*/

                ]
            )
            ;
    }
}
