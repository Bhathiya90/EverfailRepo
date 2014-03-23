<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace EverFail\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EverFail\MainBundle\Form\CustomerRegistrationType;
use Symfony\Component\HttpFoundation\Request;

class InitialRegistrationController extends Controller
{
    public function indexAction()
    {
        return $this->render('EverFailMainBundle:Default:index.html.twig');
    }
    
  
    public function registerCustomerAction(Request $request)
    {   
        $form = $this->createForm(new CustomerRegistrationType());
        $form->handleRequest($request);
        if($form->isValid()){
            $data =$form->getData();
            $name=$data['name'];
            $em =$this->getDoctrine()->getEntityManager();
            $repository =$em->getRepository('EverFailMainBundle:Customer');
            $result = $repository->findBy(array('firstname'=>$name));
            if ($result != null) {
                return $this->render('EverFailMainBundle:Result:customerRegistration.html.twig', array('form' => $form->createView(), 'result' => $result));
            } else {
                return $this->render('EverFailMainBundle:initialRegistration:customerRegistration.html.twig');
            }
        }
        return $this->render('EverFailMainBundle:Customer:index.html.twig');
        }
        
        
 
    }
?>
