<?php

namespace App\Repository;

use App\Entity\Apartment;
use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
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

    /**
     * @param Apartment $apartment
     * @param $filters
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function getSumTakenSlotsForApartment(Apartment $apartment, $filters)
    {
        return $this->createQueryBuilder('r')
            ->select('sum(r.takenSlots)')
            ->andWhere('r.apartment = :apartment')
            ->andWhere('(r.bookingFrom BETWEEN :from AND :to OR r.bookingTo BETWEEN :from AND :to)')
            ->setParameter('apartment', $apartment->getId())
            ->setParameter('from', $filters['from'])
            ->setParameter('to', $filters['to'])
            ->getQuery()
            ->getSingleScalarResult();
    }

}
