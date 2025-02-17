<?php

namespace App\Form;

use App\Entity\Citas;
use App\Entity\Especialidades;

use App\Validator\Telefono;
use App\Validator\DniNie;
use App\Validator\Email;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CitasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre',  TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('dni', TextType::class, ['attr' => ['class' => 'form-control'], 'constraints' => [new DniNie()]])
            ->add('direccion', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('telefono', TextType::class, ['attr' => ['class' => 'form-control'], 'constraints' => [new Telefono()]])
            ->add('email', TextType::class, ['attr' => ['class' => 'form-control'], 'constraints' => [new Email()]])
            ->add('observaciones', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('especialidad', EntityType::class, [
                'class' => Especialidades::class,
                'placeholder' => 'Seleccione una especialidad',
                'attr' => ['class' => 'form-select'],
                'choice_label' => 'nombre',
            ])
        ;

        //si la cita es editada añadir el atributo gestionada y la fecha de la cita
        if ($options['is_edit']) {
            
            $builder
                ->add('gestionada', CheckboxType::class, [
                    'required' => false,
                    'label' => '¿Cita gestionada?',
                    'attr' => ['class' => 'form-check-input']
                ])
                ->add('fechaCita', DateType::class, [
                    'widget' => 'single_text',
                    'attr' => ['class' => 'form-control']
                ]);
        }


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Citas::class,
            'is_edit' => false
        ]);
    }
}
