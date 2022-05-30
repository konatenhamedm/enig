<?php

namespace App\Form;

use App\Entity\ActeConstitution;
use App\Entity\FichierConstitution;
use App\Entity\TypeSociete;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FichierConstitutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class,[
                "label" => false,
            ])
            ->add('etat',CheckboxType::class,[
                "label" => false,
                'required' => false,
            ])
            ->add('dateObtention', DateType::Class, [
              "label" => false,
                "required" => false,
                "widget" => 'single_text',
                "input_format" => 'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
            ])
            ->add('path',FileType::class,[
                'label'=>false,
                'data_class'=>null,
                'required'=> false,
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
          /*  ->add('acte',EntityType::class, [
                'required' => false,
                'class' => ActeConstitution::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.active = :val')
                        ->setParameter('val', 1)
                        ->orderBy('u.id', 'DESC');
                },
                'label' => 'Form',
                'placeholder' => "Selectionner la forme",
                'choice_label' => function ($type) {

                    return $type->getSigle();
                },
                'attr'=>['class' =>'form-control select2','id'=>'validationCustom05']

            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FichierConstitution::class,
        ]);
    }
}
