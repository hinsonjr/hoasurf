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
            ->add('postDate', DateType::class, ['widget' => 'single_text'])
            ->add('paidDate', DateType::class, ['widget' => 'single_text', 'required' => false])
			->add('amount', null, ['mapped' => false, 'required'=>true])
            ->add('unitOwner')
            ->add('type')
            ->add('hoa', null, ['label'=>"HOA relevant"])
	
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OwnerInvoice::class,
        ]);
    }
}
