<?php
namespace Id2i\Core\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Id2i\CMS\PageBundle\Entity\Page;
use Id2i\CMS\PageBundle\Entity\PageEtat;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Id2i\Core\UserBundle\Entity\User;

class Pages implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager->getConnection()->executeQuery("SET foreign_key_checks = 0;");

        $pageEtat = new PageEtat();
        $pageEtat->setLibelle('brouillon');

        $manager->persist($pageEtat);
        $manager->flush();

        $pageEtat = new PageEtat();
        $pageEtat->setLibelle('A valider');

        $manager->persist($pageEtat);
        $manager->flush();

        $pageEtat = new PageEtat();
        $pageEtat->setLibelle('Validée');

        $manager->persist($pageEtat);
        $manager->flush();

        $manager->getConnection()->executeQuery("SET foreign_key_checks = 1;");
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function getOrder(){
        return 3;
    }
}