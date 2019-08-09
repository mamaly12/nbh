<?php

namespace App\Form;

use App\Entity\Clients;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\IsTrue;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,
                [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a name',
                        ]),
                        new Length([
                            'max' => 255,
                            'maxMessage' => 'Your name should be no more than {{ limit }} characters',
                        ]),
                    ],
                ])

            ->add('surname',TextType::class,
                [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a surname',
                        ]),
                        new Length([
                            'max' => 255,
                            'maxMessage' => 'Your surname should be no more than {{ limit }} characters',
                        ]),
                    ],
                ])

            ->add('dateOfBirth',DateType::class,
                array(
                    'widget' => 'choice',
                    'years' => range(date('Y')-100, date('Y')-7),
                    'months' => range(date('m'), 12),
                    'days' => range(date('d'), 31),
                ))

            ->add('email',EmailType::class,
                [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter an email',
                        ])],
                ])

            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 255,
                    ]),
                ],
            ])

            ->add('phoneNumber',TextType::class,
                [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a phone number',
                        ]),
                        new Length([
                            'max' => 255,
                            'maxMessage' => 'Your phone no should be no more than {{ limit }} characters',
                        ]),
                    ],
                ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clients::class,
        ]);
    }
}
