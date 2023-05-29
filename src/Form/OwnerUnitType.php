<?php

namespace App\Form;

use App\Entity\OwnerUnit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OwnerUnitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate')
            ->add('endDate')
            ->add('ownPercent')
            ->add('owner')
            ->add('unit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UnitOwner::class,
        ]);
    }
}
