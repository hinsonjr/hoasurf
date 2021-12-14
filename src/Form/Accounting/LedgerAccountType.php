<?php

namespace App\Form\Accounting;

use App\Entity\Accounting\LedgerAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LedgerAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('balance')
            ->add('startBalance')
            ->add('type')
            ->add('hoa')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LedgerAccount::class,
        ]);
    }
}
