<?php

namespace EverFail\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PartType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('partName', null, array('label' => 'Name',
                'required'=>'true'))
            ->add('price', 'text', array('label' => 'Price',
                'pattern'=>'[0-9]+(.[0-9]{2})?',
                'attr'=>array('placeholder'=>'000.00')))
            ->add('vendor', null, array('label' => 'Vendor'))
            ->add('category', null, array('label' => 'Category'))
            ->add('service', null, array('label' => 'Used in Service'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EverFail\MainBundle\Entity\Part'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'everfail_mainbundle_part';
    }
}
