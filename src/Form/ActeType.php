<?php

namespace App\Form;

use App\Entity\Acte;
use App\Entity\Client;
use App\Entity\Type;
use \App\Form\FichierActeType;
use Doctrine\ORM\EntityRepository;
use Mpdf\Tag\TextArea;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::Class, [
                /*  "label" => "Date de réception",*/
                "required" => false,
                "widget" => 'single_text',
                "input_format" => 'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
            ])
            ->add('objet',TextType::class)
            ->add('numero',TextType::class)
            ->add('fichiers', CollectionType::class, [
                'entry_type' => FichierActeType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'label' => false,
                'by_reference' => false,
                'allow_delete' => true,
                'prototype' => true,

            ])
            ->add('montant',MoneyType::class)
            ->add('detail',TextareaType::class,[
                'attr' => ['rows' => '4']
            ])
            ->add('vendeur', EntityType::class, [
                'required' => false,
                'class' => Client::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.active = :val')
                        ->setParameter('val', 1)
                        ->orderBy('u.id', 'DESC');
                },

                'placeholder' => 'Selectionner le vendeur',
                'choice_label' => function ($client) {
                    if ($client->getRaisonSocial() == "") {
                        return $client->getNom() . ' ' . $client->getPrenom();
                    } else {

                        return $client->getRaisonSocial();
                    }
                },
                'attr'=>['class' =>'form-control select2','id'=>'validationCustom04']


            ])
            ->add('acheteur',EntityType::class, [
                'required' => false,
                'class' => Client::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.active = :val')
                        ->setParameter('val', 1)
                        ->orderBy('u.id', 'DESC');
                },
                'label' => 'Acheteur',
                'placeholder' => "Selectionner l'acheteur",
                'choice_label' => function ($client) {
                    if ($client->getRaisonSocial() == "") {
                        return $client->getNom() . ' ' . $client->getPrenom();
                    } else {

                        return $client->getRaisonSocial();
                    }
                },
                'attr'=>['class' =>'form-control select2','id'=>'validationCustom05']

            ])
       /*     ->add('typeActe',EntityType::class, [
                'class' => Type::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.active = :val')
                        ->setParameter('val', 1)
                        ->orderBy('u.id', 'ASC');
                },
                'choice_label' => 'titre',
                'label' => false,
                'placeholder' => "Selectionner le type de l'acte",
                'attr'=>['class' =>'form-control  select2','id'=>'validationCustom05']

            ])*/
            ->add('etatBien',TextType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Acte::class,
        ]);
    }
}
