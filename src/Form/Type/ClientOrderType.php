<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Client;
use App\Entity\Product;
use App\Entity\ClientOrder;
use App\Entity\OrdersProducts;

class ClientOrderType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('client', EntityType::class, [
                'placeholder' => 'Choose a client',
                'class' => Client::class,            
                'choice_label' => function(Client $client) {
                    return $client->getName();
                }
            ])
            ->add('product', EntityType::class, [
                'mapped' => false,
                'placeholder' => 'Choose a product',
                'class' => Product::class,
                'attr' => [
                    'class' => 'cost-component',
                ],
                'choice_label' => function(Product $product) {
                    return $product->getName();
                },
                'choice_attr' => function(Product $product) {
                    return ['data-price' => $product->getPrice()];
                },
            ])
            ->add('amount', NumberType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'cost-component',
                ],
            ])
            ->add('cost', NumberType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'cost-result',
                    'readonly'=> true,
                ],
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults([
            'data_class' => ClientOrder::class,
            'attr'  => [],
        ]);
    }
}