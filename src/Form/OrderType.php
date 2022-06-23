<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('Addresses', EntityType::class, [
                'label' => 'Choissisez votre addresse de livraison : ',
                'required' => true,
                'class' => Address::class,
                'choices' => $user->getAddresses(),
                'multiple' => false,
                'expanded' => true

            ])
            ->add('Carriers', EntityType::class, [
                'label' => 'Choissisez votre Transporteur :' ,
                'required' => true,
                'class' => Carrier::class,
                'multiple' => false,
                'expanded' => true

            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Valider Ma Commande',
                'attr'=>[
                    'class'=> 'btn btn-success btn-block '
                ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => array()
        ]);
    }
}
