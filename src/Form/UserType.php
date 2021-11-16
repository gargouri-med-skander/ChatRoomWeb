<?php

namespace App\Form;

use App\Entity\User;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
           ->add('dateNaissance',\Symfony\Component\Form\Extension\Core\Type\DateType::class)
            ->add('gmail')
            ->add('password',PasswordType::class)
            ->add('gender',ChoiceType::class,[
            'choices'=>['male'=>'male','female'=>'female'],
                'expanded'=>true

                ])
            ->add('role',ChoiceType::class,[
                'choices'=>['membre'=>'membre','admin'=>'admin'],
                'expanded'=>true

            ])


            ->add("signup",SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
