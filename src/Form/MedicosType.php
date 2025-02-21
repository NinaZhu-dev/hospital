<?php

namespace App\Form;

use App\Entity\Especialidades;
use App\Entity\Medicos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class MedicosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('apellido', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('especialidad', EntityType::class, [
                'class' => Especialidades::class,
                'placeholder' => 'Seleccione una especialidad',
                'attr' => ['class' => 'form-select'],
                'choice_label' => 'nombre',
                'multiple' => true,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medicos::class,
        ]);
    }
}
