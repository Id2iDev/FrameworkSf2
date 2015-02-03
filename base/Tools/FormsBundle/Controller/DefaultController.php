<?php

namespace Id2i\Tools\FormsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FormsBundle:Default:index.html.twig', array('name' => $name));
    }
}
