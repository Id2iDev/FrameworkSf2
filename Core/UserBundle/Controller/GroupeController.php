<?php

namespace Id2i\Core\UserBundle\Controller;

use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Id2i\Core\UserBundle\Entity\User;
use Id2i\Core\UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 */
class GroupeController extends Controller
{


    /**
     * Lists all User entities.
     *
     */
    public function indexAction(Request $request)
    {

        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('groupe', 'back', 'read')) {
            return $access;
        }
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();



        $groupes = $em->getRepository('UserBundle:Group')->findAll();

        return $this->render('UserBundle:User:index.html.twig', array(
            'groupes' => $groupes
        ));
    }

    /**
     * Creates a new User entity.
     *
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('user', 'back', 'new')) {
            return $access;
        }
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $password = $entity->getPassword();
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($entity);

            $entity->setPassword($encoder->encodePassword($password, $entity->getSalt()));
            $entity->setLastLogin(new\DateTime());
            $entity->setRegisterAt(new\DateTime());

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'crud.success.create');
            } catch (\Doctrine\DBAL\DBALException $e) {
                $this->get('session')->getFlashBag()->add('danger', 'crud.error.dbal.create');
            }

            return $this->redirect($this->generateUrl('admin_utilisateurs'));
        }

        return $this->render('UserBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('admin_utilisateurs_create'),
            'method' => 'POST',
        ));
        $translator = $this->get('translator');
        $form->add('submit', 'submit', array('label' => $translator->trans('core.btn.create'), 'attr' => array("class" => "btn-success pull-right ")));
        $form->add('submit_and_mail', 'submit', array('label' => $translator->trans('core.btn.create_and_mail'), 'attr' => array("class" => "btn-success pull-right ")));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    {
        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('user', 'back', 'new')) {
            return $access;
        }
        $entity = new User();
        $form = $this->createCreateForm($entity);

        return $this->render('UserBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function exportCsvAction(Request $request)
    {
        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('user', 'back', 'export_csv')) {
            return $access;
        }
        $em = $this->getDoctrine()->getManager();



        $queryB = $this->getDoctrine()->getManager()->createQueryBuilder()
            ->select('DISTINCT u')
            ->from('UserBundle:User', 'u')
            ->join("u.groups", 'g');
        $session =$request->getSession();
        if ($session->get('user.filter_groups', false) > 0  && $session->get('user.filter_enabled', false) !== false) {
            $groupe = $em->getRepository('UserBundle:Group')->find($session->get('user.filter_groups'));

            $queryB->andWhere('g.id = :group');
            $queryB->setParameter('group', $groupe);
        }
        if ($session->get('user.filter_enabled', 0) >= 0 && $session->get('user.filter_enabled', 0) !== false) {
            $queryB->andWhere('u.enabled = :enabled');
            $queryB->setParameter('enabled', $session->get('user.filter_enabled'));
        }

        $iterableResult = $queryB->getQuery()->iterate();




        $handle = fopen('php://memory', 'r+');
        $header = array();

        fputcsv($handle, array("Identifiant","Email","Actif","Dernière Connexion"), ';');
        while (false !== ($row = $iterableResult->next())) {

            fputcsv($handle, $row[0]->getForCsv(), ';');
            $em->detach($row[0]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return new Response("\xEF\xBB\xBF" . $content, 200, array(
            'Content-Type'        => 'application/force-download',
            'Content-Disposition' => 'attachment; filename="export.csv"'
        ));


    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('user', 'back', 'show')) {
            return $access;
        }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }


        return $this->render('UserBundle:User:show.html.twig', array(
            'entity' => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('user', 'back', 'edit')) {
            return $access;
        }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('UserBundle:User:edit.html.twig', array(
            'entity'    => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $entity)
    {
        $entity->setPassword('');
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('admin_utilisateurs_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $translator = $this->get('translator');
        $form->add('submit', 'submit', array('label' => $translator->trans('core.btn.update'), 'attr' => array("class" => "btn-info pull-right ")));
        $form->add('submit_and_mail', 'submit', array('label' => $translator->trans('core.btn.update_and_mail'), 'attr' => array("class" => "btn-success pull-right top5 ")));


        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('user', 'back', 'edit')) {
            return $access;
        }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UserBundle:User')->find($id);
        $password_old = $entity->getPassword();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $password = $entity->getPassword();


            if ($password != '') {
                $encoder = $this->container->get('security.encoder_factory')->getEncoder($entity);
                $entity->setPassword($encoder->encodePassword($password, $entity->getSalt()));
            } else {
                $entity->setPassword($password_old);
                $password = "***********  Non modifié";
            }

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                if (true) {
                    $site = $em->getRepository("MultiSiteBundle:Site")->findOneByDomaine($_SERVER['HTTP_HOST']);
//                $config = $em->getRepository("MultiSiteBundle:Site")->findOneByDomaine($_SERVER['HTTP_HOST']);

                    $message = \Swift_Message::newInstance()
                        ->setSubject($site->getLibelle() . ' - Mise à jour de votre compte')
                        ->setFrom('send@example.com')
                        ->setTo($entity->getEmail())
                        ->setBody($this->renderView('UserBundle:Email:update.html.twig', array('user' => $entity, "site" => $site, 'update_create' => "mis à jour", "password" => $password, "actif_oui_non" => $entity->isEnabled() ? "Oui" : "Non", "retour_ligne" => "")))
                        ->addPart($this->renderView('UserBundle:Email:update.html.twig', array('user' => $entity, "site" => $site, 'update_create' => "mis à jour", "password" => $password, "actif_oui_non" => $entity->isEnabled() ? "Oui" : "Non", "retour_ligne" => "<br/>")));
                    $this->get('mailer')->send($message);
                }


                $this->get('session')->getFlashBag()->add('success', 'crud.success.update');
            } catch (\Doctrine\DBAL\DBALException $e) {
                $this->get('session')->getFlashBag()->add('danger', 'crud.error.dbal.update');
            }

            return $this->redirect($this->generateUrl('admin_utilisateurs_edit', array('id' => $id)));
        }

        return $this->render('UserBundle:User:edit.html.twig', array(
            'entity'    => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('user', 'back', 'delete')) {
            return $access;
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'crud.success.delete');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $this->get('session')->getFlashBag()->add('danger', 'crud.error.dbal.delete');
        }

        return $this->redirect($this->generateUrl('admin_utilisateurs'));
    }


}
