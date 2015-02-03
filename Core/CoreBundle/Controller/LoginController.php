<?php

namespace Id2i\Core\CoreBundle\Controller;

use FOS\UserBundle\Model\UserInterface;

use FOS\UserBundle\Controller\RegistrationController as BaseController;

use Symfony\Component\HttpFoundation\Response;

class LoginController extends BaseController
{
    protected function authenticateUser(UserInterface $user, Response $response)
    {
        parent::authenticateUser($user, $response);
    }


}