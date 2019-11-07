<?php

namespace App\Form\Model;

use App\Entity\Apartment;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class ReservationModel
{

    /**
     * @Assert\NotNull()
     * @var DateTime
     */
    public $bookingFrom;

    /**
     * @Assert\NotNull()
     * @var DateTime
     */
    public $bookingTo;

    /**
     * @Assert\NotNull()
     * @var integer
     */
    public $takenSlots;

    /**
     * @Assert\NotNull()
     * @var Apartment
     */
    public $apartment;


}