<?php

namespace App\Form;

use App\Entity\User;
use PHPUnit\Framework\Constraint\IsFalse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

//**********************************************************  PRENOM ***************************************************
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre nom',
                ],
                'constraints' => [ new length ([
                    'min' => 2,
                    'max' => 30
                    ]),
                    new NotBlank ([
                        'message' => 'Merci de rentrer votre nom',
                    ])
                ]
            ])

//******************************************************  PRENOM *******************************************************

            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre prénom',
                ],
                'constraints' => [ new length ([
                    'min' => 2,
                    'max' => 30
                ]),
                    new NotBlank ([
                        'message' => 'Merci de rentrer votre prénom',
                    ])
                ]
            ])
//*****************************************************  TELEPHONE *****************************************************

            ->add('telephone', TelType::class, [
                'label' => 'Votre téléphone',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre téléphone',
                ],
                'constraints' => [

                    new Regex([
                        'pattern' => '/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/',
                        'message' => "Le numéro de téléphone n\'est pas valide.",
                    ]),

                    new Length([
                        'min' => 10,
                        'max' => 14,
//                        'message' => "Le numéro de téléphone doit contenir au moins 10 chiffres"
                    ]),

                    new NotBlank([
                        'message' => "Merci de saisir votre telephone",
                    ]),
                ]
            ])
//*****************************************************  EMAIL *********************************************************

            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre mot de passe',
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [

                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),

                    new NotBlank([
                        'message' => 'Veuillez saisir votre email'
                    ]),
                ]
            ])

//***************************************************  MOT DE PASSE ****************************************************

            ->add('Password', RepeatedType::class, options: [
//                'contraints' => [
//
//                    new Regex([
//                        'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
//
////                        'meessage' => 'Votre mot de passe doit contenir au moins une majuscule
////                        , une minuscule, un chiffre, un caractère spécial et un mimimum de 12 caractères.',
//                    ]),//
//
//                ],
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ]);

//            ->add('Password', PasswordType::class, [
//                'label' => 'Mot de passe',
//                'attr' => [
//                    'placeholder' => 'Merci de saisir votre mot de passe',
//                    'autocomplete' => 'new-password'
//                ],
//                'constraints' => [
//                    new Length([
//                        'min' => 6,
////                        'Message' => 'Your password should be at least {{ limit }} characters',
//                        // Longueur maximale autorisée par Symfony pour des raisons de sécurité.
//                        'max' => 4096,
//                    ]),
//                    new NotBlank([
//                        'message' => 'Veuillez saisir votre mot de passe',
//                    ]),
//                ]
//            ])



//************************************** CONFIRMATION DE MOT DE PASSE ***************************************************
//            ->add('plainPassword', RepeatedType::class, [
//                'mapped' => false,
//                'label' => 'Confirmer mot de passe',
//                'attr' => [
//                    'placeholder' => ' Merci de confirmer votre mot de passe',
//                ],
//
//            ])
//            ->add('plainPassword', PasswordType::class, [
//                // instead of being set onto the object directly,
//                // this is read and encoded in the controller
//                'mapped' => false,
//                'attr' => ['autocomplete' => 'new-password'],
//                'constraints' => [
//                    new NotBlank([
//                        'message' => 'Please enter a password',
//                    ]),
//                    new Length([
//                        'min' => 6,
//                        'minMessage' => 'Your password should be at least {{ limit }} characters',
//                        // max length allowed by Symfony for security reasons
//                        'max' => 4096,
//                    ]),
//                ],
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
