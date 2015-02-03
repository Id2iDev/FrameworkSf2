<?php

namespace Id2i\Tools\PubliciteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Id2i\Tools\PubliciteBundle\Entity\Publicite;
use Id2i\Tools\PubliciteBundle\Form\PubliciteType;

/**
 * Publicite controller.
 *
 */
class PubliciteController extends Controller
{

    /**
     * Lists all Publicite entities.
     *
     */
    public function indexAction()
    {
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('publicite', 'back', 'show')) {
    return $access;
    }
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PubliciteBundle:Publicite')->findAll();

        return $this->render('PubliciteBundle:Publicite:index.html.twig', array(
            'entities' => $entities,
        ));
    }
/**
    * Creates a new Publicite entity.
*
    */
    public function createAction(Request $request)
{
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('publicite', 'back', 'add')) {
        return $access;
    }
    $entity = new Publicite();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
    $em = $this->getDoctrine()->getManager();
    try {
    $em = $this->getDoctrine()->getManager();
    $em->persist($entity);
    $em->flush();
    $this->get('session')->getFlashBag()->add('success', 'crud.publicite.msg.success.create');
    } catch(\Doctrine\DBAL\DBALException $e) {
    $this->get('session')->getFlashBag()->add('danger', 'crud.publicite.msg.error.dbal.create');
    $this->get('session')->getFlashBag()->add('danger', $e->getMessage());

    }

    return $this->redirect($this->generateUrl('tools_publicite'));
    }

            return $this->render('PubliciteBundle:Publicite:new.html.twig', array(
        'entity' => $entity,
        'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Publicite entity.
    *
    * @param Publicite $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Publicite $entity)
    {
    $form = $this->createForm(new PubliciteType(), $entity, array(
    'action' => $this->generateUrl('tools_publicite_create'),
    'method' => 'POST',
    ));
    $translator = $this->get('translator');
    $form->add('submit', 'submit', array('label' => $translator->trans('crud.publicite.btn.create'),'attr'=>array("class"=>"btn-success pull-right ")));

    return $form;
    }

    /**
     * Displays a form to create a new Publicite entity.
     *
     */
    public function newAction()
    {
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('publicite', 'back', 'add')) {
    return $access;
    }
        $entity = new Publicite();
        $form   = $this->createCreateForm($entity);

        return $this->render('PubliciteBundle:Publicite:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Publicite entity.
     *
     */
    public function showAction($id)
    {
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('publicite', 'back', 'show')) {
    return $access;
    }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PubliciteBundle:Publicite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publicite entity.');
        }


        return $this->render('PubliciteBundle:Publicite:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Publicite entity.
     *
     */
    public function editAction($id)
    {
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('publicite', 'back', 'edit')) {
    return $access;
    }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PubliciteBundle:Publicite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publicite entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('PubliciteBundle:Publicite:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Publicite entity.
    *
    * @param Publicite $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Publicite $entity)
    {
        $form = $this->createForm(new PubliciteType(), $entity, array(
            'action' => $this->generateUrl('tools_publicite_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $translator = $this->get('translator');
        $form->add('submit', 'submit', array('label' => $translator->trans('crud.publicite.btn.update'),'attr'=>array("class"=>"btn-info pull-right ")));


        return $form;
    }
/**
    * Edits an existing Publicite entity.
*
    */
    public function updateAction(Request $request, $id)
{
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('publicite', 'back', 'edit')) {
    return $access;
    }
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('PubliciteBundle:Publicite')->find($id);

    if (!$entity) {
    throw $this->createNotFoundException('Unable to find Publicite entity.');
    }

    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
    try {
    $em = $this->getDoctrine()->getManager();
    $em->flush();
    $this->get('session')->getFlashBag()->add('success', 'crud.publicite.msg.success.update');
    } catch(\Doctrine\DBAL\DBALException $e) {
    $this->get('session')->getFlashBag()->add('danger', 'crud.publicite.msg.error.dbal.update');
    $this->get('session')->getFlashBag()->add('danger', $e->getMessage());

    }

    return $this->redirect($this->generateUrl('tools_publicite_edit', array('id' => $id)));
    }

            return $this->render('PubliciteBundle:Publicite:edit.html.twig', array(
        'entity'      => $entity,
        'edit_form'   => $editForm->createView(),
        ));
    }
/**
    * Deletes a Publicite entity.
*
    */
    public function deleteAction(Request $request, $id)
{
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('publicite', 'back', 'delete')) {
        return $access;
    }
    $em = $this->getDoctrine()->getManager();
    $entity = $em->getRepository('PubliciteBundle:Publicite')->find($id);

    if (!$entity) {
    throw $this->createNotFoundException('Unable to find Publicite entity.');
    }
    try {
    $em = $this->getDoctrine()->getManager();
    $em->remove($entity);
    $em->flush();
    $this->get('session')->getFlashBag()->add('success', 'crud.publicite.msg.success.delete');
    } catch(\Doctrine\DBAL\DBALException $e) {
    $this->get('session')->getFlashBag()->add('danger', 'crud.publicite.msg.error.dbal.delete');
    $this->get('session')->getFlashBag()->add('danger', $e->getMessage());

    }

    return $this->redirect($this->generateUrl('tools_publicite'));
}


}
