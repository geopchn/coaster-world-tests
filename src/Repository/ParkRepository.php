<?php

namespace App\Repository;

use App\Entity\Park;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\DependencyInjection\Loader\Configurator\expr;

class ParkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Park::class);
    }

    public function save(Park $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Park $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function countManufacturers(Park $park): int
    {
        $qb = $this->createQueryBuilder('p');

        $qb->select($qb->expr()->countDistinct('c.manufacturer'));
        $qb->innerJoin('p.coasters', 'c');

        $qb->where($qb->expr()->eq('p.id', ':parkId'));
        $qb->setParameter('parkId', $park->getId());

        return $qb->getQuery()->getSingleScalarResult();
    }
}
