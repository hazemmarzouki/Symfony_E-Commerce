<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', TextType::class,['label'=>'rechercher',
            'required'=>false,
            'attr'=>[
                'placeholder'=>'Votre recherche ..',
                'class'=>'form-control-sm'
            ]
            ])
            ->add('categories',EntityType::class,[
                'label'=>false,
                'required'=>false,
                'class'=>Category::class,
                'multiple'=>true,
                'expanded'=>true

            ])
            ->add('sumbit',SubmitType::class,[
                'label'=>'filter',
                'attr'=>[
                    'class'=>'btn-block btn-primary'
                    
                ]
            ]);

                

                }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_production' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
    
}