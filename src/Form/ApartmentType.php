<?php

namespace App\Form;

use App\Form\Model\ApartmentModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class ApartmentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => ['placeholder' => 'Set apartment name'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9 ]+$/',
                        'message' => 'Apartment name can only contain letters and numbers'
                    ])
                ]
            ])
            ->add('slots', NumberType::class, [
                'label' => 'Slots',
                'attr' => [
                    'placeholder' => 'Set apartment slots',
                    'min' => 1
                ],
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 1,
                        'message' => 'Minimum apartment slot is 1'
                    ])
                ]
            ])
            ->add('discountOverSevenDays', NumberType::class, [
                'label' => 'DiscountOverSevenDays',
                'attr' => [
                    'placeholder' => 'Set discount over 7 days reservation',
                    'min' => 0,
                    'max' => 100
                ],
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'Minimum percentage discount is 0%'
                    ]),
                    new LessThanOrEqual([
                        'value' => 100,
                        'message' => 'Maximum percentage discount is 100%'
                    ]),
                    new NotNull()
                ]
            ])
            ->add('save', SubmitType::class, ['label' => 'Save apartment']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ApartmentModel::class,
        ]);
    }

}