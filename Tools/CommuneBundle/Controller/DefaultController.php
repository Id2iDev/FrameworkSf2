<?php

namespace Id2i\Tools\CommuneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CommuneBundle:Default:index.html.twig', array('name' => $name));
    }
}
