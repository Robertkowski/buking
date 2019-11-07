<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="reservations")
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $bookingFrom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $bookingTo;

    /**
     * @ORM\Column(type="integer")
     */
    private $takenSlots;

    /**
     * @ORM\ManyToOne(targetEntity="Apartment")
     * @ORM\JoinColumn(name="apartment_id", referencedColumnName="id",nullable=false)
     */
    private $apartment;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getBookingFrom(): DateTime
    {
        return $this->bookingFrom;
    }

    /**
     * @param DateTime $bookingFrom
     * @return $this
     */
    public function setBookingFrom(DateTime $bookingFrom): self
    {
        $this->bookingFrom = $bookingFrom;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getBookingTo(): DateTime
    {
        return $this->bookingTo;
    }

    /**
     * @param DateTime $bookingTo
     * @return $this
     */
    public function setBookingTo(DateTime $bookingTo): self
    {
        $this->bookingTo = $bookingTo;

        return $this;
    }

    /**
     * @return int
     */
    public function getTakenSlots(): int
    {
        return $this->takenSlots;
    }

    /**
     * @param int $takenSlots
     * @return $this
     */
    public function setTakenSlots(int $takenSlots): self
    {
        $this->takenSlots = $takenSlots;

        return $this;
    }

    /**
     * @return Apartment
     */
    public function getApartment(): Apartment
    {
        return $this->apartment;
    }

    /**
     * @param Apartment $apartment
     * @return Reservation
     */
    public function setApartment(Apartment $apartment): self
    {
        $this->apartment = $apartment;
        return $this;
    }

}
