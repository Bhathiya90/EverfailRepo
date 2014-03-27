<?php

namespace EverFail\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

	public function indexAction() {
		return $this->render('EverFailMainBundle:Default:index.html.twig');
	}

}
