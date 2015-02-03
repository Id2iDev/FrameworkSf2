<?php

namespace Id2i\Core\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Document
 *
 * @ORM\Table("media")
 * @ORM\Entity(repositoryClass="Id2i\Core\MediaBundle\Entity\MediaRepository")
 * @Gedmo\Loggable
 */
class Media
{

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    private $uniqid;
    /**
     * @var boolean
     * @Gedmo\Versioned
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = false;
    /**
     * @var \Id2i\Core\UserBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Id2i\Core\UserBundle\Entity\User")
     * @Gedmo\Versioned
     * @ORM\JoinColumn(name="owner", referencedColumnName="id")
     */
    private $owner;
    /**
     * @ORM\ManyToMany(targetEntity="\Id2i\Core\NodeBundle\Entity\Node")
     * @ORM\JoinTable(name="media_node",
     *      joinColumns={@ORM\JoinColumn(name="node_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id")}
     *      )
     **/
    private $nodes;
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="text",nullable=true)
     */
    private $path;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime",nullable=true)
     */
    private $createdAt;
    /**
     * @var integer
     *
     * @ORM\Column(name="version", type="integer",nullable=true)
     */
    private $version;
    /**
     * @var string
     *
     * @ORM\Column(name="original_name", type="text",nullable=true)
     */
    private $originalName;
    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=10,nullable=true)
     */
    private $extension;
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255,nullable=true)
     */
    private $type;
    /**
     * @ORM\OneToOne(targetEntity="\Id2i\Core\MediaBundle\Entity\MediaMetaData", mappedBy="media")
     */
    private $meta;
    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text",nullable=true,nullable=true)
     */
    private $commentaire;
    /**
     * @var decimal
     *
     * @ORM\Column(name="note_moyenne", type="decimal", precision=10, scale=2)
     */
    private $noteMoyenne = 0;

    public function __construct()
    {
        $this->nodes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return int
     */
    public function getUniqid()
    {
        return $this->uniqid;
    }

    /**
     * @param int $uniqid
     */
    public function setUniqid($uniqid)
    {
        $this->uniqid = $uniqid;
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
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Media
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Media
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set version
     *
     * @param integer $version
     *
     * @return Media
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get originalName
     *
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Set originalName
     *
     * @param string $originalName
     *
     * @return Media
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return Media
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

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
     * Set type
     *
     * @param string $type
     *
     * @return Media
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Media
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__ . '/../../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/medias' . ($this->owner != null ? "/" . $this->owner->getId() : "") . "/" . $this->version;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    public function upload()
    {
        // la propriété « file » peut être vide si le champ n'est pas requis
        if (null === $this->file) {
            return;
        }

        if (empty($this->uniqid)) {
            $this->uniqid = uniqid('media_');
        }
        if (empty($this->version)) {
            $this->version = 1;
        } else {
            $this->version += 1;
        }


        $this->extension = $this->getOriginalExtension($this->file->getClientOriginalName());
        $this->path = $this->getUploadDir() . '/' . $this->uniqid . "." . $this->extension;
        $this->createdAt = new \DateTime();
        $this->originalName = $this->file->getClientOriginalName();
        $this->type = $this->file->getMimeType();


        $this->file->move($this->getUploadRootDir(), $this->uniqid . "." . $this->extension);

        $this->file = null;
    }

    private function getOriginalExtension($name)
    {

        $pos = strrpos($name, '.');
        $extension = false === $pos ? $name : substr($name, $pos + 1);

        return $extension;
    }

//    public function resize($tailles){
//        foreach($tailles AS $size){
//            $path = $this->getUploadDir() . '/' ."size_".$size['width']."_".$size['heigth'] .'/' . $this->uniqid . "." . $this->extension;
//
//
//
//
//            $this->addTailles($path);
//        }
//    }
    /**
     * Get owner
     *
     * @return \Id2i\Core\UserBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set owner
     *
     * @param \Id2i\Core\UserBundle\Entity\User $owner
     *
     * @return Media
     */
    public function setOwner(\Id2i\Core\UserBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Add nodes
     *
     * @param \Id2i\Core\NodeBundle\Entity\Node $nodes
     *
     * @return Media
     */
    public function addNode(\Id2i\Core\NodeBundle\Entity\Node $nodes)
    {
        $this->nodes[] = $nodes;

        return $this;
    }

    /**
     * Remove nodes
     *
     * @param \Id2i\Core\NodeBundle\Entity\Node $nodes
     */
    public function removeNode(\Id2i\Core\NodeBundle\Entity\Node $nodes)
    {
        $this->nodes->removeElement($nodes);
    }

    /**
     * Get nodes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * Get meta
     *
     * @return \Id2i\Core\MediaBundle\Entity\MediaMetaData
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Set meta
     *
     * @param \Id2i\Core\MediaBundle\Entity\MediaMetaData $meta
     *
     * @return Media
     */
    public function setMeta(\Id2i\Core\MediaBundle\Entity\MediaMetaData $meta = null)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Set noteMoyenne
     *
     * @param string $noteMoyenne
     * @return Media
     */
    public function setNoteMoyenne($noteMoyenne)
    {
        $this->noteMoyenne = $noteMoyenne;

        return $this;
    }

    /**
     * Get noteMoyenne
     *
     * @return string 
     */
    public function getNoteMoyenne()
    {
        return $this->noteMoyenne;
    }
}
