<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Module;
use App\Entity\Enseignant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('enseignant',EntityType::class,[
                'required' => false,
                'placeholder' =>'Choississez un Enseignant',
                'class' => Enseignant::class,
                'choice_label' => function ($user) { 
                    return $user->getUser()->getName()." ".$user->getUser()->getLastName(); 
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
