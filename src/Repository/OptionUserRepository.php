<?php

namespace App\Repository;

use App\Entity\OptionUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OptionUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionUser[]    findAll()
 * @method OptionUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionUser::class);
    }

    // /**
    //  * @return OptionUser[] Returns an array of OptionUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OptionUser
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
