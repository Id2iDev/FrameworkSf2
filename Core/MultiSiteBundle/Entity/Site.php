<?php

namespace Id2i\Core\MultiSiteBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 *
 * @ORM\Table("site")
 * @ORM\Entity(repositoryClass="Id2i\Core\MultiSiteBundle\Entity\SiteRepository")
 * @Gedmo\Loggable
 */
class Site
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="libelle", type="string", length=50)
     */
    private $libelle;

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="domaine", type="string", length=150)
     */
    private $domaine;
    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="theme", type="string", length=150,nullable=true)
     */
    private $theme;
    /**
     * @var boolean
     * @Gedmo\Versioned
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;
    /**
     * @var \Id2i\Core\NodeBundle\Entity\Node
     * @ORM\ManyToOne(targetEntity="\Id2i\Core\NodeBundle\Entity\Node")
     * @Gedmo\Versioned
     * @ORM\JoinColumn(name="node", referencedColumnName="id")
     */
    private $node;
    /**
     * @var boolean
     * @Gedmo\Versioned
     * @ORM\Column(name="maintenance", type="boolean")
     */
    private $maintenance;

    /**
     * @return \Id2i\Core\NodeBundle\Entity\Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @param \Id2i\Core\NodeBundle\Entity\Node $node
     */
    public function setNode($node)
    {
        $this->node = $node;
    }

    /**
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param string $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Site
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get domaine
     *
     * @return string
     */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
     * Set domaine
     *
     * @param string $domaine
     *
     * @return Site
     */
    public function setDomaine($domaine)
    {
        $this->domaine = $domaine;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Site
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get maintenance
     *
     * @return boolean
     */
    public function getMaintenance()
    {
        return $this->maintenance;
    }

    /**
     * Set maintenance
     *
     * @param boolean $maintenance
     *
     * @return Site
     */
    public function setMaintenance($maintenance)
    {
        $this->maintenance = $maintenance;

        return $this;
    }
}
