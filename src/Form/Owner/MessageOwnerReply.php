<?php

namespace App\Form\Owner;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MessageOwnerReply extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject')
            ->add('body')
            ->add('expiration', DateType::class, 
                [
                    'widget' => 'single_text',
                    'attr' => [ 'readonly' => 'true']
                ]
            )
            ->add('type', TextType::class, 
                [
                    'attr' => ['readonly' => 'true']
                ]
            )
            ->add('category', TextType::class,
                [
                    'attr' => ['readonly' => 'true']
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
