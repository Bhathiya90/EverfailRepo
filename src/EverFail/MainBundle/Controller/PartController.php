<?php

namespace EverFail\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EverFail\MainBundle\Entity\Part;
use EverFail\MainBundle\Form\PartType;

/**
 * Part controller.
 *
 */
class PartController extends Controller {

    /**
     * Lists all Part entities.
     *
     */
    public function indexAction() {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('EverFailMainBundle:Part')->findAll();

            return $this->render('EverFailMainBundle:Part:index.html.twig', array(
                        'entities' => $entities,
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a new Part entity.
     *
     */
    public function createAction(Request $request, $VenId, $CatId) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $entity = new Part();
            $form = $this->createCreateForm($entity, $VenId, $CatId);
            $form->handleRequest($request);
            $amounts = $form->get('amount');
            $amount = $amounts->getData();

            if ($form->isValid()) {
                for ($temp = 1; $temp <= $amount; $temp++) {
                    if ($form->isValid()) {
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($entity);
                        $em->flush();
                        $entity = new Part();
                        $form = $this->createCreateForm($entity, $VenId, $CatId);
                        $form->handleRequest($request);
                    }
                }
                return $this->render('EverFailMainBundle:initialRegistration:wizardComplete.html.twig');
            }
            return $this->render('EverFailMainBundle:Part:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to create a Part entity.
     *
     * @param Part $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Part $entity, $VenId, $CatId) {
        $em = $this->getDoctrine()->getManager();
        $vendor = $em->getRepository('EverFailMainBundle:Vendor')->findOneBy(array('id' => $VenId));
        $category = $em->getRepository('EverFailMainBundle:Category')->findOneBy(array('id' => $CatId));
        $form = $this->createForm(new PartType($vendor, $category), $entity, array(
            'action' => $this->generateUrl('part_create', array('VenId' => $VenId, 'CatId' => $CatId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Part entity.
     *
     */
    public function newAction($VenId, $CatId) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $entity = new Part();
            $form = $this->createCreateForm($entity, $VenId, $CatId);

            return $this->render('EverFailMainBundle:Part:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Finds and displays a Part entity.
     *
     */
    public function showAction($id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Part')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Part entity.');
            }

            $deleteForm = $this->createDeleteForm($id);

            return $this->render('EverFailMainBundle:Part:show.html.twig', array(
                        'entity' => $entity,
                        'delete_form' => $deleteForm->createView(),));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Displays a form to edit an existing Part entity.
     *
     */
    public function editAction($id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Part')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Part entity.');
            }

            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('EverFailMainBundle:Part:edit.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to edit a Part entity.
     *
     * @param Part $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Part $entity) {
        $form = $this->createForm(new PartType(), $entity, array(
            'action' => $this->generateUrl('part_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Part entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Part')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Part entity.');
            }

            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($entity);
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('part_edit', array('id' => $id)));
            }

            return $this->render('EverFailMainBundle:Part:edit.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Deletes a Part entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $form = $this->createDeleteForm($id);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('EverFailMainBundle:Part')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Part entity.');
                }

                $em->remove($entity);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('part'));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to delete a Part entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('part_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
