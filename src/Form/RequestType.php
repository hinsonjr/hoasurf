<?php

namespace App\Form;

use App\Entity\Request;
use App\Entity\RequestNote;
use App\Form\RequestNoteType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('assignedTo')
            ->add('subject')
            ->add('hoa')
			->add('note', RequestNoteType::class, ['mapped' => false, 'required'=>true, 'label'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Request::class,
        ]);
    }
}
