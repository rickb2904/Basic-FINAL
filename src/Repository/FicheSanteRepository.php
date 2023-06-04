<?php

namespace App\Repository;

use App\Entity\FicheSante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FicheSante>
 *
 * @method FicheSante|null find($id, $lockMode = null, $lockVersion = null)
 * @method FicheSante|null findOneBy(array $criteria, array $orderBy = null)
 * @method FicheSante[]    findAll()
 * @method FicheSante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FicheSanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FicheSante::class);
    }

    public function findLatest()
    {
        try {
            return $this->createQueryBuilder('f')
                ->orderBy('f.date', 'DESC') // Tri par date décroissante
                ->addOrderBy('f.heure', 'DESC') // Tri par heure décroissante
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }


    public function add(FicheSante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FicheSante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FicheSante[] Returns an array of FicheSante objects
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

//    public function findOneBySomeField($value): ?FicheSante
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
