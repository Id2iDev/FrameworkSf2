<?php

namespace Id2i\Core\UserBundle\Entity;

use FOS\UserBundle\Entity\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 *
 * @ORM\Table("groupe")
 * @ORM\Entity(repositoryClass="Id2i\Core\UserBundle\Entity\GroupRepository")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\OneToMany(targetEntity="Id2i\Core\UserBundle\Entity\Droit", mappedBy="groupe")
     */
    protected $droits;
    /**
     * @ORM\ManyToMany(targetEntity="Id2i\Core\MultiSiteBundle\Entity\Site")
     * @ORM\JoinTable(name="groupe_site",
     *      joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="site_id", referencedColumnName="id")}
     * )
     */
    protected $sites;
    /**
     * var boolean
     * @ORM\Column(name="basic", type="boolean",nullable = true)
     */
    private $basic;

    /**
     * Constructor
     */
    public function __construct($name, $roles = array())
    {
        parent::__construct($name, $roles);
        $this->droits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getBasic()
    {
        return $this->basic;
    }

    /**
     * @param mixed $basic
     */
    public function setBasic($basic)
    {
        $this->basic = $basic;
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
     * Add droits
     *
     * @param \Id2i\Core\UserBundle\Entity\Droit $droits
     *
     * @return Group
     */
    public function addDroit(\Id2i\Core\UserBundle\Entity\Droit $droits)
    {
        $this->droits[] = $droits;

        return $this;
    }

    /**
     * Remove droits
     *
     * @param \Id2i\Core\UserBundle\Entity\Droit $droits
     */
    public function removeDroit(\Id2i\Core\UserBundle\Entity\Droit $droits)
    {
        $this->droits->removeElement($droits);
    }

    /**
     * Get droits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDroits()
    {
        return $this->droits;
    }

    /**
     * Add sites
     *
     * @param \Id2i\Core\MultiSiteBundle\Entity\Site $sites
     * @return Group
     */
    public function addSite(\Id2i\Core\MultiSiteBundle\Entity\Site $sites)
    {
        $this->sites[] = $sites;

        return $this;
    }

    /**
     * Remove sites
     *
     * @param \Id2i\Core\MultiSiteBundle\Entity\Site $sites
     */
    public function removeSite(\Id2i\Core\MultiSiteBundle\Entity\Site $sites)
    {
        $this->sites->removeElement($sites);
    }

    /**
     * Get sites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSites()
    {
        return $this->sites;
    }
}
