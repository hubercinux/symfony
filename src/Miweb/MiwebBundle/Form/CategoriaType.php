<?php

namespace Miweb\MiwebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('file','file',array('label'=>'Imagen'))
            //->add('fecha','date', array(
            //       'empty_value' => array('year' => 'Año', 'month' => 'Mes', 'day' => 'Día'),'format' => 'dd/MMMM/yyyy',
            //                            )
            //    )                       
            ->add('fecha','date',array('widget' => 'single_text','format' => 'yyyy-MM-dd',))
            //add('fecha','datetime')
            //->add('fecha','date',array('widget' => 'single_text', 'label'  => 'Due Date',))
            ;

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Miweb\MiwebBundle\Entity\Categoria'
        ));
    }

    public function getName()
    {
        return 'miweb_miwebbundle_categoriatype';
    }
}



























