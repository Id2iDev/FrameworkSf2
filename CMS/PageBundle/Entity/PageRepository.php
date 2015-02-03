<?php

namespace Id2i\CMS\PageBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends EntityRepository
{
    public function findByDomaine(){
        $query = $this->_em->createQuery(
            'SELECT p
                FROM PageBundle:Page p
                JOIN p.node AS n
                JOIN NodeBundle:Node as n2 WITH n.root = n2.root
                JOIN MultiSiteBundle:Site AS s WITH n2.id = s.node
                WHERE
                  n2.parent IS NULL
                  AND s.domaine = :domaine
                ORDER BY p.publiedAt ASC'
        )->setParameter('domaine', $_SERVER['HTTP_HOST']);

        return  $query->getResult();
    }
}