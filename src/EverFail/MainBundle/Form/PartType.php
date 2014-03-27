<?php

namespace EverFail\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PartType extends AbstractType {

    protected $vendor;
    protected $category;

    public function __construct($vendor, $category) {
        $this->vendor = $vendor;
        $this->category = $category;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('price', null, array('label' => 'Price (Rs.)',
                    'attr' => array('pattern' => '[0-9]+(.[0-9]{2})?')))
                ->add('purchasedDate', 'date', array('label' => 'Date of Purchase',
                    'widget' => 'single_text'))
                ->add('vendorWarranty', 'integer', array(
                    'label' => 'Vendor\'s Warranty (months)',
                    'attr' => array('min' => 0)))
                ->add('vendor', 'entity', array('label' => 'Vendor',
                    'class' => 'EverFailMainBundle:Vendor',
                    'read_only' => true,
                    'data' => $this->vendor))
                ->add('category', 'entity', array('label' => 'Category',
                    'class' => 'EverFailMainBundle:Category',
                    'read_only' => true,
                    'data' => $this->category))
                ->add('amount', 'integer', array('label' => 'Amount',
                    'mapped' => false,
                    'attr'=>array('min'=>0)))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'EverFail\MainBundle\Entity\Part'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'everfail_mainbundle_part';
    }

}

