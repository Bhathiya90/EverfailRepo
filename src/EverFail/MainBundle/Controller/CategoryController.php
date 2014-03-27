<?php

namespace EverFail\MainBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use EverFail\MainBundle\ApplicationBoot;
use EverFail\MainBundle\Entity\Category;
use EverFail\MainBundle\Form\CategoryType;
use EverFail\MainBundle\Form\searchCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller {

    /**
     * Lists all Category entities.
     *
     */
    public function indexAction(Request $request) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('EverFailMainBundle:Category')->findAll();
            $form = $this->createForm(new searchCategoryType());
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $categoryName = $data->getCategoryName();
                //  $this->get('logger')->info(gettype($custName));
                $em = $this->getDoctrine()->getEntityManager();
                $repository = $em->getRepository('EverFailMainBundle:Category');

                $expr = Criteria::expr();
                $crieteria = Criteria::create();
                $crieteria->where($expr->contains('categoryName', $categoryName));
                $result = $repository->matching($crieteria);
                if ($result != null)
                    return $this->render('EverFailMainBundle:Category:index.html.twig', array('form' => $form->createView(), 'entities' => $result));
                else
                //return $this->render('EverFailMainBundle:default:index.html.twig', array('form' => $form->createView()));
                    return $this->render('EverFailMainBundle:Default:resultNotFound.html.twig', array('form' => $form->createView()));
            }

            return $this->render('EverFailMainBundle:Category:index.html.twig', array(
                        'form' => $form->createView(),
                        'entities' => $entities,
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a new Category entity.
     *
     */
    public function createAction(Request $request, $VenId) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $entity = new Category();
            $form = $this->createCreateForm($entity, $VenId);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $vendor = $em->getRepository('EverFailMainBundle:Vendor')->findOneBy(array('id' => $VenId));

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('wizard_category_show', array('CatId' => $entity->getId(), 'VenId' => $vendor->getId())));
            }

            return $this->render('EverFailMainBundle:Category:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to create a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return Form The form
     */
    private function createCreateForm(Category $entity, $VenId) {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('category_create', array('VenId' => $VenId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Category entity.
     *
     */
    public function newAction($VenId) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $entity = new Category();
            $form = $this->createCreateForm($entity, $VenId);

            return $this->render('EverFailMainBundle:Category:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Finds and displays a Category entity.
     *
     */
    public function showAction($id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $deleteForm = $this->createDeleteForm($id);

            return $this->render('EverFailMainBundle:Category:show.html.twig', array(
                        'entity' => $entity,
                        'delete_form' => $deleteForm->createView(),));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     */
    public function editAction($id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('EverFailMainBundle:Category:edit.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to edit a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return Form The form
     */
    private function createEditForm(Category $entity) {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('category_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Category entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('EverFailMainBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($entity);
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('category_edit', array('id' => $id)));
            }

            return $this->render('EverFailMainBundle:Category:edit.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Deletes a Category entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $session = $this->getRequest()->getSession();
        if ($session->has('login')) {
            $form = $this->createDeleteForm($id);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('EverFailMainBundle:Category')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Category entity.');
                }

                $em->remove($entity);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('category'));
        } else {
            return $this->render('EverFailRegistrationBundle:Login:login.html.twig', array('id' => ''));
        }
    }

    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('category_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    //find unused part count under given category
    public static function getStock($category) {
        $container = ApplicationBoot::getContainer();
        $em = $container->get('doctrine')->getEntityManager();
        $entities = $em->getRepository('EverFailMainBundle:Part')
                ->findBy(array('category' => $category, 'service' => 'null'));
        return count($entities);
    }

}
