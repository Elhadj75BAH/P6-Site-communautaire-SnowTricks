<?php

namespace App\Form;

use App\Entity\Figure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FigureType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('description', TextareaType::class)
            ->add('groupe');

        $builder->add('imagefig', CollectionType::class, [
            'label' => 'Image',
            'entry_type' => ImageFigureType::class,
            'entry_options' => ['label' => false,'attr' => ['required' => true]],
            'allow_add' => true,
            'allow_delete' => true,
          //  'by_reference'=>false
        ]);
        $builder->add('videofig', CollectionType::class, [
            'label' => 'Video',
            'entry_type' => VideoFigureType::class,
            'entry_options' => ['label' => false, 'attr' => ['required' => false]],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false

        ]);
    }
}
