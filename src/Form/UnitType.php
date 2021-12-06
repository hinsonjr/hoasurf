<?php

namespace App\Form;

use App\Entity\Unit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('unitNumber')
            ->add('currentOwner')
            ->add('sf')
            ->add('beds')
            ->add('baths')
            ->add('building')
            ->add('owners')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Unit::class,
        ]);
    }
}
