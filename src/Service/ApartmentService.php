<?php

namespace App\Service;

use App\Entity\Apartment;

class ApartmentService extends AbstractService
{

    /**
     * @param Apartment $apartment
     * @return Apartment
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(?Apartment $apartment): Apartment
    {
        $this->saveEntity($apartment);

        return $apartment;
    }

    /**
     * @param Apartment|null $apartment
     * @return Apartment|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(?Apartment $apartment): Apartment
    {
        $this->saveEntity($apartment);

        return $apartment;
    }

    public function getApartmentList()
    {
        $apartments = $this->entityManager->getRepository(Apartment::class)->findAll();
        return $apartments;
    }

}
