<?php

namespace EverFail\MainBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditServiceType extends AbstractType {
	
	private $em;

    public function __construct($em) {
        $this->em = $em;
    }
	
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$service = $options['data']->getId();
		$chosen = $this->em->getRepository('EverFailMainBundle:Category')
						->createQueryBuilder('u')
						->where('EXISTS (SELECT p FROM EverFailMainBundle:Part p
								WHERE p.category = u AND p.service = :serviceID)')
						->setParameter('serviceID', $service)
						->getQuery()->getResult();
		
		$builder
				->add('serviceDate', 'date', array('label' => 'Date',
					'widget' => 'single_text'))
				->add('serviceCharge', null, array('label' => 'Charge (Rs.)',
					'attr' => array('pattern' => '[0-9]+(.[0-9]{2})?')))
				->add('note', null, array('label' => 'Note'))
				->add('car', null, array(
					'label' => 'Car',
					'empty_value' => false))
				->add('cust', null, array(
					'label' => 'Customer',
					'empty_value' => false))
				->add('invoice', 'entity', array(
					'class' => 'EverFailMainBundle:Invoice',
					'expanded' => false,
					'label' => 'Invoice',
					'multiple' => false,
					'required' => false,
					'empty_value' => '[not issued]',
					'empty_data' => null,
					'query_builder' => function(EntityRepository $er) use ($service) {
						return $er->createQueryBuilder('i')
								->select('i')
								->where('i.id NOT IN (SELECT IDENTITY(s.invoice)
									FROM EverFailMainBundle:Service s
									WHERE s.invoice IS NOT NULL
									AND s.id != :serviceID)')
								->setParameter('serviceID', $service);
					}))
				->add('category', 'entity', array(
					'class' => 'EverFailMainBundle:Category',
					'expanded' => false,
					'label' => 'Parts Used',
					'multiple' => true,
					'mapped' => false,
					'disabled' => true,
					'choices' => $chosen
//					'query_builder' => function(EntityRepository $er) use ($service) {
//						return $er->createQueryBuilder('u')
//								->where('EXISTS (SELECT p FROM EverFailMainBundle:Part p
//									WHERE p.category = u AND
//									(p.service IS NULL OR p.service = :serviceID))')
//								->setParameter('serviceID', $service);
//					},
//					'data' => $chosen,
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
		return 'everfail_mainbundle_edit_service';
	}

}
