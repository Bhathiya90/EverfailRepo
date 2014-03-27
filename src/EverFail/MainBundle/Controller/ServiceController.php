<?php

namespace EverFail\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EverFail\MainBundle\Entity\Service;
use EverFail\MainBundle\Form\ServiceType;
use EverFail\MainBundle\Form\EditServiceType;
use Symfony\Component\Debug\Exception\DummyException;

/**
 * Service controller.
 *
 */
class ServiceController extends Controller {

    /**
     * Lists all Service entities.
     *
     */
    public function indexAction() {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('EverFailMainBundle:Service')->findAll();

            return $this->render('EverFailMainBundle:Service:index.html.twig', array(
                        'entities' => $entities,
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a new Service entity.
     *
     */
    public function createAction(Request $request, $CustId, $CarId) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $service = new Service();
            $form = $this->createCreateForm($service, $CustId, $CarId);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($service);

                //update category and parts
                $categoryField[] = $form->get('category');
                $categories = $categoryField[0];

                $categoryList = $categories->getData();
                foreach ($categoryList as $category) {
//				$this->get('logger')->info($category);
                    //mark 1 part of each type of categories as used (for this Service)
                    $part = $em->getRepository('EverFailMainBundle:Part')
                            ->findOneBy(array('category' => $category->getId(), 'service' => null));
                    //category shown in Service creation page => category has nonzero balance => parts must be present
                    //if not, throw an exception
                    if ($part == null) {
                        throw new DummyException("Constraint violation: Category stock and Parts list don't match");
                    }
                    $part->setService($service);
                    $em->persist($part);

                    //reduce 1 from stock of each category
                    $newStock = $category->getStock() - 1;
                    $em->persist($category);

                    //send email if stock is below minimum stock
                    if ($newStock < $category->getMinStock()) {
                        //find relevant vendors
                        $query = $em->createQuery("SELECT IDENTITY(p.vendor) FROM EverFailMainBundle:Part p WHERE p.category = :cat")
                                ->setParameter('cat', $category);
                        $vendorIDs = $query->getResult();

                        foreach ($vendorIDs as $vendorID) {
                            $tmp = array_values($vendorID);
                            $vendorList = $em->getRepository('EverFailMainBundle:Vendor')->findBy(array('id' => $vendorID));
                            //$this->get('logger')->info(gettype($vendorss[0]));
                            foreach ($vendorList as $vendor) {
                                $message = \Swift_Message::newInstance()
                                        ->setSubject('Hello Email')
                                        ->setFrom('everfailservices@gmail.com')
                                        ->setTo($vendor->getEmail())
                                        ->setBody(
                                        $this->renderView(
                                                'EverFailMainBundle:email:vendorEmail.html.twig', array('vendor' => $vendor, 'category' => $category)
                                        )
                                        )
                                ;
                                $this->get('mailer')->send($message);
                            }
                        }
                    }
                }

                //write changes to database
                $em->flush();

                return $this->redirect($this->generateUrl('wizard_service_show', array('id' => $service->getId())));
            }

            return $this->render('EverFailMainBundle:Service:new.html.twig', array(
                        'entity' => $service,
                        'form' => $form->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to create a Service entity.
     *
     * @param Service $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Service $entity, $CustId, $CarId) {
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('EverFailMainBundle:Customer')->findOneBy(array('id' => $CustId));
        $car = $em->getRepository('EverFailMainBundle:Car')->findOneBy(array('id' => $CarId));
        $form = $this->createForm(new ServiceType($customer, $car), $entity, array(
            'action' => $this->generateUrl('service_create', array('CustId' => $CustId, 'CarId' => $CarId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Service entity.
     *
     */
    public function newAction($CustId, $CarId) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $entity = new Service();
            $form = $this->createCreateForm($entity, $CustId, $CarId);

            return $this->render('EverFailMainBundle:Service:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Finds and displays a Service entity.
     *
     */
    public function showAction($id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Service')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Service entity.');
            }

            $deleteForm = $this->createDeleteForm($id);

            return $this->render('EverFailMainBundle:Service:show.html.twig', array(
                        'entity' => $entity,
                        'delete_form' => $deleteForm->createView(),));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Displays a form to edit an existing Service entity.
     *
     */
    public function editAction($id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Service')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Service entity.');
            }

            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('EverFailMainBundle:Service:edit.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to edit a Service entity.
     *
     * @param Service $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Service $entity) {
        $form = $this->createForm(new EditServiceType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('service_update', array('id' => $entity->getId())),
            'method' => 'PUT'
//			, 'attr' => array('repository' => $this->getDoctrine()->getRepository('EverFailMainBundle:Part'))
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Service entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Service')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Service entity.');
            }

            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($entity);
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('service_edit', array('id' => $id)));
            }

            return $this->render('EverFailMainBundle:Service:edit.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Deletes a Service entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $form = $this->createDeleteForm($id);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('EverFailMainBundle:Service')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Service entity.');
                }

                $em->remove($entity);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('service'));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to delete a Service entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('service_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}

