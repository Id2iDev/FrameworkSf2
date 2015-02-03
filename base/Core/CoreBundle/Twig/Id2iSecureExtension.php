<?php
/**
 * User: p.pobelle
 * Date: 19/12/2014
 * Time: 10:56
 */

namespace Id2i\Core\CoreBundle\Twig;


class Id2iSecureExtension extends \Twig_Extension
{

    private $container = null;
    private $security = null;

    public function __construct($container, $security)
    {
        $this->container = $container;
        $this->security = $security;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('id2i_secure_can', array($this, 'can')),
        );
    }

    public function can($user, $bundle, $tag2, $tag3)
    {
        if (true !== $access = $this->container->get('id2i_secure')->setUser($user)->can($bundle, $tag2, $tag3)) {
            return false;
        }

        return true;
    }

    public function getName()
    {
        return 'id2i_secure';
    }
}