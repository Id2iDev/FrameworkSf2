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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Constructor
     */
    public function __construct($name, $roles = array())
    {
        parent::__construct($name, $roles);
        $this->droits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add droits
     *
     * @param \Id2i\Core\UserBundle\Entity\Droit $droits
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
}
