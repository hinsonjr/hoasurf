<?php

namespace App\Form;

use App\Entity\Owner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class OwnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		
		$yearRange = range(1950,date("Y")+2);
        $builder
            ->add('name')
            ->add('unit')
            ->add('startDate', DateType::class, ['years' => $yearRange])
            ->add('endDate')
            ->add('address')
            ->add('address2')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('country')
            ->add('phone')
            ->add('user')
			->add('ownPercent')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Owner::class,
        ]);
    }
}
