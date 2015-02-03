<?php

namespace Id2i\Tools\PubliciteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Id2i\Tools\PubliciteBundle\Entity\Publicite;
use Id2i\Tools\PubliciteBundle\Form\PubliciteType;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * Publicite controller.
 *
 */
class FrontController extends Controller
{

    /**
     * Recupere une publicité en fonction de l'emplacement
     *
     */
    public function placeAction($place)
    {
        $em = $this->getDoctrine()->getManager();
        $place = $em->getRepository("NodeBundle:Node")->getPlacement($place);
        $publicite = $em->getRepository("PubliciteBundle:Publicite")->findOneByNode($place);

        return $this->render("PubliciteBundle:Front:draw.html.twig",array('publicite'=>$publicite));
    }



}
