<?php

namespace GGGGino\SkuskuCartBundle\Form\CartFlowType;

use Payum\Core\Bridge\Symfony\Form\Type\GatewayChoiceType;
use Payum\Core\Bridge\Symfony\Form\Type\GatewayFactoriesChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CartStep2FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('paymentMethod', GatewayChoiceType::class, array(
            'label' => 'payment_method'
        ));
    }

    public function getBlockPrefix()
    {
        return 'choosePayment';
    }
}