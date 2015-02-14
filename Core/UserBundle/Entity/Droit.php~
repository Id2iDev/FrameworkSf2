<?php

namespace Id2i\Core\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Droit
 *
 * @ORM\Table("droit")
 * @ORM\Entity(repositoryClass="Id2i\Core\UserBundle\Entity\DroitRepository")
 */
class Droit
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Id2i\Core\UserBundle\Entity\Group", inversedBy="droits")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $groupe;
    /**
     * @var string
     *
     * @ORM\Column(name="bundle", type="string",length=255)
     */
    private $bundle;
    /**
     * @var array
     *
     * @ORM\Column(name="droits", type="array")
     */
    private $droits;
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
     * Set droits
     *
     * @param array $droits
     * @return Droit
     */
    public function setDroits($droits)
    {
        $this->droits = $droits;

        return $this;
    }

    /**
     * Get droits
     *
     * @return array 
     */
    public function getDroits()
    {
        return $this->droits;
    }

    /**
     * Set groupe
     *
     * @param \Id2i\Core\UserBundle\Entity\Group $groupe
     * @return Droit
     */
    public function setGroupe(\Id2i\Core\UserBundle\Entity\Group $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \Id2i\Core\UserBundle\Entity\Group 
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set bundle
     *
     * @param string $bundle
     * @return Droit
     */
    public function setBundle($bundle)
    {
        $this->bundle = $bundle;

        return $this;
    }

    /**
     * Get bundle
     *
     * @return string 
     */
    public function getBundle()
    {
        return $this->bundle;
    }
}
