<?php

namespace Id2i\Core\MediaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Id2i\Core\MediaBundle\Entity\Media;
use Id2i\Core\MediaBundle\Form\MediaType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Media controller.
 *
 */
class MediaController extends Controller
{

    /**
     * Lists all Media entities.
     *
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $access = $this->get('id2i_secure')->setUser($user)->can('media','back','read_his');
        $access2 = $this->get('id2i_secure')->setUser($user)->can('media','back','read_all');
        $em = $this->getDoctrine()->getManager();

        if(true !== $access && true !== $access2 ){
            return $access;
        }

        if(true == $access){
            $entities = $em->getRepository('MediaBundle:Media')->findByOwner($user);
        }
        if(true == $access2){
            $entities = $em->getRepository('MediaBundle:Media')->findAll();
        }

//        return $this->container->get('media.choice.tmpl')->setEntities($entities)->generate();
        return $this->render('MediaBundle:Media:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Media entity.
     *
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        if(true !== $access = $this->get('id2i_secure')->setUser($user)->can('media','back','create')){
            return $access;
        }
        $entity = new Media();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->upload();
            $entity->setOwner($user);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('superadmin_media'));
        }

        return $this->render('MediaBundle:Media:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Media entity.
     *
     * @param Media $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Media $entity)
    {
        $form = $this->createForm(new MediaType(), $entity, array(
            'action' => $this->generateUrl('superadmin_media_create'),
            'method' => 'POST',
        ));
        $translator = $this->get('translator');
        $form->add('submit', 'submit', array('label' => $translator->trans('crud.media.btn.create'),'attr'=>array("class"=>"btn-success pull-right ")));

        return $form;
    }

    /**
     * Displays a form to create a new Media entity.
     *
     */
    public function newAction()
    {
        $entity = new Media();
        $form   = $this->createCreateForm($entity);

        return $this->render('MediaBundle:Media:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Media entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MediaBundle:Media')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Media entity.');
        }

        return $this->render('MediaBundle:Media:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Media entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MediaBundle:Media')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Media entity.');
        }
        $editForm = $this->createEditForm($entity);

        return $this->render('MediaBundle:Media:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Media entity.
    *
    * @param Media $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Media $entity)
    {
        $form = $this->createForm(new MediaType(), $entity, array(
            'action' => $this->generateUrl('superadmin_media_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $translator = $this->get('translator');
        $form->add('submit', 'submit', array('label' => $translator->trans('crud.media.btn.update'),'attr'=>array("class"=>"btn-info pull-right ")));


        return $form;
    }
    /**
     * Edits an existing Media entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MediaBundle:Media')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Media entity.');
        }
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $entity->upload();
            $em->flush();
            return $this->redirect($this->generateUrl('superadmin_media_edit', array('id' => $id)));
        }

        return $this->render('MediaBundle:Media:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Media entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MediaBundle:Media')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Media entity.');
        }
        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('superadmin_media'));
    }

    public function downloadAction($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MediaBundle:Media')->find($id);
//        $entity = new Media();

        $size = filesize($entity->getPath());

        header('Content-Description: File Transfer');
        header('Content-Type: image/'.$entity->getExtension());
        header('Content-Disposition: attachment; filename="'.$entity->getMeta()->getName().'.'.$entity->getExtension().'"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . $size);
        readfile($entity->getPath());

        return new Response('', 200);


    }

}
