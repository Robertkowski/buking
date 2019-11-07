<?php

namespace App\Form\Model;

use App\Entity\Apartment;
use Symfony\Component\Validator\Constraints as Assert;

class ApartmentModel
{

    /**
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @var string
     */
    public $name;

    /**
     * @Assert\NotNull()
     * @var integer
     */
    public $slots;

    /**
     * @Assert\NotNull()
     * @var integer
     */
    public $discountOverSevenDays;

    /**
     * @param Apartment $apartment
     * @return static
     */
    public static function fromApartment(Apartment $apartment): self
    {
        $apartmentModel = new self();
        $apartmentModel->name = $apartment->getName();
        $apartmentModel->slots = $apartment->getSlots();
        $apartmentModel->discountOverSevenDays = $apartment->getDiscountOverSevenDays();

        return $apartmentModel;
    }

}