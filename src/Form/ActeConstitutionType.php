<?php

namespace App\Form;

use App\Entity\ActeConstitution;
use App\Entity\Client;
use App\Entity\TypeSociete;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActeConstitutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet', ChoiceType::class,
                [
                    'expanded' => false,
                    'placeholder' => "Selectionner l'bjet",
                    'required' => false,
                    // 'attr' => ['class' => 'select2_multiple'],
                    'multiple' => false,
                    //'choices_as_values' => true,

                    'choices' => array_flip([
                        'OBJET1' => 'OBJET1',
                        'OBJET2' => 'OBJET2',



                    ])
                ])
            ->add('form',EntityType::class, [
                'required' => false,
                'class' => TypeSociete::class,
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

            ])
            ->add('client',EntityType::class, [
                'required' => false,
                'class' => Client::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.active = :val')
                        ->setParameter('val', 1)
                        ->orderBy('u.id', 'DESC');
                },
                'label' => 'Client',
                'placeholder' => "Selectionner le client",
                'choice_label' => function ($client) {
                    if ($client->getRaisonSocial() == "") {
                        return $client->getNom() . ' ' . $client->getPrenom();
                    } else {

                        return $client->getRaisonSocial();
                    }
                },
                'attr'=>['class' =>'form-control select2','id'=>'validationCustom05']

            ])
            ->add('capital')
            ->add('fichierConstitutions', CollectionType::class, [
                'entry_type' => FichierConstitutionType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'label' => false,
                'by_reference' => false,
                'allow_delete' => true,
                'prototype' => true,

            ])
            ->add('sigle')
            ->add('etat',CheckboxType::class,[
                'label'=>false,
                'required'=>false,
            ])
            ->add('devise', ChoiceType::class,
                [
                    'expanded' => false,
                    'placeholder' => 'Selectionner la devise',
                    'required' => false,
                    // 'attr' => ['class' => 'select2_multiple'],
                    'multiple' => false,
                    //'choices_as_values' => true,

                    'choices' => array_flip([
                        'CHACUN' => 'FRANC CHACUN',
                        'ACTION' => 'PAR ACTION',



                    ])
                ])
            ->add('natureAction', ChoiceType::class,
                [
                    'expanded' => false,
                    'placeholder' => 'Selectionner la nature action',
                    'required' => false,
                    // 'attr' => ['class' => 'select2_multiple'],
                    'multiple' => false,
                    //'choices_as_values' => true,

                    'choices' => array_flip([
                        'NOMINATIVE' => 'NOMINATIVE',
                        'POREUR' => 'AU PORTEUR',



                    ])
                ])
            ->add('liberationSouscription', ChoiceType::class,
                [
                    'expanded' => false,
                    'placeholder' => 'Selectionner liberalisation de souscription',
                    'required' => false,
                    // 'attr' => ['class' => 'select2_multiple'],
                    'multiple' => false,
                    //'choices_as_values' => true,

                    'choices' => array_flip([
                        'QUART' => '1/4',
                        'DEMI' => '1/2',
                        'INTEGRALITE' => 'INTEGRALITE',



                    ])
                ])
            ->add('nomGerant')
            ->add('siege')
            ->add('duree')
            ->add('denomination')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ActeConstitution::class,
        ]);
    }
}
