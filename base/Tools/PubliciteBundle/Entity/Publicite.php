<?php

namespace Id2i\Tools\PubliciteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Publicite
 *
 * @ORM\Table("publicite")
 * @ORM\Entity(repositoryClass="Id2i\Tools\PubliciteBundle\Entity\PubliciteRepository")
 * @Gedmo\Loggable
 */
class Publicite
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
     * @ORM\Column(name="titre", type="text")
     */
    private $titre;

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="url_cible", type="string", length=255, nullable=true)
     */
    private $urlCible;

    /**
     * @ORM\OneToOne(targetEntity="\Id2i\Core\MediaBundle\Entity\Media")
     * @ORM\JoinTable(name="media_publicite",
     *      joinColumns={@ORM\JoinColumn(name="publicite_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=true)}
     *      )
     **/
    private $media;

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="script", type="text", nullable=true)
     */
    private $script;

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="attr_target", type="string", length=255, nullable=true)
     */
    private $attrTarget;

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="attr_title", type="string", length=255, nullable=true)
     */
    private $attrTitle;

    /**
     * @var \Id2i\Core\NodeBundle\Entity\Node
     * @Gedmo\Versioned
     * @ORM\OneToOne(targetEntity="\Id2i\Core\NodeBundle\Entity\Node")
     * @ORM\JoinColumn(name="node_id", referencedColumnName="id", nullable=true)
     */
    private $node;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active = true;




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
     * Set titre
     *
     * @param string $titre
     * @return Publicite
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set urlCible
     *
     * @param string $urlCible
     * @return Publicite
     */
    public function setUrlCible($urlCible)
    {
        $this->urlCible = $urlCible;

        return $this;
    }

    /**
     * Get urlCible
     *
     * @return string 
     */
    public function getUrlCible()
    {
        return $this->urlCible;
    }

    /**
     * Set script
     *
     * @param string $script
     * @return Publicite
     */
    public function setScript($script)
    {
        $this->script = $script;

        return $this;
    }

    /**
     * Get script
     *
     * @return string 
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * Set attrTarget
     *
     * @param string $attrTarget
     * @return Publicite
     */
    public function setAttrTarget($attrTarget)
    {
        $this->attrTarget = $attrTarget;

        return $this;
    }

    /**
     * Get attrTarget
     *
     * @return string 
     */
    public function getAttrTarget()
    {
        return $this->attrTarget;
    }

    /**
     * Set attrTitle
     *
     * @param string $attrTitle
     * @return Publicite
     */
    public function setAttrTitle($attrTitle)
    {
        $this->attrTitle = $attrTitle;

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
     * Set active
     *
     * @param boolean $active
     * @return Publicite
     */
    public function setActive($active)
    {
        $this->active = $active;

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
     * Set media
     *
     * @param \Id2i\Core\MediaBundle\Entity\Media $media
     * @return Publicite
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

    /**
     * Set node
     *
     * @param \Id2i\Core\NodeBundle\Entity\Node $node
     * @return Publicite
     */
    public function setNode(\Id2i\Core\NodeBundle\Entity\Node $node = null)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * Get node
     *
     * @return \Id2i\Core\NodeBundle\Entity\Node 
     */
    public function getNode()
    {
        return $this->node;
    }
}
