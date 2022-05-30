<?php

namespace App\Form;

use App\Entity\FichierActe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FichierActeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType:: class,[
                'label'=>false,
            ])
            ->add('path',FileType::class,[
                'label'=>false,
                'data_class' => null,
                'required'=> true,
                'mapped' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FichierActe::class,
        ]);
    }
}
