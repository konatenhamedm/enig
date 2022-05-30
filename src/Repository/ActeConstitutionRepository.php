<?php

namespace App\Repository;

use App\Entity\ActeConstitution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActeConstitution>
 *
 * @method ActeConstitution|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActeConstitution|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActeConstitution[]    findAll()
 * @method ActeConstitution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActeConstitutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActeConstitution::class);
    }

    public function add(ActeConstitution $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ActeConstitution $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


//    /**
//     * @return ActeConstitution[] Returns an array of ActeConstitution objects
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

//    public function findOneBySomeField($value): ?ActeConstitution
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
