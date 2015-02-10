<?php
namespace Id2i\Core\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Id2i\Core\UserBundle\Entity\Group;
use Id2i\Core\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setEmail('admin@example.fr');
        $userAdmin->setEnabled(true);
        $userAdmin->setPassword('admin');
        $password = $userAdmin->getPassword();
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($userAdmin);

        $userAdmin->setPassword($encoder->encodePassword($password, $userAdmin->getSalt()));
        $userAdmin->setLastLogin(new\DateTime());
        $userAdmin->setRegisterAt(new\DateTime());

        $group = new Group("Super-Administrateur");
        $group->addRole('ROLE_SUPER_ADMIN');
        $manager->persist($group);
        $userAdmin->addGroup($group);

        $group = new Group("Administrateur");
        $group->addRole('ROLE_ADMIN');
        $manager->persist($group);

        $group = new Group("Utilisateur");
        $group->addRole('ROLE_USER');
        $manager->persist($group);

        $manager->persist($userAdmin);
        $manager->flush();
    }
}