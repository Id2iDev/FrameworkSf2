<?php
namespace Id2i\Core\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Id2i\Core\UserBundle\Entity\Group;
use Id2i\Core\UserBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setEmail('admin@id2i.net');
        $userAdmin->setPassword('admin');
        $password = $userAdmin->getPassword();
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($userAdmin);

        $userAdmin->setPassword($encoder->encodePassword($password, $userAdmin->getSalt()));
        $userAdmin->setLastLogin(new\DateTime());
        $userAdmin->setRegisterAt(new\DateTime());

        $group = new Group();
        $group->setName("Super-Administrateur");
        $group->addRole('ROLE_SUPER_ADMIN');
        $userAdmin->addGroup($group);

        $group = new Group();
        $group->setName("Administrateur");
        $group->addRole('ROLE_ADMIN');
        $manager->persist($group);

        $group = new Group();
        $group->setName("Utilisateur");
        $group->addRole('ROLE_USER');
        $manager->persist($group);

        $manager->persist($userAdmin);
        $manager->flush();
    }
}