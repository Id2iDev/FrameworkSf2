<?php

namespace Id2i\Tools\CommuneBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Id2i\Tools\CommuneBundle\Entity\Commune;
use Id2i\Tools\CommuneBundle\Form\CommuneType;

/**
 * Commune controller.
 *
 */
class CommuneController extends Controller
{

    /**
     * Lists all Commune entities.
     *
     */
    public function indexAction()
    {
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('commune', 'back', 'show')) {
    return $access;
    }
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CommuneBundle:Commune')->findAll();

        return $this->render('CommuneBundle:Commune:index.html.twig', array(
            'entities' => $entities,
        ));
    }
/**
    * Creates a new Commune entity.
*
    */
    public function createAction(Request $request)
{
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('commune', 'back', 'add')) {
        return $access;
    }
    $entity = new Commune();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
    $em = $this->getDoctrine()->getManager();
    try {
    $em = $this->getDoctrine()->getManager();
    $em->persist($entity);
    $em->flush();
    $this->get('session')->getFlashBag()->add('success', 'crud.commune.msg.success.create');
    } catch(\Doctrine\DBAL\DBALException $e) {
    $this->get('session')->getFlashBag()->add('danger', 'crud.commune.msg.error.dbal.create');
    $this->get('session')->getFlashBag()->add('danger', $e->getMessage());

    }

    return $this->redirect($this->generateUrl('commune'));
    }

            return $this->render('CommuneBundle:Commune:new.html.twig', array(
        'entity' => $entity,
        'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Commune entity.
    *
    * @param Commune $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Commune $entity)
    {
    $form = $this->createForm(new CommuneType(), $entity, array(
    'action' => $this->generateUrl('commune_create'),
    'method' => 'POST',
    ));
    $translator = $this->get('translator');
    $form->add('submit', 'submit', array('label' => $translator->trans('crud.commune.btn.create'),'attr'=>array("class"=>"btn-success pull-right ")));

    return $form;
    }

    /**
     * Displays a form to create a new Commune entity.
     *
     */
    public function newAction()
    {
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('commune', 'back', 'add')) {
    return $access;
    }
        $entity = new Commune();
        $form   = $this->createCreateForm($entity);

        return $this->render('CommuneBundle:Commune:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Commune entity.
     *
     */
    public function showAction($id)
    {
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('commune', 'back', 'show')) {
    return $access;
    }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CommuneBundle:Commune')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commune entity.');
        }


        return $this->render('CommuneBundle:Commune:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Commune entity.
     *
     */
    public function editAction($id)
    {
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('commune', 'back', 'edit')) {
    return $access;
    }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CommuneBundle:Commune')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commune entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('CommuneBundle:Commune:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Commune entity.
    *
    * @param Commune $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Commune $entity)
    {
        $form = $this->createForm(new CommuneType(), $entity, array(
            'action' => $this->generateUrl('commune_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $translator = $this->get('translator');
        $form->add('submit', 'submit', array('label' => $translator->trans('crud.commune.btn.update'),'attr'=>array("class"=>"btn-info pull-right ")));


        return $form;
    }
/**
    * Edits an existing Commune entity.
*
    */
    public function updateAction(Request $request, $id)
{
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('commune', 'back', 'edit')) {
    return $access;
    }
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('CommuneBundle:Commune')->find($id);

    if (!$entity) {
    throw $this->createNotFoundException('Unable to find Commune entity.');
    }

    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
    try {
    $em = $this->getDoctrine()->getManager();
    $em->flush();
    $this->get('session')->getFlashBag()->add('success', 'crud.commune.msg.success.update');
    } catch(\Doctrine\DBAL\DBALException $e) {
    $this->get('session')->getFlashBag()->add('danger', 'crud.commune.msg.error.dbal.update');
    $this->get('session')->getFlashBag()->add('danger', $e->getMessage());

    }

    return $this->redirect($this->generateUrl('commune_edit', array('id' => $id)));
    }

            return $this->render('CommuneBundle:Commune:edit.html.twig', array(
        'entity'      => $entity,
        'edit_form'   => $editForm->createView(),
        ));
    }
/**
    * Deletes a Commune entity.
*
    */
    public function deleteAction(Request $request, $id)
{
    $user = $this->getUser();
    if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('commune', 'back', 'delete')) {
        return $access;
    }
    $em = $this->getDoctrine()->getManager();
    $entity = $em->getRepository('CommuneBundle:Commune')->find($id);

    if (!$entity) {
    throw $this->createNotFoundException('Unable to find Commune entity.');
    }
    try {
    $em = $this->getDoctrine()->getManager();
    $em->remove($entity);
    $em->flush();
    $this->get('session')->getFlashBag()->add('success', 'crud.commune.msg.success.delete');
    } catch(\Doctrine\DBAL\DBALException $e) {
    $this->get('session')->getFlashBag()->add('danger', 'crud.commune.msg.error.dbal.delete');
    $this->get('session')->getFlashBag()->add('danger', $e->getMessage());

    }

    return $this->redirect($this->generateUrl('commune'));
}


}
