<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace EverFail\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EverFail\MainBundle\Form\VendorRegistrationType;
use EverFail\MainBundle\Form\CategoryRegistrationType;
use Symfony\Component\HttpFoundation\Request;

class PartsPurchaseController extends Controller {

    public function indexAction() {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            return $this->render('EverFailMainBundle:Default:index.html.twig');
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    public function registerCategoryAction(Request $request, $VenId) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('EverFailMainBundle:Category')->findAll();
            $vendor = $em->getRepository('EverFailMainBundle:Vendor')->findOneBy(array('id' => $VenId));
            $form = $this->createForm(new CategoryRegistrationType());
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $categoryName = $data->getCategoryName();
//  $this->get('logger')->info(gettype($vendorName));
                $em = $this->getDoctrine()->getEntityManager();
                $repository = $em->getRepository('EverFailMainBundle:Category');
                $result = $repository->findBy(array('categoryName' => $categoryName));
                if ($result != null)
                    return $this->render('EverFailMainBundle:PartsPurchase:resultsCategory.html.twig', array('form' => $form->createView(), 'category' => $result, 'vendor' => $vendor));
                else
                    return $this->render('EverFailMainBundle:PartsPurchase:noResultCategory.html.twig', array('form' => $form->createView(), 'vendor' => $vendor));
            }
            return $this->render('EverFailMainBundle:PartsPurchase:categoryRegistration.html.twig', array('form' => $form->createView(), 'entities' => $entities, 'vendor' => $vendor));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    public function registerVendorAction(Request $request) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('EverFailMainBundle:Vendor')->findAll();
            $form = $this->createForm(new VendorRegistrationType());
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $vendorName = $data->getVendorName();
//$this->get('logger')->info(gettype($custName));
                $em = $this->getDoctrine()->getEntityManager();
                $repository = $em->getRepository('EverFailMainBundle:Vendor');
                $result = $repository->findBy(array('vendorName' => $vendorName));

                if ($result != null)
                    return $this->render('EverFailMainBundle:PartsPurchase:resultsVendor.html.twig', array('form' => $form->createView(), 'result' => $result));
                else
//return $this->render('EverFailMainBundle:default:index.html.twig', array('form' => $form->createView()));
                    return $this->render('EverFailMainBundle:PartsPurchase:noResultsVendor.html.twig', array('form' => $form->createView()));
            }
            return $this->render('EverFailMainBundle:PartsPurchase:vendorRegistration.html.twig', array('form' => $form->createView(), 'entities' => $entities));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    public function showCategoryAction($VenId, $CatId) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $category = $em->getRepository('EverFailMainBundle:Category')->find($CatId);
            $vendor = $em->getRepository('EverFailMainBundle:Vendor')->findOneBy(array('id' => $VenId));

            if (!$category) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }


            return $this->render('EverFailMainBundle:PartsPurchase:showCategory.html.twig', array(
                        'category' => $category, 'vendor' => $vendor));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    public function showVendorAction($id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Vendor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vendor entity.');
            }


            return $this->render('EverFailMainBundle:PartsPurchase:showVendor.html.twig', array(
                        'vendorentity' => $entity));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

}

?>
