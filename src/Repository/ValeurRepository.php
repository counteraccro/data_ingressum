<?php

namespace App\Repository;

use App\Entity\Valeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Data;

/**
 * @method Valeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Valeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Valeur[]    findAll()
 * @method Valeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Valeur::class);
    }

    /**
     * Retourne une liste de valeur en fonction d'une data et d'une plage de date
     * @param Data $data
     * @param string $date_debut
     * @param string $date_fin
     * @return mixed|\Doctrine\DBAL\Driver\Statement|array|NULL
     */
    public function findbyDataAndBetweenDate(Data $data, $date_debut, $date_fin)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.date BETWEEN :date_debut AND :date_fin')
            ->andWhere('v.data = :data')
            ->setParameter('date_debut', $date_debut)
            ->setParameter('date_fin', $date_fin)
            ->setParameter('data', $data)
            ->orderBy('v.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    /**
     * Permet de retourner une valeur en fonction du data et d'une date
     * @param Data $data
     * @param string $date
     * @return number|NULL
     */
    public function findByDataAndDate(Data $data, $date)
    {
        return $this->createQueryBuilder('v')
        ->andWhere('v.date = :date')
        ->andWhere('v.data = :data')
        ->setParameter('date', $date)
        ->setParameter('data', $data)
        ->setMaxResults(1)
        ->getQuery()
        ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Valeur
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
