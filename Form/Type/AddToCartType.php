<?php

namespace GGGGino\SkuskuCartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddToCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idProduct', HiddenType::class)
            ->add('quantity', IntegerType::class,
                array(
                    'label' => 'quantity'
                ))
            ->add('add', SubmitType::class, array(
                'label' => 'add_to_cart'
            ));
    }
}