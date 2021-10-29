<?php

namespace App\Form;

use App\Entity\Figure;
use App\Entity\ImageFigure;
use App\Entity\VideoFigure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class)
            ->add('description',TextareaType::class)
            ->add('groupe');

        $builder->add('imagefig',CollectionType::class,[
            'label'=>'Image',
            'entry_type'=> ImageFigureType::class,
            'entry_options'=>['label'=>false],
            'allow_add' => true,
        ]);
        $builder->add('videofig',CollectionType::class,[
            'label'=>'Video',
            'entry_type'=>VideoFigureType::class,
            'entry_options'=>['label'=>false],
            'allow_add' => true,


        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
