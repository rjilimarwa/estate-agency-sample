<?php

namespace AppBundle\Repository;

/**
 * RegionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RegionRepository extends \Doctrine\ORM\EntityRepository
{
    public function chercher($nom)
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.name like :name')->setParameter('name', '%'.$nom.'%')
        ;

        return $qb->getQuery()->getResult();
    }
}
