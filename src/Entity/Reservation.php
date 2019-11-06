<?php

namespace App\Entity;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingFrom(): ?\DateTime
    {
        return $this->bookingFrom;
    }

    public function setBookingFrom(\DateTime $bookingFrom): self
    {
        $this->bookingFrom = $bookingFrom;

        return $this;
    }

    public function getBookingTo(): ?\DateTime
    {
        return $this->bookingTo;
    }

    public function setBookingTo(\DateTime $bookingTo): self
    {
        $this->bookingTo = $bookingTo;

        return $this;
    }

    public function getTakenSlots(): ?int
    {
        return $this->takenSlots;
    }

    public function setTakenSlots(int $takenSlots): self
    {
        $this->takenSlots = $takenSlots;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getApartment(): ?Apartment
    {
        return $this->apartment;
    }

    /**
     * @param mixed $apartment
     * @return Reservation
     */
    public function setApartment(?Apartment $apartment): self
    {
        $this->apartment = $apartment;
        return $this;
    }

}
