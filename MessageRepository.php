<?php
namespace App\Repository;


use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Calendar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Calendar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Calendar[]    findAll()
 * @method Calendar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findAllWithSearch(?string $term)
    {
        $qb=$this->getEntityManager();
        $commande1='SELECT u.nom,m.contenumessage,m.dateEnvoi,m.idMessage
              FROM App\Entity\User u INNER JOIN App\Entity\Message m with u.idUser=m.iduserrecever
              where u.nom like :term OR m.contenumessage like :term';
        $commande='SELECT u.nom,m.contenumessage,m.dateEnvoi,m.idMessage
              FROM App\Entity\User u INNER JOIN App\Entity\Message m with u.idUser=m.iduserrecever';

        if ($term) {
            $res = $qb->createQuery($commande1)
                    ->setParameter('term', '%' . $term . '%');
        }
        else{
            $res = $qb->createQuery($commande);

        }

        return $res
            ->getResult();

    }

    public  function  triedecroissant()
    {
        $qb=$this->getEntityManager();
        $commande='SELECT u.nom,m.contenumessage,m.dateEnvoi,m.idMessage
              FROM App\Entity\User u INNER JOIN App\Entity\Message m with u.idUser=m.iduserrecever order by m.dateEnvoi DESC';

        $res = $qb->createQuery($commande);


        return $res
            ->getResult();

    }

    // /**
    //  * @return Calendar[] Returns an array of Calendar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Calendar
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