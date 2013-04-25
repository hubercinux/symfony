<?php

namespace Miweb\MiwebBundle\Form;

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
            ->add('categoria');
            ////->add('categoria','entity', array('class'=>'Prueba\PruebaBundle\Entity\Categoria', 'property'=>'nombre' ))
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Miweb\MiwebBundle\Entity\Producto'
        ));
    }

    public function getName()
    {
        return 'miweb_miwebbundle_productotype';
    }
}
