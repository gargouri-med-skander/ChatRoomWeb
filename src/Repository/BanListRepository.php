<?php

namespace App\Repository;

use App\Entity\BanList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BanList|null find($id, $lockMode = null, $lockVersion = null)
 * @method BanList|null findOneBy(array $criteria, array $orderBy = null)
 * @method BanList[]    findAll()
 * @method BanList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BanListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BanList::class);
    }

    // /**
    //  * @return BanList[] Returns an array of BanList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneById($value): ?BanList
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
