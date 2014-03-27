<?php

namespace EverFail\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EverFail\MainBundle\Entity\Car;
use EverFail\MainBundle\Form\CarType;
use EverFail\MainBundle\Form\searchCarType;

/**
 * Car controller.
 *
 */
class CarController extends Controller {

    /**
     * Lists all Car entities.
     *
     */
    public function indexAction(Request $request) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('EverFailMainBundle:Car')->findAll();
            $form = $this->createForm(new searchCarType());
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $regNumber = $data->getRegNumber();
                //  $this->get('logger')->info(gettype($custName));
                $em = $this->getDoctrine()->getEntityManager();
                $repository = $em->getRepository('EverFailMainBundle:Car');
                $result = $repository->findBy(array('regNumber' => $regNumber));
                if ($result != null)
                    return $this->render('EverFailMainBundle:Car:index.html.twig', array('form' => $form->createView(), 'entities' => $result));
                else
                //return $this->render('EverFailMainBundle:default:index.html.twig', array('form' => $form->createView()));
                    return $this->render('EverFailMainBundle:Default:resultNotFound.html.twig', array('form' => $form->createView()));
            }

            return $this->render('EverFailMainBundle:Car:index.html.twig', array(
                        'form' => $form->createView(),
                        'entities' => $entities,
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    //   return $this->render('EverFailMainBundle:initialRegistration:customerRegistration.html.twig', array('form' => $form->createView(),'entities' => $entities));
    /**
     * Creates a new Car entity.
     *
     */
    public function createAction(Request $request, $CustId) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $entity = new Car();
            $form = $this->createCreateForm($entity, $CustId);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $customer = $em->getRepository('EverFailMainBundle:Customer')->findOneBy(array('id' => $CustId));
            $this->get('logger')->info(gettype($customer));

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('wizard_car_show', array('CarId' => $entity->getId(), 'CustId' => $CustId)));
            }

            return $this->render('EverFailMainBundle:Car:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to create a Car entity.
     *
     * @param Car $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Car $entity, $CustId) {

        $form = $this->createForm(new CarType(), $entity, array(
            'action' => $this->generateUrl('car_create', array('CustId' => $CustId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Car entity.
     *
     */
    public function newAction($CustId) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $entity = new Car();
            $form = $this->createCreateForm($entity, $CustId);
            return $this->render('EverFailMainBundle:Car:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Finds and displays a Car entity.
     *
     */
    public function showAction($id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Car')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Car entity.');
            }

            $deleteForm = $this->createDeleteForm($id);

            return $this->render('EverFailMainBundle:Car:show.html.twig', array(
                        'entity' => $entity,
                        'delete_form' => $deleteForm->createView(),));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Displays a form to edit an existing Car entity.
     *
     */
    public function editAction($id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Car')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Car entity.');
            }

            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('EverFailMainBundle:Car:edit.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to edit a Car entity.
     *
     * @param Car $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Car $entity) {

        $form = $this->createForm(new CarType(), $entity, array(
            'action' => $this->generateUrl('car_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Car entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Car')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Car entity.');
            }

            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($entity);
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('car_edit', array('id' => $id)));
            }

            return $this->render('EverFailMainBundle:Car:edit.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Deletes a Car entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $form = $this->createDeleteForm($id);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('EverFailMainBundle:Car')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Car entity.');
                }

                $em->remove($entity);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('car'));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to delete a Car entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('car_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
