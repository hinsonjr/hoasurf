<?php

namespace App\Form\Owner;

use App\Entity\Request;
use App\Entity\RequestType;
use App\Form\RequestNoteType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
            ->add('status', TextType::class, 
                [
                    'attr' => [ 'readonly' => 'true']
                    ]
            )
            ->add('markComplete', ButtonType::class, [
                'attr' => ['id' => 'markComplete', 'class' => 'markComplete btn btn-primary']
            ])
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
            ->add('notes', CollectionType::class, array(
                'entry_type' => RequestNoteType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true
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
