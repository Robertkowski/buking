<?php

namespace App\Service;

use App\Entity\Reservation;
use App\Exception\ReservationException;

class ReservationService extends AbstractService
{

    /**
     * @param Reservation $reservation
     * @return string|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws ReservationException
     */
    public function create(Reservation $reservation)
    {
        $response = $this->handleErrors($reservation);

        if (empty($response)) {
            $this->saveEntity($reservation);
            $response = $this->prepareSuccessMessage($reservation);
        }

        return $response;
    }

    /**
     * @param Reservation $reservation
     * @throws ReservationException
     */
    private function handleErrors(Reservation $reservation)
    {
        $dateDifference = $reservation->getBookingFrom()->diff($reservation->getBookingTo());
        if ($dateDifference->invert) {
            throw new ReservationException('Sorry, reservation failed.');
        }
        $filters = ['from' => $reservation->getBookingFrom(), 'to' => $reservation->getBookingTo()];
        $apartment = $reservation->getApartment();
        $sumTakenSlots = $this->entityManager->getRepository(Reservation::class)->getSumTakenSlotsForApartment($apartment, $filters);
        $emptySlots = ($sumTakenSlots + $reservation->getTakenSlots()) <= $apartment->getSlots();
        if (!$emptySlots) {
            throw new ReservationException('Sorry, reservation failed. In this time is not enough space in apartment');
        }
    }

    private function prepareSuccessMessage(Reservation $reservation)
    {
        $apartment = $reservation->getApartment();
        $dateDifference = $reservation->getBookingFrom()->diff($reservation->getBookingTo());
        $discount = $dateDifference->format('%a') >= 7 ? $apartment->getDiscountOverSevenDays() : false;
        if ($discount) {
            $message = 'The apartment reservation was successful. Your discount is ' . $discount . '%';
        } else {
            $message = 'The apartment reservation was successful.';
        }
        return $message;
    }

}
