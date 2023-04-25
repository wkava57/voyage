<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Category;
use App\Entity\User;
use mysql_xdevapi\BaseResult;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('string', TelType::class,[
//                'label' => false,
//                'required' => false,
//                'attr' => [
//                    'placeholder' => 'Votre recherche...'
//                ]
//            ])
            ->add('categories', EntityType::class,[
                'label' => 'Sélectionnez des catégories',
                'required' => true,
                'class' => Category::class,
                'multiple'=> true,
                'expanded' =>   true
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Filtre',
                'attr' => [
                    'class' => 'btn-block btn-info'
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
//            désactiver crsf de symfony,
            'crsf_protection' => false,
        ]);

    }

    public function getBlockPrefix()
    {
    return '';
    }

}