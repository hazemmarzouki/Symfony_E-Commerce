<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangepasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('old_password' , PasswordType::class , [
                'label'=>'Mon Mot De Passe Actuel ',
                'mapped'=> false,
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre mot passe actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped'=> false,
                'invalid_message' => 'Le mot de passe et confirmation doivent être identiques ',
                'label' => 'Mon Nouveau Mot De Passe :',
                'required' => true,
                'first_options' => ['label' => 'Mon Nouveau Mot De Passe'],
                'second_options' => ['label' => 'Confirmez votre nouveau mot de passe'],
            ])
            
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label'=> 'Mon Adresse Email'
            ])

            ->add('Firstname', TextType::class, [
                'disabled' => true,
                'label'=> 'Mon Prénom'
            ])
            ->add('Lastname', TextType::class, [
                'disabled' => true,
                'label'=> 'Mon Nom'
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
