<?php

namespace Id2i\Tools\PubliciteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PubliciteStatistique
 *
 * @ORM\Table("publicite_statistique")
 * @ORM\Entity(repositoryClass="Id2i\Tools\PubliciteBundle\Entity\PubliciteStatistiqueRepository")
 *
 */
class PubliciteStatistique
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="do_at", type="datetime")
     */
    private $doAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="publicite", type="string", length=255)
     */
    private $publicite;


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
     * Set type
     *
     * @param string $type
     * @return PubliciteStatistique
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set doAt
     *
     * @param \DateTime $doAt
     * @return PubliciteStatistique
     */
    public function setDoAt($doAt)
    {
        $this->doAt = $doAt;

        return $this;
    }

    /**
     * Get doAt
     *
     * @return \DateTime 
     */
    public function getDoAt()
    {
        return $this->doAt;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return PubliciteStatistique
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set publicite
     *
     * @param string $publicite
     * @return PubliciteStatistique
     */
    public function setPublicite($publicite)
    {
        $this->publicite = $publicite;

        return $this;
    }

    /**
     * Get publicite
     *
     * @return string 
     */
    public function getPublicite()
    {
        return $this->publicite;
    }
}
