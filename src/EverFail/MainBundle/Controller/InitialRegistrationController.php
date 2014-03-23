<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace EverFail\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use 

class InitialRegistrationController extends Controller
{
    public function indexAction()
    {
        return $this->render('EverFailMainBundle:Default:index.html.twig');
    }
    
    public function registerCarAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $form = $this->createForm(new searchType());
        $form->handleRequest($request);
        $id = $request->get('id');
        if ($form->isValid()) {
            $data = $form->getData();
            $name = $data['firstname'];
            $em =$this->getDoctrine()->getEntityManager();
            $repository =$em->getRepository('VolunteerManagementSystemRegistrationBundle:User');
            $result = $repository->findBy(array('firstname'=>$name));
            return $this->render('VolunteerManagementSystemPagesBundle:Result:result.html.twig', array('form' => $form->createView(),'result' => $result,'id'=>$id));
        }
        return $this->render('EverFailMainBundle:Default:index.html.twig');
    }
}
?>
