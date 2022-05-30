<?php

namespace App\Repository;

use App\Entity\TypeSociete;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeSociete>
 *
 * @method TypeSociete|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeSociete|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeSociete[]    findAll()
 * @method TypeSociete[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeSocieteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeSociete::class);
    }

    public function add(TypeSociete $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeSociete $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getFichier($value){
        return $this->createQueryBuilder("a")
            ->select("f.libelle")
            ->innerJoin('a.documents','f')
            ->where('a.id=:id')
//            ->andWhere('f.path IS NOT NULL')
            ->setParameter('id', $value)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return TypeSociete[] Returns an array of TypeSociete objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeSociete
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
