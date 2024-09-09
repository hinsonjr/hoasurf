<?php

namespace App\Form;

use App\Entity\Request;

use App\Form\RequestNoteType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class Request1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject')
            ->add('type')
            ->add('createdBy')
            ->add('assignedTo')
            ->add('completedBy')
            ->add('status')
            ->add('hoa')
            ->add('building', null, ['label'=>"Attach to Building (optional)"])
            ->add('unit', null, ['label'=>"Attach to Unit (optional)"])
            ->add('vendor', null, ['label'=>"Attach to Vendor (optional)"])
			->add('note', TextType::class, ['mapped' => false, 'required'=>false,'label' => "Add new Note"])
//			->add('notes', CollectionType::class, [
//				'entry_type' => RequestNoteType::class,
//				'entry_options' => ['label' => false],
//        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Request::class,
        ]);
    }
}
