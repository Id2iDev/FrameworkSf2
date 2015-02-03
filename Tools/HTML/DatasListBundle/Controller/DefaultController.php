<?php

namespace Id2i\Tools\HTML\DatasListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DataListBundle:Default:index.html.twig', array('name' => $name));
    }
}
