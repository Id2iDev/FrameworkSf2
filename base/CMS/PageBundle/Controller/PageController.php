<?php

namespace Id2i\CMS\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Id2i\CMS\PageBundle\Entity\Page;
use Id2i\CMS\PageBundle\Form\PageType;

/**
 * Page controller.
 *
 */
class PageController extends Controller
{

    /**
     * Lists all Page entities.
     *
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('page', 'back', 'read')) {
            return $access;
        }

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PageBundle:Page')->findByDomaine();

        return $this->render('PageBundle:Page:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Page entity.
     *
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('page', 'back', 'new')) {
            return $access;
        }

        $entity = new Page();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);



        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();


            $entity->setCreatedAt(new \DateTime());
            $entity->setUpdatedAt(new \DateTime());
            $entity->setAuteur($user);
            $etat = $em->getRepository('PageBundle:PageEtat')->find($request->request->get('id2i_core_pagebundle_page_etat'));
            $entity->setEtat($etat);
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'crud.page.msg.success.create');
            } catch (\Doctrine\DBAL\DBALException $e) {
                $this->get('session')->getFlashBag()->add('danger', 'crud.page.msg.error.dbal.create');
                $this->get('session')->getFlashBag()->add('danger', $e->getMessage());

                return $this->render('PageBundle:Page:new.html.twig', array(
                    'entity' => $entity,
                    'form'   => $form->createView(),
                ));
            }

            return $this->redirect($this->generateUrl('gestion_page'));
        }

        return $this->render('PageBundle:Page:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Page entity.
     *
     * @param Page $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Page $entity)
    {
        $form = $this->createForm(new PageType(), $entity, array(
            'action' => $this->generateUrl('gestion_page_create'),
            'method' => 'POST',
        ));

//        $translator = $this->get('translator');
//        $form->add('submit', 'submit', array('label' => $translator->trans('crud.page.btn.create'),'attr'=>array("class"=>"btn-success pull-right ")));

        return $form;
    }

    /**
     * Displays a form to create a new Page entity.
     *
     */
    public function newAction()
    {
        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('page', 'back', 'new')) {
            return $access;
        }
        $entity = new Page();
        $entity->setPubliedAt(new \DateTime());
        $form = $this->createCreateForm($entity);

        return $this->render('PageBundle:Page:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Page entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PageBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }


        return $this->render('PageBundle:Page:show.html.twig', array(
            'entity' => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     */
    public function editAction($id)
    {
        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('page', 'back', 'edit')) {
            return $access;
        }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PageBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('PageBundle:Page:edit.html.twig', array(
            'entity' => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Page entity.
     *
     * @param Page $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Page $entity)
    {
        $form = $this->createForm(new PageType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('gestion_page_update', array('id' => $entity->getId())),
            'attr'   => array("class" => 'form-vertical'),
            'method' => 'POST',
        ));

//        $translator = $this->get('translator');
//        $form->add('submit', 'submit', array('label' => $translator->trans('crud.page.btn.update'), 'attr' => array("class" => "btn-info pull-right ")));


        return $form;
    }

    /**
     * Edits an existing Page entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PageBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new \DateTime());
            $etat = $em->getRepository('PageBundle:PageEtat')->find($request->request->get('id2i_core_pagebundle_page_etat'));
            $entity->setEtat($etat);
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'crud.page.msg.success.update');
            } catch (\Doctrine\DBAL\DBALException $e) {
                $this->get('session')->getFlashBag()->add('danger', 'crud.page.msg.error.dbal.update');
                $this->get('session')->getFlashBag()->add('danger', $e->getMessage());

                return $this->render('PageBundle:Page:edit.html.twig', array(
                    'entity' => $entity,
                    'form'   => $editForm->createView(),
                ));
            }

            return $this->redirect($this->generateUrl('gestion_page', array('id' => $id)));
        }

        return $this->render('PageBundle:Page:edit.html.twig', array(
            'entity' => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Page entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('page', 'back', 'delete')) {
            return $access;
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PageBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'crud.page.msg.success.delete');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $this->get('session')->getFlashBag()->add('danger', 'crud.page.msg.error.dbal.delete');
            $this->get('session')->getFlashBag()->add('danger', $e->getMessage());

        }

        return $this->redirect($this->generateUrl('gestion_page'));
    }


}
