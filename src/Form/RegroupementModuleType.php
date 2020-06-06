<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Promotion;
use App\Entity\UniteEnseignement;
use App\Entity\RegroupementModule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RegroupementModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('promotion',EntityType::class,
            [
                'placeholder'=> 'Choississez une Promotion',
                'class' => Promotion::class,
                'choice_label' => 'title'
            ])

            ->add('uniteEnseignement',EntityType::class,
            [
                'placeholder'=> 'Choississez une Unite Enseignement',
                'class' => UniteEnseignement::class,
                'choice_label' => 'title'
            ])
            ->add('modules', EntityType::class, [
                'label' => "Choissisez les modules",
                'class' => Module::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RegroupementModule::class,
        ]);
    }
}
