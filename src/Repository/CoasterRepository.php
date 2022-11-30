<?php

namespace App\Repository;

use App\Entity\Coaster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CoasterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coaster::class);
    }

    public function save(Coaster $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Coaster $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSimilar(Coaster $coaster)
    {
        $qb = $this->createQueryBuilder('c');

//        $qb->where(':tags MEMBER OF c.tags');
//        $qb->orWhere('c.manufacturer = :manufacturer');
//        $qb->andWhere('c.id != :id');

//        $qb->where($qb->expr()->isMemberOf(':tags', 'c.tags'));
//        $qb->orWhere($qb->expr()->eq('c.manufacturer', ':manufacturer'));
//        $qb->andWhere($qb->expr()->neq('c.id', ':id'));

        $qb->where(
            $qb->expr()->andX(
                $qb->expr()->orX(
                    $qb->expr()->isMemberOf(':tags', 'c.tags'),
                    $qb->expr()->eq('c.manufacturer', ':manufacturer')
                ),
                $qb->expr()->neq('c.id', ':id')
            )
        );

        $qb->setParameter('tags', $coaster->getTags());
        $qb->setParameter('manufacturer', $coaster->getManufacturer());
        $qb->setParameter('id', $coaster->getId());

        $qb->orderBy('RAND()');
        $qb->setMaxResults(5);
        return $qb->getQuery()->getResult();
    }
}
