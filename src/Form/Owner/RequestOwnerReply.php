<?php

namespace App\Form\Owner;

use App\Entity\Request;
use App\Entity\RequestType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RequestOwnerReply extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, 
                [
                    'attr' => ['readonly' => 'true']
                ]
            )
            ->add('status')
            ->add('type')
            ->add('createdDate', DateType::class, 
                [
                    'widget' => 'single_text',
                    'attr' => [ 'readonly' => 'true']
                ]
            )
            ->add('completedDate', DateType::class, 
                [
                    'widget' => 'single_text',
                    'attr' => [ 'readonly' => 'true']
                ]
            )
            ->add('note',  TextareaType::Class, array(
                "label" => "Note",
                'mapped' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => \App\Entity\Request::class,
            'cascade_validation' => true,
        ]);
    }
}
