<?php

namespace App\Form;

use App\Entity\Citas;
use App\Entity\Especialidades;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CitasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre',  TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('dni', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('direccion', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('telefono', IntegerType::class, ['attr' => ['class' => 'form-control']])
            ->add('email', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('observaciones', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('especialidad', EntityType::class, [
                'class' => Especialidades::class,
                'placeholder' => 'Seleccione una especialidad',
                'attr' => ['class' => 'form-select'],
                'choice_label' => 'nombre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Citas::class,
        ]);
    }
}
