<?php

namespace Id2i\Ecommerce\DocumentVenteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DocumentVenteBundle:Default:index.html.twig', array('name' => $name));
    }
}
