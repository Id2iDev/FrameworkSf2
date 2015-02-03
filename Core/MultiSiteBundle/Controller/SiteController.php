<?php

namespace Id2i\Core\MultiSiteBundle\Controller;

use Id2i\Core\NodeBundle\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Id2i\Core\MultiSiteBundle\Entity\Site;
use Id2i\Core\MultiSiteBundle\Form\SiteType;

/**
 * Site controller.
 *
 */
class SiteController extends Controller
{

    /**
     * Lists all Site entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MultiSiteBundle:Site')->findAll();

        return $this->render('MultiSiteBundle:Site:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Site entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Site();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $node = new Node();
            $node->setTitle($entity->getLibelle());
            $entity->setNode($node);
            $node->setBloquer(true);

            $nodeCategorie = new Node();
            $nodeCategorie->setTitle("Categories");
            $nodeCategorie->setParent($node);
            $nodeCategorie->setBloquer(true);

            $nodePlacements = new Node();
            $nodePlacements->setTitle("Placements");
            $nodePlacements->setParent($node);
            $nodePlacements->setBloquer(true);

            $nodeAdmin = new Node();
            $nodeAdmin->setTitle("Administration");
            $nodeAdmin->setParent($node);
            $nodeAdmin->setBloquer(true);

            $nodeMenuAdmin = new Node();
            $nodeMenuAdmin->setTitle("Menu administration");
            $nodeMenuAdmin->setParent($nodeAdmin);
            $nodeMenuAdmin->setBloquer(true);

            $nodeConfig = new Node();
            $nodeConfig->setTitle("Configuration");
            $nodeConfig->setParent($node);
            $nodeConfig->setBloquer(true);

            $em->persist($entity);
            $em->persist($node);
            $em->persist($nodeCategorie);
            $em->persist($nodePlacements);
            $em->persist($nodeAdmin);
            $em->persist($nodeMenuAdmin);
            $em->persist($nodeConfig);
            $em->flush();

            return $this->redirect($this->generateUrl('superadmin_multi_site'));
        }

        return $this->render('MultiSiteBundle:Site:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Site entity.
     *
     * @param Site $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Site $entity)
    {
        $form = $this->createForm(new SiteType(), $entity, array(
            'action' => $this->generateUrl('superadmin_multi_site_create'),
            'method' => 'POST',
        ));
        $translator = $this->get('translator');
        $form->add('submit', 'submit', array('label' => $translator->trans('crud.site.btn.create'),'attr'=>array("class"=>"btn-success pull-right ")));

        return $form;
    }

    /**
     * Displays a form to create a new Site entity.
     *
     */
    public function newAction()
    {
        $entity = new Site();
        $form   = $this->createCreateForm($entity);

        return $this->render('MultiSiteBundle:Site:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Site entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MultiSiteBundle:Site')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Site entity.');
        }


        return $this->render('MultiSiteBundle:Site:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Site entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MultiSiteBundle:Site')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Site entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('MultiSiteBundle:Site:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Site entity.
    *
    * @param Site $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Site $entity)
    {
        $form = $this->createForm(new SiteType(), $entity, array(
            'action' => $this->generateUrl('superadmin_multi_site_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $translator = $this->get('translator');
        $form->add('submit', 'submit', array('label' => $translator->trans('crud.site.btn.update'),'attr'=>array("class"=>"btn-info pull-right ")));


        return $form;
    }
    /**
     * Edits an existing Site entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MultiSiteBundle:Site')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Site entity.');
        }
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $node = $entity->getNode();
            $node->setTitle($entity->getLibelle());
            $em->persist($node);
            $em->flush();

            return $this->redirect($this->generateUrl('superadmin_multi_site_edit', array('id' => $id)));
        }

        return $this->render('MultiSiteBundle:Site:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Site entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MultiSiteBundle:Site')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Site entity.');
            }

            $em->remove($entity);
            $em->flush();

        return $this->redirect($this->generateUrl('superadmin_multi_site'));
    }


}
