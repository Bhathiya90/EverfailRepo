<?php

namespace EverFail\MainBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ServiceType extends AbstractType {

    protected $car;
    protected $customer;

    public function __construct($customer, $car) {
        $this->car = $car;
        $this->customer = $customer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('serviceDate', 'date', array('label' => 'Date',
                    'widget' => 'single_text'))
                ->add('serviceCharge', null, array('label' => 'Charge (Rs.)',
                    'attr' => array('pattern' => '[0-9]+(.[0-9]{2})?')))
                ->add('note', null, array('label' => 'Note'))
                ->add('car', 'entity', array('label' => 'Car',
                    'class' => 'EverFailMainBundle:Car',
                    'read_only' => true,
                    'data' => $this->car))
                ->add('cust', 'entity', array('label' => 'Customer',
                    'class' => 'EverFailMainBundle:Customer',
                    'read_only' => true,
                    'data' => $this->customer))
//                ->add('invoice', 'entity', array(
//                    'class' => 'EverFailMainBundle:Invoice',
//                    'expanded' => false,
//                    'label' => 'Invoice',
//                    'multiple' => false,
//                    'required' => false,
//                    'empty_value' => '[not issued]',
//                    'empty_data' => null,
//                    'query_builder' => function(EntityRepository $er) {
//                        return $er->createQueryBuilder('i')
//                                ->select('i')
//                                ->where('i.id NOT IN (SELECT IDENTITY(s.invoice)
//									FROM EverFailMainBundle:Service s
//									WHERE s.invoice IS NOT NULL)');
//                    }
//                ))
                ->add('category', 'entity', array(
                    'class' => 'EverFailMainBundle:Category',
                    'expanded' => false,
                    'label' => 'Parts Used',
                    'multiple' => true,
                    'mapped' => false,
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                                ->where('EXISTS (SELECT p FROM EverFailMainBundle:Part p
									WHERE p.category = u AND p.service IS NULL)');
                    }
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'EverFail\MainBundle\Entity\Service'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'everfail_mainbundle_new_service';
    }

}
