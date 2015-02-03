<?php

namespace Id2i\Core\PlacementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function linksAction($name)
    {
        return $this->render('PlacementBundle:Default:index.html.twig', array('name' => $name));
    }
}
