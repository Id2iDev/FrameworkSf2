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

}
