<?php
/**
 * User: p.pobelle
 * Date: 19/12/2014
 * Time: 10:56
 */

namespace Id2i\Core\CoreBundle\Twig;


class Id2iMultiSiteExtension extends \Twig_Extension
{

    private $_em = null;
    private $domaine = null;

    public function __construct($em)
    {
        if(isset($_SERVER['HTTP_HOST'])){
            $this->domaine = $_SERVER['HTTP_HOST'];
        }else{
            $this->domaine = 'localhost';
        }
        $this->_em = $em;

    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('changeTheme', array($this, 'getTheme')),
        );
    }

    public function getTheme($defaultTheme)
    {
        echo "On change de theme ".$this->domaine;
        $theme = explode(':',$defaultTheme);

        $domaine = $this->_em->getRepository("MultiSiteBundle:Site")->findOneBy(array("domaine" => $this->domaine));
        if (!$domaine) {
            return $defaultTheme;
        }
        if($domaine->getTheme() !== null && $domaine->getTheme()!= ''){
            $theme[1] = $domaine->getTheme();
        }
        return implode(':',$theme);
    }

    public function getNode($domaine = null)
    {
        if ($domaine == null) {
            $domaine = $this->domaine;
        }

        $entity = $this->_em->getRepository("MultiSiteBundle:Site")->findOneBy(array("domaine" => $domaine));
        if (!$entity) {
            return null;
        }

        return $entity->getNode();
    }


    public function getName()
    {
        return 'id2i_multisite';
    }
}