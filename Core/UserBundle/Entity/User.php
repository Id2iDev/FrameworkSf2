<?php

namespace Id2i\Core\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User
 *
 * @ORM\Table("utilisateur")
 * @ORM\Entity(repositoryClass="Id2i\Core\UserBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\MappedSuperclass
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(
 *              name     = "email"
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *              name     = "email_canonical"
 *          )
 *      )
 * })
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @Orm\Column(name="register_at",type="datetime")
     */
    protected $registerAt;
    /**
     * @ORM\ManyToMany(targetEntity="Id2i\Core\UserBundle\Entity\Group")
     * @ORM\JoinTable(name="user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
    /**
     * @ORM\ManyToMany(targetEntity="Id2i\Core\MultiSiteBundle\Entity\Site")
     * @ORM\JoinTable(name="user_site",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="site_id", referencedColumnName="id")}
     * )
     */
    protected $sites;
    /**
     * @ORM\ManyToMany(targetEntity="\Id2i\Core\MediaBundle\Entity\Media")
     * @ORM\JoinTable(name="media_user_avatar",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id")}
     *      )
     **/
    private $avatar;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getRegisterAt()
    {
        return $this->registerAt;
    }

    /**
     * @param mixed $registerAt
     */
    public function setRegisterAt($registerAt)
    {
        $this->registerAt = $registerAt;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
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
     * Add avatar
     *
     * @param \Id2i\Core\MediaBundle\Entity\Media $avatar
     *
     * @return User
     */
    public function addAvatar(\Id2i\Core\MediaBundle\Entity\Media $avatar)
    {
        $this->avatar[] = $avatar;

        return $this;
    }

    /**
     * Remove avatar
     *
     * @param \Id2i\Core\MediaBundle\Entity\Media $avatar
     */
    public function removeAvatar(\Id2i\Core\MediaBundle\Entity\Media $avatar)
    {
        $this->avatar->removeElement($avatar);
    }


    /**
     * Returns the user roles
     *
     * @return array The roles
     */
    public function getRoles()
    {
        $roles = $this->roles;

        foreach ($this->getGroups() as $group) {
            $roles = array_merge($roles, $group->getRoles());
        }

        // we need to make sure to have at least one role
        //pas besoin un utilisateur nait avec un role de base enregistré dans roles
        //$roles[] = static::ROLE_DEFAULT;

        return array_unique($roles);
    }

    /**
     * Add sites
     *
     * @param \Id2i\Core\MultiSiteBundle\Entity\Site $sites
     *
     * @return User
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

    public function getForCsv(){
        $datas = array();

        $datas[]= $this->getUsername();
        $datas[]= $this->getEmail();
        $datas[]= $this->isEnabled() == 1 ? "oui":"non" ;
        $datas[]= $this->getLastLogin()->format('d/m/Y H:i') ;

        return $datas;
    }
}
