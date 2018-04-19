<?php

namespace App\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Garlic\User\Form\Type\ProfileFormType as BaseType;

/**
 * Class ProfileFormType
 */
class ProfileFormType extends BaseType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'website',
                TextType::class
            )
            ->add(
                'firstName',
                TextType::class
            )
            ->add(
                'lastName',
                TextType::class
            )
            ->add(
                'phone',
                TextType::class
            )
            ->add(
                'country',
                TextType::class
            );
    }
}
