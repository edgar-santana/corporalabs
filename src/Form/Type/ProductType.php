<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Product;

class ProductType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('name', TextType::class)
            ->add('price', NumberType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}