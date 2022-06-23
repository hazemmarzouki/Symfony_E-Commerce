<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' =>  'Quel Nom souhaitez-vous donner a votre address ?',
                'attr' => [
                    'placeholder' => 'Nommez votre addresse '
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' =>  'Votre Nom : '
            ])
            ->add('lastname', TextType::class, [
                'label' =>  'Votre Prenom :'
            ])
            ->add('company', TextType::class, [
                'label' =>  'Votre Societe : (facultatif)',
                'required'=>false
                
            ])
            ->add('address', TextType::class, [
                'label' =>  'Votre Addresse :'
            ])
            ->add('code_postal', TextType::class, [
                'label' =>  'Code Postale :'
            ])
            ->add('city', TextType::class, [
                'label' =>  'Ville:'
            ])
            ->add('country', CountryType::class, [
                'label' =>  'Pays :'
            ])
            ->add('phone', TelType::class, [
                'label' =>  'Telephone :  '
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider addresse',
                'attr' => [
                    'class' => 'btn-block btn-primary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
