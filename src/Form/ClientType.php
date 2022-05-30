<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Departement;
use App\Entity\TypeClient;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA,function(FormEvent $event)
            {
                //$departement = $event->getData()['departement'] ?? null;
                $user = $event->getData();
            //dd($user->getSituation());
              /*  if ($user->getSituation() == "CELIBATAIRE"){
                    $event->getForm()->remove('emailConjoint');
                }*/
               /* $event->getForm()->add('departement',EntityType::class,[
                    'class'=>Departement::class,
                    'choice_label'=>'libDepartement',
                    'choices'=>$departement,
                    'disabled'=>false,
                    'placeholder'=>'Selectionnez un village',
                    'constraints'=>new NotBlank(['message'=>'Selectionnez un village']),
                ])   ;*/
            })

            ->add('type_client',EntityType::class, [
                'required' => true,
                'class' => TypeClient::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.active = :val')
                        ->setParameter('val', 1)
                        ->orderBy('u.titre', 'DESC');
                },
                'label' => 'type',
                'choice_label' => 'titre',

            ])
            ->add('boitePostal',TextType::class,[
                'required'=>false
            ])
            ->add('local',TextareaType::class,[
                'required'=>false
            ])
            ->add('raisonSocial',TextType::class,[
                'required'=>false
            ])
            ->add('registreCommercial',TextType::class,[
                'required'=>false
            ])

            ->add('siteWeb',UrlType::class,[
                'required'=>false
            ])
            ->add('nom',TextType::class,[
                'required'=>false
            ])

            ->add('photo', FileType::class, array(
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],

            ))
            ->add('emailConjoint',EmailType::class,[
                'required'=>false
            ])
            ->add('prenom',TextType::class,[
                'required'=>false
            ])
            ->add('dateNaissance', DateType::Class, [
                "label" => "Date de naissance",
                "required" => false,
                "widget" => 'single_text',
                "input_format" => 'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
            ])
            ->add('lieuNaissance',TextType::class,[
                'required'=>false
            ])
            ->add('profession',TextType::class,[
                'required'=>false
            ])
            ->add('domicile',TextType::class,[
                'required'=>false
            ])
            ->add('pere',TextType::class,[
                'required'=>false
            ])
            ->add('mere',TextType::class,[
                'required'=>false
            ])

            ->add('adresse',TextType::class,[
                'required'=>false
            ])
            ->add('telDomicile',TextType::class,[
                'required'=>false
            ])
            ->add('telBureau',TextType::class,[
                'required'=>false
            ])
            ->add('telPortable',TextType::class,[
                'required'=>false
            ])
            ->add('email',EmailType::class,[
            'required'=>false
            ])
            ->add('nationalite',TextType::class,[
                'required'=>false
            ])
            ->add('situation', ChoiceType::class,
                [
                    'expanded' => false,
                   /* 'placeholder' => 'Situation',*/
                    'required' => true,
                    // 'attr' => ['class' => 'select2_multiple'],
                    'multiple' => false,
                    //'choices_as_values' => true,

                    'choices' => array_flip([
                        'CELIBATAIRE' => 'CELIBATAIRE',
                        'EPOUX' => 'EPOUX (SE)',
                        'VEUF' => 'VEUF (VE)',
                        'DIVORCE' => 'DIVORCE (E)',

                    ]),
                ])

            ->add('etat', ChoiceType::class,
                [
                    'expanded' => false,
                    /* 'placeholder' => 'Situation',*/
                    'required' => true,
                    // 'attr' => ['class' => 'select2_multiple'],
                    'multiple' => false,
                    //'choices_as_values' => true,

                    'choices' => array_flip([
                        'DIVORCE' => 'EN CAS DE DIVORCE ',
                        'DECES' => 'EN CAS DE DECES DU CONJOINT',


                    ]),
                ])
            ->add('nomConjoint',TextType::class,[
                'required'=>false
            ])
            ->add('prenomConjoint')
            ->add('telConjoint')
            ->add('portableConjoint')
            ->add('dateNaissanceConjoint', DateType::Class, [
                "label" => "Date de naissance",
                "required" => false,
                "widget" => 'single_text',
                "input_format" => 'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
            ])
            ->add('lieuNaissanceConjoint')
            ->add('professionConjoint')
            ->add('pereConjoint')
            ->add('mereConjoint')
            ->add('adresseConjoint')
            ->add('nationaliteConjoint')
            ->add('regimeMatrimonialConjoint')
            ->add('dateMariage', DateType::Class, [
                "label" => "Date de naissance",
                "required" => false,
                "widget" => 'single_text',
                "input_format" => 'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
            ])
            ->add('lieuMariageConjoint')
            ->add('contratMariageConjoint', ChoiceType::class,
                [
                    'expanded' => false,
                    'placeholder' => 'Contrat de mariage',
                    'required' => false,
                    // 'attr' => ['class' => 'select2_multiple'],
                    'multiple' => false,
                    //'choices_as_values' => true,
                    'choices' => array_flip([
                        'OUI' => 'OUI',
                        'NON' => 'NON',


                    ]),
                ])
            ->add('affirmatif')
            ->add('precedentMariage', ChoiceType::class,
                [
                    'expanded' => false,
                    'placeholder' => 'Mariage précédent',
                    'required' => false,
                    // 'attr' => ['class' => 'select2_multiple'],
                    'multiple' => false,
                    //'choices_as_values' => true,

                    'choices' => array_flip([
                        'OUI' => 'OUI',
                        'NON' => 'NON',


                    ]),
                ])
            ->add('nomPrenomEpoux')
            ->add('datePrecedent', DateType::Class, [
                "label" => "Date de naissance",
                "required" => false,
                "widget" => 'single_text',
                "input_format" => 'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
            ])
            ->add('regime')
            ->add('numeroJugement')
            ->add('dateJugement', DateType::Class, [
                "label" => "Date de deces",
                "required" => false,
                "widget" => 'single_text',
                "input_format" => 'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
            ])
            ->add('jugementRendu')
            ->add('dateDeces', DateType::Class, [
                "label" => "Date de deces",
                "required" => false,
                "widget" => 'single_text',
                "input_format" => 'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
            ])
            ->add('lieuDeces');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
