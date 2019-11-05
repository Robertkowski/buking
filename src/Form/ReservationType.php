<?php

namespace App\Form;

use App\Entity\Apartment;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class ReservationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('apartment', EntityType::class, [
                'class' => Apartment::class,
                'label' => 'Chose apartment',
                'placeholder' => 'Chose',
                'choice_label' => 'name',
            ])
            ->add('bookingFrom', DateType::class, [
                'label' => 'Check in',
                'widget' => 'single_text'
            ])
            ->add('bookingTo', DateType::class, [
                'label' => 'Check out',
                'widget' => 'single_text'
            ])
            ->add('takenSlots', NumberType::class, [
                'label' => 'Number of people',
                'attr' => [
                    'placeholder' => 'Set number of people to check in',
                    'min' => 1
                ],
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 1,
                        'message' => 'Minimum apartment slot is 1'
                    ])
                ]
            ])
            ->add('save', SubmitType::class, ['label' => 'Book']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }

}