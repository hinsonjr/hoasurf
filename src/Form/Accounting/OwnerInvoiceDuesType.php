<?php

namespace App\Form\Accounting;

use App\Entity\Accounting\OwnerInvoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class OwnerInvoiceDuesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startMonth', DateType::class, 
				['mapped' => false,   'widget' => 'single_text'
					]
				
				)
            ->add('dueDate', IntegerType::class, ['mapped' => false, 'required'=>true, 'label'=>"Day of Month Due", 'data' => 1])
            ->add('postDate', IntegerType::class, ['mapped' => false, 'required'=>true, 'label'=>"Days Prior to Due Date to Post/Notify", 'data' => 15])
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
