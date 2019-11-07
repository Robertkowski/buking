<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="apartments")
 * @ORM\Entity(repositoryClass="App\Repository\ApartamentRepository")
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

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Apartment
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSlots(): int
    {
        return $this->slots;
    }

    public function setSlots(int $slots): self
    {
        $this->slots = $slots;

        return $this;
    }

    public function getDiscountOverSevenDays(): int
    {
        return $this->discountOverSevenDays;
    }

    public function setDiscountOverSevenDays(int $discountOverSevenDays): self
    {
        $this->discountOverSevenDays = $discountOverSevenDays;

        return $this;
    }

}
