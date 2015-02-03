<?php

namespace Id2i\Core\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * MediaMetaDatas
 *
 * @ORM\Table("media_meta_data")
 * @ORM\Entity(repositoryClass="Id2i\Core\MediaBundle\Entity\MediaMetaDataRepository")
 * @Gedmo\Loggable
 */
class MediaMetaData
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="attr_alt", type="string", length=255, nullable=true)
     */
    private $attrAlt;

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="attr_title", type="string", length=255, nullable=true)
     */
    private $attrTitle;

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="legende", type="text", nullable=true)
     */
    private $legende;
    /**
     * @var \Id2i\Core\MediaBundle\Entity\Media
     * @ORM\OneToOne(targetEntity="\Id2i\Core\MediaBundle\Entity\Media", inversedBy="meta")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     */
    private $media;

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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return MediaMetaDatas
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get attrAlt
     *
     * @return string
     */
    public function getAttrAlt()
    {
        return $this->attrAlt;
    }

    /**
     * Set attrAlt
     *
     * @param string $attrAlt
     *
     * @return MediaMetaDatas
     */
    public function setAttrAlt($attrAlt)
    {
        $this->attrAlt = $attrAlt;

        return $this;
    }

    /**
     * Get attrTitle
     *
     * @return string
     */
    public function getAttrTitle()
    {
        return $this->attrTitle;
    }

    /**
     * Set attrTitle
     *
     * @param string $attrTitle
     *
     * @return MediaMetaDatas
     */
    public function setAttrTitle($attrTitle)
    {
        $this->attrTitle = $attrTitle;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return MediaMetaDatas
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get legende
     *
     * @return string
     */
    public function getLegende()
    {
        return $this->legende;
    }

    /**
     * Set legende
     *
     * @param string $legende
     *
     * @return MediaMetaDatas
     */
    public function setLegende($legende)
    {
        $this->legende = $legende;

        return $this;
    }


    /**
     * Set media
     *
     * @param \Id2i\Core\MediaBundle\Entity\Media $media
     * @return MediaMetaData
     */
    public function setMedia(\Id2i\Core\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Id2i\Core\MediaBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }
}
