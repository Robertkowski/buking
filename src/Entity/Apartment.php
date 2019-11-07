<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="apartments")
 * @ORM\Entity(repositoryClass="App\Repository\ApartmentRepository")
 */
class Apartment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $slots;

    /**
     * @ORM\Column(type="integer")
     */
    private $discountOverSevenDays;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Apartment
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getSlots(): int
    {
        return $this->slots;
    }

    /**
     * @param int $slots
     * @return $this
     */
    public function setSlots(int $slots): self
    {
        $this->slots = $slots;

        return $this;
    }

    /**
     * @return int
     */
    public function getDiscountOverSevenDays(): int
    {
        return $this->discountOverSevenDays;
    }

    /**
     * @param int $discountOverSevenDays
     * @return $this
     */
    public function setDiscountOverSevenDays(int $discountOverSevenDays): self
    {
        $this->discountOverSevenDays = $discountOverSevenDays;

        return $this;
    }

}
