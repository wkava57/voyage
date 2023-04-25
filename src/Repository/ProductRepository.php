<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Products>
 *
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function save(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findWithSearch(Search $search)
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
            // besoin de faire une jointure product et catégory
            ->join('p.category', 'c');

        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
//methode setParameter ou on lui passe la clé qui est le nom de la variable injecté au dessus et on deuxième paramètre on lui donne la valeur de cette clé
                ->setParameter('categories', $search->categories);
        }
        if (!empty($search->string)) {
            $query = $query
                ->andWhere('p.name LIKE:string')
//                Ce string que je passe en paramètre est équivaut à search string
                ->setParameter('string', "%{$search->string}%");
        }

        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
