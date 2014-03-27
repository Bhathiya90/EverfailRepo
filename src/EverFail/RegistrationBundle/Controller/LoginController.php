<?php

namespace EverFail\RegistrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EverFail\RegistrationBundle\Session\Login;
use Symfony\Component\HttpFoundation\Cookie;

class LoginController extends Controller {

    public function loginAction(Request $request) {
        $session = $this->getRequest()->getSession();
        if ($request->getMethod() == 'POST') {

            $session->clear();
            $username = $request->get('username');
            $password = sha1($request->get('password'));
            $remember = $request->get('remember');
            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('EverFailRegistrationBundle:User');

            $user = $repository->findOneBy(array('username' => $username, 'password' => $password));

            if ($user) {
                $session->set('id', $user->getId());

                    $login = new Login();
                    $login->setUsername($username);
                    $login->setPassword(sha1($password));
                    $session->set('login', $login);
                   
                
                return $this->redirect($this->generateUrl('welcome', $paramters = array('id' => $user->getId())));
            } else {
                return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('name' => 'Login Failed'));
            }
        } else {
            if ($session->has('login')) {
                $login = $session->get('login');
                $username = $login->getUsername();
                $password = $login->getPassword();

                $em = $this->getDoctrine()->getEntityManager();
                $repository = $em->getRepository('EverFailRegistrationBundle:User');

                $user = $repository->findOneBy(array('username' => $username, 'password' => $password));

                if ($user) {
                    return $this->redirect($this->generateUrl('welcome', $paramters = array('id' => $user->getId())));
                }
            }
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    public function logoutAction() {
        $session = $this->getRequest()->getSession();
        $session->clear();
        
        return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
    }

}
