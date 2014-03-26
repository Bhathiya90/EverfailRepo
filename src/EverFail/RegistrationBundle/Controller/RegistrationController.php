<?php

namespace EverFail\RegistrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use EverFail\NotificationBundle\Entity\Notification;
use EverFail\RegistrationBundle\Form\Type\RegistrationType;
use EverFail\RegistrationBundle\Form\Model\Registration;

class RegistrationController extends Controller{
   
    public function registerAction(){
        
        $registration = new Registration();
        $form = $this->createForm(new RegistrationType(), $registration, array(
            'action' => $this->generateUrl('account_create'),
        ));
        
        
        
        
        return $this->render(
            'EverFailRegistrationBundle:Registration:registration.html.twig',
            array('form' => $form->createView())
        );
                
    }
}
?>
