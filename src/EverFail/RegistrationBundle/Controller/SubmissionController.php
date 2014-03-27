<?php

namespace EverFail\RegistrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EverFail\RegistrationBundle\Form\Type\RegistrationType;
use EverFail\RegistrationBundle\Form\Model\Registration;
use Doctrine\DBAL\DBALException;

class SubmissionController extends Controller {

    public function submissionAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createForm(new RegistrationType(), new Registration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();
            $em->persist($registration->getUser());
            try {
                $em->flush();
            } catch (DBALException $e) {
                return $this->render('EverFailRegistrationBundle:Submission:submission.html.twig', array('form' => $form->createView()));
            }
            $id = $registration->getUser()->getId();
            $em = $this->getDoctrine()->getEntityManager();
            $Repository = $em->getRepository('EverFailRegistrationBundle:User');

            $user = $Repository->findOneBy(array('id' => $id));
            $idt = $user->getId();
            return $this->render('EverFailRegistrationBundle:Login:confirmation.html.twig');
        }

        return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('form' => $form->createView()));
    }

}

?>
