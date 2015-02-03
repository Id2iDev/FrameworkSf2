<?php
/**
 * User: p.pobelle
 * Date: 22/12/2014
 * Time: 15:18
 */

namespace Id2i\Core\NodeBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Id2i\Core\CoreBundle\Tools\IDocument;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="node")
 * use repository for handy tree functions
 * @ORM\Entity(repositoryClass="Id2i\Core\NodeBundle\Entity\NodeRepository")
 * @Gedmo\Loggable
 */
class Node implements IDocument
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=64)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"},updatable=false, unique=false)
     * @ORM\Column(name="slug",type="string",length=128, unique=false)
     */
    private $slug;
//    /**
//     * @var \Id2i\Core\MediaBundle\Entity\Media
//     * @ORM\ManyToOne(targetEntity="\Id2i\Core\MediaBundle\Entity\Media")
//     * @Gedmo\Versioned
//     * @ORM\JoinColumn(name="image", referencedColumnName="id",nullable = true)
//     */
    /**
     * @ORM\Column(name="image", type="text", nullable = true)
     */
    private $image;
    /**
     * @ORM\Column(name="bloquer", type="boolean", nullable = false)
     */
    private $bloquer = 0;
    /**
     * @ORM\Column(name="icon", type="text", nullable = true)
     */
    private $icon;
    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;
    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;
    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;
    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;
    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Node", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;
    /**
     * @ORM\OneToMany(targetEntity="Node", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getBloquer()
    {
        return $this->bloquer;
    }

    /**
     * @param mixed $bloquer
     */
    public function setBloquer($bloquer)
    {
        $this->bloquer = $bloquer;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIndentedTitle()
    {
        return str_repeat("--", $this->lvl) . " " . $this->title;
    }

    public function getCompletePath()
    {
        $parent = $this;
        $tmp = '';
        while ($parent) {
            $tmp = $parent->getTitle() . '/' . $tmp;
            $parent = $parent->getParent();
        }

        return trim($tmp, '/');
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(Node $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Node
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return Node
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     *
     * @return Node
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     *
     * @return Node
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     *
     * @return Node
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set root
     *
     * @param integer $root
     *
     * @return Node
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Add children
     *
     * @param \Id2i\Core\NodeBundle\Entity\Node $children
     *
     * @return Node
     */
    public function addChild(\Id2i\Core\NodeBundle\Entity\Node $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Id2i\Core\NodeBundle\Entity\Node $children
     */
    public function removeChild(\Id2i\Core\NodeBundle\Entity\Node $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    function getAbsolutePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir().'/'.$this->image;

    }

    function getWebPath()
    {
        return null === $this->image ? null : $this->getUploadDir().'/'.$this->image;
    }

    function getUploadRootDir()
    {
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    function getUploadDir()
    {
        return 'uploads/documents';
    }

    public $file;

    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

        $this->image = $this->getUploadDir()."/".$this->file->getClientOriginalName();

        $this->file = null;
    }
}
