<?php

namespace Id2i\Core\NodeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Id2i\Core\NodeBundle\Entity\Node;
use Id2i\Core\NodeBundle\Form\NodeType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Node controller.
 *
 */
class NodeController extends Controller
{

    /**
     * Lists all Node entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $access1 = $this->get('id2i_secure')->setUser($user)->can('node', 'back', 'read_all');
        $access2 = $this->get('id2i_secure')->setUser($user)->can('node', 'back', 'read_domain');
        if (true !== $access1 && true !== $access2) {
            return $access1;
        }
        $repo = $em->getRepository('NodeBundle:Node');
        $entity = null;
        if (true === $access1) {
            $new = false;
//            $entities = $repo->findBy(array('lvl' => 0), array("parent" => "ASC", "lvl" => "ASC", "lft" => "ASC"));

        } else {

            $domaine = $em->getRepository("MultiSiteBundle:Site")->findOneBy(array("domaine" => $_SERVER['HTTP_HOST']));
            if (!$domaine) {
                return new Response("Il faut commencer par ajouter le site correspondant au domaine : " . $_SERVER['HTTP_HOST'], 404);
            }
            $root = $domaine->getNode();
            $entity = $repo->findOneBy(array('id' => $root, 'lvl' => 0, 'deleted' => false), array("parent" => "ASC", "lvl" => "ASC", "lft" => "ASC"));
            $new = $root->getId();

        }
        $controller = $this;
        $tree = '<div class="tree well">' .
            ($new !== false ? '<ul><li><span>' .
                $entity->getTitle() .
                '</span> <a href="' .
                $controller->generateUrl("superadmin_node_new_child", array('id' => $entity->getId())).
                '" class="btn btn-success btn-xs fa fa-plus"></a>' : ''
            )  .
            $repo->childrenHierarchy(
                $entity,
                false,
                array(
                    'decorate'      => true,
                    'rootOpen'      => "<ul>",
                    'rootClose'     => "</ul>",
                    'childOpen'     => '<li>',
                    'childClose'    => '</li>',
                    'nodeDecorator' => function ($node) use (&$controller) {

                        return '<span><i class="fa "></i> ' . $node['title'] . '</span>'.( $node['bloquer'] == false ?
                            '<a href="' . $controller->generateUrl("superadmin_node_new_child", array('id' => $node['id'])) . '"
                            class="btn btn-success btn-xs fa fa-plus"></a>
                            <a href="' . $controller->generateUrl("superadmin_node_edit", array('id' => $node['id'])) . '"
                            class="btn btn-primary btn-xs fa fa-edit"></a>
                        <a href="' . $controller->generateUrl("superadmin_node_delete", array('id' => $node['id'])) . '"
                            class="btn btn-danger btn-xs confirm-delete fa fa-trash"></a>':"");

                    }
                )) . ($new !== false ? '</li></ul>' : '') . '</div>';


//        \Doctrine\Common\Util\Debug::dump($entities[0]);

        return $this->render('NodeBundle:Node:index.html.twig', array(
//            'entities'     => $entities,
            'arborescence' => $tree,
            'new'          => $new,
        ));
    }

    /**
     * Creates a new Node entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Node();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'crud.node.msg.success.create');
            } catch (\Doctrine\DBAL\DBALException $e) {
                $this->get('session')->getFlashBag()->add('danger', 'crud.node.msg.error.dbal.create : ' . $e->getMessage());
            }

            return $this->redirect($this->generateUrl('admin_node'));
        }

        return $this->render('NodeBundle:Node:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Node entity.
     *
     * @param Node $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Node $entity)
    {
        $form = $this->createForm(new NodeType(), $entity, array(
            'action' => $this->generateUrl('superadmin_node_create'),
            'method' => 'POST',
        ));
        $translator = $this->get('translator');
        $form->add('submit', 'submit', array('label' => $translator->trans('crud.node.btn.create'), 'attr' => array("class" => "btn-success pull-right ")));

        return $form;
    }

    /**
     * Displays a form to create a new Node entity.
     *
     */
    public function newAction()
    {
        $entity = new Node();
        $form = $this->createCreateForm($entity);

        return $this->render('NodeBundle:Node:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Node entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NodeBundle:Node')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Node entity.');
        }


        return $this->render('NodeBundle:Node:show.html.twig', array(
            'entity' => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Node entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NodeBundle:Node')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Node entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('NodeBundle:Node:edit.html.twig', array(
            'entity'    => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Node entity.
     *
     * @param Node $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Node $entity)
    {
        $form = $this->createForm(new NodeType(), $entity, array(
            'action' => $this->generateUrl('superadmin_node_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $translator = $this->get('translator');
        $form->add('submit', 'submit', array('label' => $translator->trans('crud.node.btn.update'), 'attr' => array("class" => "btn-info pull-right ")));


        return $form;
    }

    /**
     * Edits an existing Node entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NodeBundle:Node')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Node entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
//        echo "<pre>";
//        \Doctrine\Common\Util\Debug::dump($request->request->get('id2i_core_nodebundle_node'));
//        exit();
        if ($editForm->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'crud.node.msg.success.update');
            } catch (\Doctrine\DBAL\DBALException $e) {
                $this->get('session')->getFlashBag()->add('danger', 'crud.node.msg.error.dbal.update : ' . $e->getMessage());
            }

            return $this->redirect($this->generateUrl('superadmin_node'));
        }

        return $this->render('NodeBundle:Node:edit.html.twig', array(
            'entity'    => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Node entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NodeBundle:Node')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Node entity.');
        }
        try {
            $em = $this->getDoctrine()->getManager();
//            $entity->setDeleted(true);
            $em->remove($entity);
//            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'crud.node.msg.success.delete');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $this->get('session')->getFlashBag()->add('danger', 'crud.node.msg.error.dbal.delete : ' . $e->getMessage());
        }

        return $this->redirect($this->generateUrl('superadmin_node'));
    }

    public function newChildAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NodeBundle:Node')->find($id);

        $new = new Node();
        $new->setTitle("Nouvel élément");
        $new->setParent($entity);

        $em->persist($new);
        $em->flush();

        return $this->redirect($this->generateUrl('superadmin_node'));

    }


}
