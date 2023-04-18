<?php

namespace App\Repository;

use App\Entity\Moto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;


/**
 * @extends ServiceEntityRepository<Moto>
 *
 * @method Moto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Moto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Moto[]    findAll()
 * @method Moto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Moto::class);
    }

    public function add(Moto $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Moto $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findMotos(
        ?string $order, ?string $carregistration , ?string $model, ?string $color,
        ?string $brand, ?int $price)
    {
        $qb = $this->createQueryBuilder('moto');

        if (!is_null($carregistration) && $carregistration !== '') {
            $qb ->andWhere(
                $qb->expr()->like('moto.carregistration', ':val')
            )->setParameter('val', '%'.$carregistration.'%');
        }

        if (!is_null($model) && $model !== '') {
            $qb ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('moto.model', ':val')
                )
            )->setParameter('val', '%'.$model.'%');
        }

        if (!is_null($color) && $color !== '') {
            $qb ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('moto.color', ':val')
                )
            )->setParameter('val', '%'.$color.'%');
        }

        if (!is_null($brand) && $brand !== '') {
            $qb ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('moto.brand', ':val')
                )
            )->setParameter('val', '%'.$brand.'%');
        }

        if (!is_null($price) && $price !== '') {
            $qb ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('moto.price', ':val')
                )
            )->setParameter('val', '%'.$price.'%');
        }

        if (!is_null($order)) {
            $qb->addOrderBy('moto.' . $order, 'ASC');
        }

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Moto[] Returns an array of Moto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Moto
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
