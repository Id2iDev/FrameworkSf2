<?php

namespace Id2i\Tools\ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ServiceBundle:Default:index.html.twig', array('name' => $name));
    }
}
