<?php

namespace EverFail\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ServiceType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('serviceDate', 'date', array('label' => 'Date',
                'widget'=>'single_text'))
            ->add('serviceCharge', 'text', array('label' => 'Charge (Rs.)','pattern'=>'[0-9]+(.[0-9]{2})?',
                'attr'=>array('placeholder'=>'000.00')))
            ->add('note', null, array('label' => 'Note'))
            ->add('car',null, array('label' => 'Car'))
            ->add('cust', null, array('label' => 'Customer'))
            ->add('invoice', null, array('label' => 'Invoice'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EverFail\MainBundle\Entity\Service'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'everfail_mainbundle_service';
    }
}
