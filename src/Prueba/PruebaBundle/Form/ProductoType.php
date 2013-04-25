<?php

namespace Prueba\PruebaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('precio')
            ->add('descripcion')
            ->add('categoria','entity', array('class'=>'Prueba\PruebaBundle\Entity\Categoria', 'property'=>'nombre' ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Prueba\PruebaBundle\Entity\Producto'
        ));
    }

    public function getName()
    {
        return 'prueba_pruebabundle_productotype';
    }
}
