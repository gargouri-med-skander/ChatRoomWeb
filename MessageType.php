<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\User;

use phpDocumentor\Reflection\Types\String_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Validator\Constraints\Date;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idUsersender',HiddenType::class, [
                'empty_data' => 1,
            ])
            ->add('iduserrecever',EntityType::class,[
                'class' => User::class,
                'choice_label' => 'nom',

            ])
            ->add('dateEnvoi',HiddenType::class,[
                'empty_data' => '11/19/2021',
            ])
            ->add('contenumessage',TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
