<?php

namespace App\Repository;

use App\Entity\SeanceLibre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SeanceLibre>
 *
 * @method SeanceLibre|null find($id, $lockMode = null, $lockVersion = null)
 * @method SeanceLibre|null findOneBy(array $criteria, array $orderBy = null)
 * @method SeanceLibre[]    findAll()
 * @method SeanceLibre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeanceLibreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SeanceLibre::class);
    }

    public function add(SeanceLibre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function searchSeanceLibre(string $search): array
    {
        $queryBuilder = $this->createQueryBuilder('u');

        $queryBuilder->where(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('u.nom_seancelibre', ':search'),
            )
        )
            ->setParameter('search', '%' . $search . '%');

        return $queryBuilder->getQuery()->getResult();
    }

    public function remove(SeanceLibre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SeanceLibre[] Returns an array of SeanceLibre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SeanceLibre
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
