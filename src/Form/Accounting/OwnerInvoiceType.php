<?php

namespace App\Form\Accounting;

use App\Entity\Accounting\OwnerInvoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\Accounting\TransactionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class OwnerInvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dueDate', DateType::class, ['widget' => 'single_text'])
            ->add('effectiveDate', DateType::class, ['widget' => 'single_text'])
            ->add('paidDate', DateType::class, ['widget' => 'single_text', 'required' => false])
            ->add('transaction', TransactionType::class)
            ->add('owner')
            ->add('hoa')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OwnerInvoice::class,
        ]);
    }
}
