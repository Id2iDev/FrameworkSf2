<?php

namespace Id2i\Core\PlacementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Placement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Id2i\Core\PlacementBundle\Entity\PlacementRepository")
 */
class Placement
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
     *
     * @ORM\Column(name="libelle", type="string", length=25)
     */
    private $libelle;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="type", type="object")
     */
    private $type;


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
     * Set libelle
     *
     * @param string $libelle
     * @return Placement
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
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
     * Set type
     *
     * @param \stdClass $type
     * @return Placement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \stdClass 
     */
    public function getType()
    {
        return $this->type;
    }
}
