<?php

namespace App\Form\Accounting;

use App\Entity\Accounting\OwnerInvoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\Accounting\TransactionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class OwnerInvoiceSetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dueDate', DateType::class, ['widget' => 'single_text'])
            ->add('effectiveDate', DateType::class, ['widget' => 'single_text'])
            ->add('amount', null, ['mapped' => false, 'required'=>true])
            ->add('owner')
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
