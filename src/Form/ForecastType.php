<?php

namespace App\Form;

use App\Entity\Forecast;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ForecastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('temperature', NumberType::class, [
                'attr' => [
                    'min' => -60,
                    'max' => 60
                ]
            ])
            ->add('humidity', NumberType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 100
                ]
            ])
            ->add('weathercondition')
            ->add('windspeed', NumberType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 410
                ]
            ])
            ->add('date', DateType::class)
            ->add('city', EntityType::class, [
                'class' => 'App\Entity\City',
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forecast::class,
        ]);
    }
}
