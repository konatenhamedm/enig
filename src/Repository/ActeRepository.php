<?php

namespace App\Repository;

use App\Entity\Acte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Acte>
 *
 * @method Acte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Acte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Acte[]    findAll()
 * @method Acte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Acte::class);
    }

    public function add(Acte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Acte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
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

//    /**
//     * @return Acte[] Returns an array of Acte objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Acte
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
