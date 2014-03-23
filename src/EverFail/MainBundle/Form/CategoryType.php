<?php

namespace EverFail\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoryName', null, array('label' => 'Category Name'))
            ->add('description', null, array('label' => 'Description'))
            ->add('minStock', 'integer', array('label' => 'Minimum Stock',
                'attr'=>array('min'=>'0')))
            ->add('stock', 'integer', array('label' => 'Available Stock',
                'attr'=>array('min'=>'0')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EverFail\MainBundle\Entity\Category'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'everfail_mainbundle_category';
    }
}
