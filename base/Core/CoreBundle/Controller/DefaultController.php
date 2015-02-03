<?php

namespace Id2i\Core\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoreBundle:Default:index.html.twig', array());
    }

    public function LoginBoxAction(){
        $csrfToken = $this->has('form.csrf_provider')
            ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;

        return $this->render('CoreBundle:Partial:loginBox.html.twig', array(
            'csrf_token' => $csrfToken,
        ));
    }
}
