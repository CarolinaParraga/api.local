<?php

namespace App\Repository;

use App\Entity\Reservation;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function add(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    private function addUserFilter(QueryBuilder $qb, User $user)
    {
        if (in_array('ROLE_ADMIN', $user->getRoles()) === false) {
            $qb->innerJoin('reservation.customer', 'user')
                ->andWhere($qb->expr()->eq('reservation.customer', ':user'))
                ->setParameter('user', $user);
        }
    }

    public function findAvailability(string $startdate, string $enddate){
        $qb = $this->createQueryBuilder('reservation');

        if (!is_null($startdate) && $startdate !== '') {
            $dtFechaInicial = DateTime::createFromFormat('Y-m-d', $startdate);
            $dtFechaFinal = DateTime::createFromFormat('Y-m-d', $enddate);
            $qb ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->between('reservation.startdate', $dtFechaInicial, $dtFechaFinal),
                    $qb->expr()->between('reservation.enddate', $dtFechaInicial, $dtFechaFinal),
                    $qb->expr()->andX(
                        $qb->expr()->lte('reservation.startdate', $dtFechaInicial ),
                        $qb->expr()->gte('reservation.enddate', $dtFechaFinal ))
                )
            );


        }

    }

    public function findReservations(?string $order, ?string $moto , ?User $customer,
                                     ?string $pickuplocation, ?string $returnlocation,
                                     ?string $startdate, ?string $enddate, ?string $starthour,
                                     ?string $endhour, ?bool $state)
    {
        $qb = $this->createQueryBuilder('reservation');

        if (!is_null($moto) && $moto !== '') {
            $qb->innerJoin('reservation.moto', 'moto');

            $qb ->andWhere(
                $qb->expr()->like('moto.model', ':moto')
            )->setParameter('moto', '%'.$moto.'%');
        }


        if (!is_null($pickuplocation) && $pickuplocation !== '') {
            $qb ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('reservation.pickuplocation', ':val')
                )
            )->setParameter('val', '%'.$pickuplocation.'%');
        }

        if (!is_null($returnlocation) && $returnlocation !== '') {
            $qb ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('reservation.pickuplocation', ':val')
                )
            )->setParameter('val', '%'.$returnlocation.'%');
        }

        if (!is_null($startdate) && $startdate !== '') {
            $dtFechaInicial = DateTime::createFromFormat('Y-m-d', $startdate);
            $qb ->andWhere($qb->expr()->gte('reservation.startdate', ':startdate'))
                ->setParameter('startdate', $dtFechaInicial);
        }

        if (!is_null($enddate) && $enddate !== '') {
            $dtFechaFinal = DateTime::createFromFormat('Y-m-d', $enddate);
            $qb ->andWhere($qb->expr()->lte('reservation.enddate', ':enddate'))
                ->setParameter('enddate', $dtFechaFinal);
        }

        if (!is_null($starthour) && $starthour !== '') {
            $qb ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('reservation.starthour', ':val')
                )
            )->setParameter('val', '%'.$starthour.'%');
        }

        if (!is_null($endhour) && $endhour !== '') {
            $qb ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('reservation.endhour', ':val')
                )
            )->setParameter('val', '%'.$endhour.'%');
        }

        if (!is_null($customer))
            $this->addUserFilter($qb, $customer);

        if (!is_null($order)) {
            $qb->addOrderBy('startdate' . $order, 'ASC');
        }

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Reservation[] Returns an array of Reservation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reservation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
