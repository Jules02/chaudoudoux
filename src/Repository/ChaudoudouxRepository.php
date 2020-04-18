<?php

namespace App\Repository;

use App\Entity\Chaudoudoux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chaudoudoux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chaudoudoux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chaudoudoux[]    findAll()
 * @method Chaudoudoux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChaudoudouxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chaudoudoux::class);
    }

    /**
     * @return Chaudoudoux[] Returns an array of Chaudoudoux objects
     */
    public function findUnseen()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.seen = :val')
            ->setParameter('val', 0)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
    * @return Chaudoudoux[] Returns an array of Chaudoudoux objects
     */
    public function findSeen()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.seen = :val')
            ->setParameter('val', 1)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Chaudoudoux
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
