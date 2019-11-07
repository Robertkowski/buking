<?php

namespace App\Form;

use App\Entity\Apartment;
use App\Form\Model\ReservationModel;
use DateTime;
use Exception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotEqualTo;
use Symfony\Component\Validator\Constraints\NotNull;

class ReservationType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws Exception
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('apartment', EntityType::class, [
            'class' => Apartment::class,
            'label' => 'Chose apartment',
            'placeholder' => 'Chose',
            'choice_label' => 'name',
            'constraints' => [
                new NotNull()
            ]
        ])
            ->add('bookingFrom', DateType::class, [
                'label' => 'Check in',
                'widget' => 'single_text',
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => new DateTime('now'),
                        'message' => 'You are trying to book an apartment with a past date. Please select a different check in date.'
                    ]),
                    new NotNull()
                ]
            ])
            ->add('bookingTo', DateType::class, [
                'label' => 'Check out',
                'widget' => 'single_text',
                'constraints' => [
                    new NotEqualTo([
                        'propertyPath' => 'parent.all[bookingFrom].data',
                        'message' => 'Minimum reservation time is 1 day'
                    ]),
                    new GreaterThanOrEqual([
                        'propertyPath' => 'parent.all[bookingFrom].data',
                        'message' => 'Check out date should be later than check in date. Please select a different check out date.'
                    ]),
                    new NotNull()
                ]
            ])
            ->add('takenSlots', NumberType::class, [
                'label' => 'Number of people',
                'attr' => [
                    'placeholder' => 'Number of people to check in',
                    'min' => 1
                ],
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 1,
                        'message' => 'Minimum apartment slot is 1'
                    ]),
                    new NotNull()
                ]
            ])
            ->add('save', SubmitType::class, ['label' => 'Book']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReservationModel::class,
        ]);
    }

}