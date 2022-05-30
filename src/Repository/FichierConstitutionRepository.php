<?php

namespace App\Repository;

use App\Entity\FichierConstitution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FichierConstitution>
 *
 * @method FichierConstitution|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichierConstitution|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichierConstitution[]    findAll()
 * @method FichierConstitution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichierConstitutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichierConstitution::class);
    }

    public function add(FichierConstitution $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FichierConstitution $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getFichier($value){
        return $this->createQueryBuilder("f")
            ->select("f.libelle","f.dateObtention","f.path")
            ->innerJoin('f.acte','a')
            ->where('a.id=:id')
            ->andWhere('f.path is not null')
            ->setParameter('id', $value)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return FichierConstitution[] Returns an array of FichierConstitution objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FichierConstitution
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
