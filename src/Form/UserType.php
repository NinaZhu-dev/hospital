<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, ['attr' => ['class' => 'form-control'],'constraints' => [new Email()]])
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Administración' => 'ROLE_ADMINISTRACION',
                    'Usuario' => 'ROLE_USER',
                    'Medico' => 'ROLE_MEDICO'
                    
                ],
                'multiple' => true,
                'attr' => ['class' => 'form-select']
            ])
            ->add('password', PasswordType::class, ['attr' => ['class' => 'form-control']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
