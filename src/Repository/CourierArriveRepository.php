<?php

namespace App\Repository;

use App\Entity\CourierArrive;
use App\Entity\Fichier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CourierArrive|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourierArrive|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourierArrive[]    findAll()
 * @method CourierArrive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourierArriveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourierArrive::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CourierArrive $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getNombre(){
        return $this->createQueryBuilder("a")
            ->select("count(a.id)")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getFichier($value){
        return $this->createQueryBuilder("a")
            ->select("f.path","f.titre")
            ->innerJoin('a.fichiers','f')
            ->where('a.id=:id')
            ->setParameter('id', $value)
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(CourierArrive $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return CourierArrive[] Returns an array of CourierArrive objects
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
    public function findOneBySomeField($value): ?CourierArrive
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
