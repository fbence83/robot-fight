<?php

namespace App\Form;

use App\Entity\Robot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RobotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Brawler' => 'brawler',
                    'Rogue' => 'rogue',
                    'Assault' => 'assault',
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('power', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'number',
                    'min' => 0,
                    'step' => 1
                ],
                'required' => true,
            ])
        ;

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Robot::class,
            'edit_mode' => false,
        ]);
    }
}
