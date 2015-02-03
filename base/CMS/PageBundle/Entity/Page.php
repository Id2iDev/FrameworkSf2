<?php

namespace Id2i\CMS\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Page
 *
 * @ORM\Table("page")
 * @ORM\Entity(repositoryClass="Id2i\CMS\PageBundle\Entity\PageRepository")
 * @Gedmo\Loggable
 */
class Page
{
    /**
     * @ORM\ManyToMany(targetEntity="Id2i\Core\UserBundle\Entity\Group")
     * @ORM\JoinTable(name="page_group",
     *      joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
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
     * @ORM\Column(name="title", type="text")
     */
    private $title;
    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="resume", type="text")
     */
    private $resume;

    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;
    /**
     * @var \DateTime
     * @Gedmo\Versioned
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;
    /**
     * @var \DateTime
     * @Gedmo\Versioned
     * @ORM\Column(name="publied_at", type="datetime")
     */
    private $publiedAt;
    /**
     * @var \DateTime
     * @Gedmo\Versioned
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    /**
     * @var \Id2i\Core\UserBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Id2i\Core\UserBundle\Entity\User")
     * @Gedmo\Versioned
     * @ORM\JoinColumn(name="auteur", referencedColumnName="id")
     */
    private $auteur;
    /**
     *
     * @ORM\ManyToOne(targetEntity="PageEtat")
     * @Gedmo\Versioned
     * @ORM\JoinColumn(name="etat", referencedColumnName="id")
     **/
    private $etat;

    /**
     * @ORM\ManyToMany(targetEntity="Id2i\Core\NodeBundle\Entity\Node")
     * @ORM\JoinTable(name="page_node",
     *      joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="node_id", referencedColumnName="id")}
     * )
     */
    private $node;
    /**
     * @var boolean
     * @Gedmo\Versioned
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;
    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="seo_title", type="string", length=75, nullable=true)
     */
    private $seoTitle;
    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="seo_description", type="string", length=200, nullable=true)
     */
    private $seoDescription;
    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="seo_keywords", type="string", length=255, nullable=true)
     */
    private $seoKeywords;
    /**
     * @var string
     * @Gedmo\Versioned
     * @ORM\Column(name="seo_url", type="string", length=75, nullable=true)
     */
    private $seoUrl;

   

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->node = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set resume
     *
     * @param string $resume
     * @return Page
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string 
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Page
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Page
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

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
     * Set publiedAt
     *
     * @param \DateTime $publiedAt
     * @return Page
     */
    public function setPubliedAt($publiedAt)
    {
        $this->publiedAt = $publiedAt;

        return $this;
    }

    /**
     * Get publiedAt
     *
     * @return \DateTime 
     */
    public function getPubliedAt()
    {
        return $this->publiedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Page
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Page
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
     * Set seoTitle
     *
     * @param string $seoTitle
     * @return Page
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seoTitle = $seoTitle;

        return $this;
    }

    /**
     * Get seoTitle
     *
     * @return string 
     */
    public function getSeoTitle()
    {
        return $this->seoTitle;
    }

    /**
     * Set seoDescription
     *
     * @param string $seoDescription
     * @return Page
     */
    public function setSeoDescription($seoDescription)
    {
        $this->seoDescription = $seoDescription;

        return $this;
    }

    /**
     * Get seoDescription
     *
     * @return string 
     */
    public function getSeoDescription()
    {
        return $this->seoDescription;
    }

    /**
     * Set seoKeywords
     *
     * @param string $seoKeywords
     * @return Page
     */
    public function setSeoKeywords($seoKeywords)
    {
        $this->seoKeywords = $seoKeywords;

        return $this;
    }

    /**
     * Get seoKeywords
     *
     * @return string 
     */
    public function getSeoKeywords()
    {
        return $this->seoKeywords;
    }

    /**
     * Set seoUrl
     *
     * @param string $seoUrl
     * @return Page
     */
    public function setSeoUrl($seoUrl)
    {
        $this->seoUrl = $seoUrl;

        return $this;
    }

    /**
     * Get seoUrl
     *
     * @return string 
     */
    public function getSeoUrl()
    {
        return $this->seoUrl;
    }

    /**
     * Add groups
     *
     * @param \Id2i\Core\UserBundle\Entity\Group $groups
     * @return Page
     */
    public function addGroup(\Id2i\Core\UserBundle\Entity\Group $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Id2i\Core\UserBundle\Entity\Group $groups
     */
    public function removeGroup(\Id2i\Core\UserBundle\Entity\Group $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set auteur
     *
     * @param \Id2i\Core\UserBundle\Entity\User $auteur
     * @return Page
     */
    public function setAuteur(\Id2i\Core\UserBundle\Entity\User $auteur = null)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \Id2i\Core\UserBundle\Entity\User 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set etat
     *
     * @param \Id2i\CMS\PageBundle\Entity\PageEtat $etat
     * @return Page
     */
    public function setEtat(\Id2i\CMS\PageBundle\Entity\PageEtat $etat = null)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return \Id2i\CMS\PageBundle\Entity\PageEtat 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Add node
     *
     * @param \Id2i\Core\NodeBundle\Entity\Node $node
     * @return Page
     */
    public function addNode(\Id2i\Core\NodeBundle\Entity\Node $node)
    {
        $this->node[] = $node;

        return $this;
    }

    /**
     * Remove node
     *
     * @param \Id2i\Core\NodeBundle\Entity\Node $node
     */
    public function removeNode(\Id2i\Core\NodeBundle\Entity\Node $node)
    {
        $this->node->removeElement($node);
    }

    /**
     * Get node
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNode()
    {
        return $this->node;
    }
}
