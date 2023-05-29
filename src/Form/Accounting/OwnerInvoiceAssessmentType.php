<?php

namespace App\Form\Accounting;

use App\Entity\Accounting\OwnerInvoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\Accounting\TransactionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class OwnerInvoiceAssessmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dueDate', DateType::class, ['widget' => 'single_text'])
            ->add('postDate', DateType::class, ['widget' => 'single_text'])
            ->add('amount')
            ->add('hoa')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OwnerInvoice::class,
			'validation_groups' => false,
			'novalidate' => 'novalidate'
        ]);
    }
}
