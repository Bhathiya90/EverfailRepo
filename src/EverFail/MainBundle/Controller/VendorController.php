<?php

namespace EverFail\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EverFail\MainBundle\Entity\Vendor;
use EverFail\MainBundle\Form\VendorType;
use EverFail\MainBundle\Form\searchVendorType;

/**
 * Vendor controller.
 *
 */
class VendorController extends Controller {

    /**
     * Lists all Vendor entities.
     *
     */
    public function indexAction(Request $request) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('EverFailMainBundle:Vendor')->findAll();
            $form = $this->createForm(new searchVendorType());
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $vendorName = $data->getVendorName();
                //  $this->get('logger')->info(gettype($custName));
                $em = $this->getDoctrine()->getEntityManager();
                $repository = $em->getRepository('EverFailMainBundle:Vendor');
                $result = $repository->findBy(array('vendorName' => $vendorName));
                if ($result != null)
                    return $this->render('EverFailMainBundle:Vendor:index.html.twig', array('form' => $form->createView(), 'entities' => $result));
                else
                //return $this->render('EverFailMainBundle:default:index.html.twig', array('form' => $form->createView()));
                    return $this->render('EverFailMainBundle:Default:resultNotFound.html.twig', array('form' => $form->createView()));
            }
            return $this->render('EverFailMainBundle:Vendor:index.html.twig', array(
                        'form' => $form->createView(),
                        'entities' => $entities,
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a new Vendor entity.
     *
     */
    public function createAction(Request $request) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $entity = new Vendor();
            $form = $this->createCreateForm($entity);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('vendor_show', array('id' => $entity->getId())));
            }

            return $this->render('EverFailMainBundle:Vendor:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to create a Vendor entity.
     *
     * @param Vendor $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Vendor $entity) {
        $form = $this->createForm(new VendorType(), $entity, array(
            'action' => $this->generateUrl('vendor_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Vendor entity.
     *
     */
    public function newAction() {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $entity = new Vendor();
            $form = $this->createCreateForm($entity);

            return $this->render('EverFailMainBundle:Vendor:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Finds and displays a Vendor entity.
     *
     */
    public function showAction($id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Vendor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vendor entity.');
            }

            $deleteForm = $this->createDeleteForm($id);

            return $this->render('EverFailMainBundle:Vendor:show.html.twig', array(
                        'entity' => $entity,
                        'delete_form' => $deleteForm->createView(),));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Displays a form to edit an existing Vendor entity.
     *
     */
    public function editAction($id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Vendor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vendor entity.');
            }

            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('EverFailMainBundle:Vendor:edit.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to edit a Vendor entity.
     *
     * @param Vendor $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Vendor $entity) {
        $form = $this->createForm(new VendorType(), $entity, array(
            'action' => $this->generateUrl('vendor_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Vendor entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Vendor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vendor entity.');
            }

            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($entity);
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('vendor_edit', array('id' => $id)));
            }

            return $this->render('EverFailMainBundle:Vendor:edit.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Deletes a Vendor entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $form = $this->createDeleteForm($id);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('EverFailMainBundle:Vendor')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Vendor entity.');
                }

                $em->remove($entity);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('vendor'));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to delete a Vendor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('vendor_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
