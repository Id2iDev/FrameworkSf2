<?php

namespace Id2i\Core\AdminLteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('Resources:views:admin.html.twig', array('name' => $name));
    }
}
