<?php

namespace App\Repository;

use App\Entity\ThemeMembre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ThemeMembre|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThemeMembre|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThemeMembre[]    findAll()
 * @method ThemeMembre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThemeMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThemeMembre::class);
    }

    // /**
    //  * @return ThemeMembre[] Returns an array of ThemeMembre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    /**
     * @throws NonUniqueResultException
     */
    public function findOneByIdTheme($value): ?ThemeMembre
    {
        return $this->createQueryBuilder('tm')
            ->andWhere('tm.idTheme = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    /**
     * @return ThemeMembre[] Returns an array of Theme objects
     */
    public function findByGmailThemeMember($gmail):array
    {
        return $this->createQueryBuilder('tm')
            ->where('tm.gmail LIKE :x')
            ->setParameter('x', '%'.$gmail.'%')
            ->getQuery()
            ->getResult();
    }
}
