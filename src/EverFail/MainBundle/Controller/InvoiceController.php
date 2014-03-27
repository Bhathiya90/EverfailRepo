<?php

namespace EverFail\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EverFail\MainBundle\Entity\Invoice;
use EverFail\MainBundle\Form\InvoiceType;
use EverFail\MainBundle\Entity\Service;
/**
 * Invoice controller.
 *
 */
class InvoiceController extends Controller {

    /**
     * Lists all Invoice entities.
     *
     */
    public function indexAction(Request $request) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EverFailMainBundle:Invoice')->findAll();
        
        return $this->render('EverFailMainBundle:Invoice:index.html.twig', array(
                    'entities' => $entities,
        ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a new Invoice entity.
     *
     */
    public function createAction(Request $request, $ServId) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
        $entity = new Invoice();
        $form = $this->createCreateForm($entity, $ServId);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $service = $em->getRepository("EverFailMainBundle:Service")->findOneBy(array('id' => $ServId));
        $service->setInvoice($entity);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->render("EverFailMainBundle:initialRegistration:wizardComplete.html.twig");
        }

        return $this->render('EverFailMainBundle:Invoice:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to create a Invoice entity.
     *
     * @param Invoice $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Invoice $entity, $ServId) {
        $form = $this->createForm(new InvoiceType(), $entity, array(
            'action' => $this->generateUrl('invoice_create', array('ServId' => $ServId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Invoice entity.
     *
     */
    public function newAction($ServId) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
        $entity = new Invoice();
        $form = $this->createCreateForm($entity, $ServId);

        return $this->render('EverFailMainBundle:Invoice:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Finds and displays a Invoice entity.
     *
     */
    public function showAction($id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EverFailMainBundle:Invoice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Invoice entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EverFailMainBundle:Invoice:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Displays a form to edit an existing Invoice entity.
     *
     */
    public function editAction($id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EverFailMainBundle:Invoice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Invoice entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EverFailMainBundle:Invoice:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to edit a Invoice entity.
     *
     * @param Invoice $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Invoice $entity) {
        $form = $this->createForm(new InvoiceType(), $entity, array(
            'action' => $this->generateUrl('invoice_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Invoice entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EverFailMainBundle:Invoice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Invoice entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('invoice_edit', array('id' => $id)));
        }

        return $this->render('EverFailMainBundle:Invoice:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Deletes a Invoice entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EverFailMainBundle:Invoice')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Invoice entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('invoice'));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to delete a Invoice entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('invoice_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
