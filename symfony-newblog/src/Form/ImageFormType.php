<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Pais;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ImageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ciudad', FileType::class,[
                'mapped'=> false,
                'constraints'=>[
                    new File([
                        'mimeTypes' => [
                            'image/jpeg', 'image/png',
                        ],
                        'mimeTypesMessage'=>'Please upload a valid image file',
                    ])
                ]
            ] )
            ->add('nombre', null, ['attr' => ['class'=>'form-control']])
            ->add('likes', null, ['attr' => ['class'=>'form-control']])
            ->add('views', null, ['attr' => ['class'=>'form-control']])
            ->add('downloads', null, ['attr' => ['class'=>'form-control']])
            ->add('pais', EntityType::class, array(
                'class' => Pais::class,
                'choice_label'=>'name'))
            ->add('Send', SubmitType::class, ['attr' => ['class'=>'pull-right btn btn-lg sr-button']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
