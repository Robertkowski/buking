<?php

namespace App\Service;

use App\Entity\Apartment;
use App\Form\Model\ApartmentModel;

class ApartmentService extends AbstractService
{

    /**
     * @param ApartmentModel $apartmentModel
     * @return Apartment
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
     */
    public function update(Apartment $apartment, ApartmentModel $apartmentModel): Apartment
    {
        $this->setCommonFields($apartment, $apartmentModel);
        $this->saveEntity($apartment);

        return $apartment;
    }

    /**
     * @return object[]
     */
    public function getApartmentList()
    {
        $apartments = $this->entityManager->getRepository(Apartment::class)->findAll();
        return $apartments;
    }

    /**
     * @param Apartment $apartment
     * @param ApartmentModel $apartmentModel
     */
    private function setCommonFields(Apartment $apartment, ApartmentModel $apartmentModel)
    {
        $apartment->setName($apartmentModel->name);
        $apartment->setSlots($apartmentModel->slots);
        $apartment->setDiscountOverSevenDays($apartmentModel->discountOverSevenDays);
    }

}
