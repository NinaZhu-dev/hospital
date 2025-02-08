<?php

namespace App\Form;

use App\Entity\BolsaEmpleo;
use App\Entity\PuestoTrabajo;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class BolsaEmpleoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dni', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('nombre',  TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('direccion',  TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('telefono', IntegerType::class, ['attr' => ['class' => 'form-control']])
            ->add('email',  TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('puesto', EntityType::class, [
                'class' => PuestoTrabajo::class,
                'placeholder' => 'Seleccione un puesto de trabajo:',
                'attr' => ['class' => 'form-select'],
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er ->createQueryBuilder('p')
                            ->where('p.activo = :activo')
                            ->setParameter('activo', 1)
                            ->orderBy('p.nombre', 'ASC');},
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BolsaEmpleo::class,
        ]);
    }
}
