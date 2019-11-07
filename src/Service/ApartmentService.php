<?php

namespace App\Service;

use App\Entity\Apartment;
use App\Form\Model\ApartmentModel;

class ApartmentService extends AbstractService
{

    /**
     * @param ApartmentModel $apartmentModel
     * @return Apartment
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(ApartmentModel $apartmentModel): Apartment
    {
        $apartment = new Apartment();
        $this->setCommonFields($apartment, $apartmentModel);
        $this->saveEntity($apartment);

        return $apartment;
    }

    /**
     * @param Apartment $apartment
     * @param ApartmentModel $apartmentModel
     * @return Apartment
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Apartment $apartment, ApartmentModel $apartmentModel): Apartment
    {
        $this->setCommonFields($apartment, $apartmentModel);
        $this->saveEntity($apartment);

        return $apartment;
    }

    public function getApartmentList()
    {
        $apartments = $this->entityManager->getRepository(Apartment::class)->findAll();
        return $apartments;
    }

    private function setCommonFields(Apartment $apartment, ApartmentModel $apartmentModel)
    {
        $apartment->setName($apartmentModel->name);
        $apartment->setSlots($apartmentModel->slots);
        $apartment->setDiscountOverSevenDays($apartmentModel->discountOverSevenDays);
    }

}
