<?php

namespace EverFail\RegistrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfirmController extends Controller{
    
    public function confirmAction(){
        
        return $this->render('EverFailRegistrationBundle:Confirm:confirm.html.twig');
    }
    
}

?>