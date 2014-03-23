<?php

namespace EverFail\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CarType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('regNumber', 'text', array('label' => 'Registration Number',
                'attr' =>array('placeholder'=>'AB-1234')))
            ->add('search','search',array(
                'class'=>'EverFailMainBundle:Car',
                'property'=>'regNumber'
            ))
            ->add('model', 'text', array('label' => 'Model',
                'attr' =>array('placeholder'=>'Eg : Toyota')))
            ->add('manufactureYear', 'date', array('label' => 'Year of Manufacture',
                'widget'=>'single_text'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EverFail\MainBundle\Entity\Car'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'everfail_mainbundle_car';
    }
}
