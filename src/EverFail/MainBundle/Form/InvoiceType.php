<?php

namespace EverFail\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvoiceType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('paymentDate', 'date', array('label' => 'Date',
                'widget'=>'single_text'))
            ->add('paymentMethod','choice', array('label' => 'Method',
                'choices'=>array('Cash'=>'Cash','Credit Card')))
            ->add('paymentStatus','choice', array('label' => 'Status',
                'choices'=>array('Paid'=>'Paid','Not Paid'=>'Not Paid')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EverFail\MainBundle\Entity\Invoice'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'everfail_mainbundle_invoice';
    }
}
