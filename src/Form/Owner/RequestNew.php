<?php

namespace App\Form\Owner;

use App\Entity\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RequestNew extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject')
            ->add('status')
            ->add('type')
            ->add('createdBy')
            ->add('status')
            ->add('hoa', TextType::class, 
                [
                    'attr' => [ 'readonly' => 'true']
                ]
            )
            ->add('unit', TextType::class, 
                [
                    'attr' => [ 'readonly' => 'true']
                ]
            )
            ->add('building', TextType::class, 
                [
                    'attr' => [ 'readonly' => 'true']
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => \App\Entity\Request::class,
        ]);
    }
}
