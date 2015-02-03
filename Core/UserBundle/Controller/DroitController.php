<?php

namespace Id2i\Core\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Id2i\Core\UserBundle\Entity\Droit;
use Id2i\Core\UserBundle\Form\DroitType;

/**
 * Droit controller.
 *
 */
class DroitController extends Controller
{
    /**
     * Lists all Droit entities.
     *
     */
    public function indexAction()
    {
        $this->updateDroits();
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UserBundle:Droit')->findAll();
        $groupes = $em->getRepository('UserBundle:Group')->findAll();
        $droits = array();
        foreach ($entities AS $d) {
            $droits[$d->getGroupe()->getId()][] = $d;
        }


        return $this->render('UserBundle:Droit:edit.html.twig', array(
            'droits'  => $droits,
            'groupes' => $groupes,
        ));
    }

    /**
     * Mise a jour des droits
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function updateDroits()
    {
        $params = $this->container->getParameterBag()->all();
        foreach ($params AS $key => $droits) {
            if (preg_match("#^droits.#", $key)) {
                $this->saveDroit($droits, $key);
            }
        }

    }

    private function saveDroit($droits, $bundle)
    {

        $em = $this->getDoctrine()->getManager();
        $groupes = $em->getRepository('UserBundle:Group')->findAll();
        $droitRep = $em->getRepository('UserBundle:Droit');
        $change = false;

        foreach ($groupes AS $groupe) {
            $droit = $droitRep->findOneBy(array('bundle' => $bundle, 'groupe' => $groupe));
            if (null == $droit) {
                $droit = new Droit();
                $droit->setBundle($bundle);
                $droit->setGroupe($groupe);
            }
            list($droitsTmp, $different) = $this->addOrDeleteDroits($droit->getDroits(), $droits);
            if ($different) {
                $droit->setDroits($droitsTmp);
                $em->persist($droit);
                $change = true;
            }
        }
        if ($change) {
            $em->flush();

        }
    }

    public function addOrDeleteDroits($droitsAGarder, $updatedDroits)
    {
        $modified = false;
        if($droitsAGarder != null) {
            foreach ($droitsAGarder AS $key_type => $val_type) {
                foreach ($val_type AS $key => $val) {
                    if (isset($updatedDroits[$key_type][$key])) {
                        $nouveauxDroits[$key_type][$key] = $val;
                        unset($updatedDroits[$key_type][$key]);
                    } else {
                        $modified = true;
                    }
                }
            }
        }
        foreach ($updatedDroits AS $key_type => $val_type) {
            foreach ($val_type AS $key => $val) {
                $nouveauxDroits[$key_type][$key] = $val;
                $modified = true;
            }
        }

        return array(array_merge($updatedDroits, $nouveauxDroits), $modified);
    }

    /**
     * Creates a new Droit entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Droit();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('superadmin_droits'));
        }

        return $this->render('UserBundle:Droit:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Droit entity.
     *
     * @param Droit $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Droit $entity)
    {
        $form = $this->createForm(new DroitType(), $entity, array(
            'action' => $this->generateUrl('superadmin_droits_create'),
            'method' => 'POST',
        ));
        $translator = $this->get('translator');
        $form->add('submit', 'submit', array('label' => $translator->trans('crud.droit.btn.create'), 'attr' => array("class" => "btn-success pull-right ")));

        return $form;
    }

    /**
     * Displays a form to create a new Droit entity.
     *
     */
    public function newAction()
    {
        $entity = new Droit();
        $form = $this->createCreateForm($entity);

        return $this->render('UserBundle:Droit:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Droit entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UserBundle:Droit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Droit entity.');
        }


        return $this->render('UserBundle:Droit:show.html.twig', array(
            'entity' => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Droit entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UserBundle:Droit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Droit entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('UserBundle:Droit:edit.html.twig', array(
            'entity'    => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Droit entity.
     *
     * @param Droit $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Droit $entity)
    {
        $form = $this->createForm(new DroitType(), $entity, array(
            'action' => $this->generateUrl('superadmin_droits_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $translator = $this->get('translator');
        $form->add('submit', 'submit', array('label' => $translator->trans('crud.droit.btn.update'), 'attr' => array("class" => "btn-info pull-right ")));


        return $form;
    }

    /**
     * Edits an existing Droit entity.
     *
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UserBundle:Droit');


        if ($request->getMethod() == 'POST') {
            $post = $request->request->get('droits');
            foreach ($post AS $groupe_id => $groupe) {
                foreach ($groupe AS $bundle_name => $values) {
                    $droit = $entity->findOneBy(array('groupe' => $groupe_id, 'bundle' => $bundle_name));
                    $droits = $droit->getDroits();
                    foreach ($droits AS $tag2 => $child) {
                        foreach ($child AS $tag3 => $value) {
                            $droits[$tag2][$tag3] = isset($post[$groupe_id][$bundle_name][$tag2][$tag3]) ? true : false;
                        }
                    }
                    $droit->setDroits($droits);
                    $em->persist($droit);
                    $em->flush();
                }
            }


        }


        return $this->redirect($this->generateUrl('superadmin_droits'));


    }

    /**
     * Deletes a Droit entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UserBundle:Droit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Droit entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('superadmin_droits'));
    }


}
