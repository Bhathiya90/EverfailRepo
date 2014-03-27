<?php

namespace EverFail\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class searchCategoryType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoryName', 'text', array(  
            'label' => 'Search by Category Name',
            'attr'   =>  array(
                'placeholder' => "Search",
                'newline' => 'true',
                'widget' => 'text',
            
            )));
                      
            
            
           $builder
                
            ->add('submit','submit', array(
                'label' => 'Search',
                'attr' => array(
                    'class' => 'button'
                )
                
            ));
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

?>
