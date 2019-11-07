<?php

namespace App\Service;

use App\Entity\Reservation;
use App\Exception\ReservationException;
use App\Form\Model\ReservationModel;

class ReservationService extends AbstractService
{

    /**
     * @param Reservation $model
     * @return string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws ReservationException
     */
    public function create(ReservationModel $model)
    {
        $response = $this->handleErrors($model);

        if (empty($response)) {
            $reservation = new Reservation();
            $this->setCommonFields($reservation, $model);
            $this->saveEntity($reservation);
            $response = $this->prepareSuccessMessage($reservation);
        }

        return $response;
    }

    /**
     * @param Reservation $reservationModel
     * @throws ReservationException
     */
    private function handleErrors(ReservationModel $reservationModel)
    {
        $dateDifference = $reservationModel->bookingFrom->diff($reservationModel->bookingTo);
        if ($dateDifference->invert) {
            throw new ReservationException('Sorry, reservation failed.');
        }
        $filters = ['from' => $reservationModel->bookingFrom, 'to' => $reservationModel->bookingTo];
        $apartment = $reservationModel->apartment;
        $sumTakenSlots = $this->entityManager->getRepository(Reservation::class)->getSumTakenSlotsForApartment($apartment, $filters);
        $emptySlots = ($sumTakenSlots + $reservationModel->takenSlots) <= $apartment->getSlots();
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

    private function setCommonFields(Reservation $reservation, ReservationModel $model)
    {
        $reservation->setApartment($model->apartment);
        $reservation->setTakenSlots($model->takenSlots);
        $reservation->setBookingTo($model->bookingTo);
        $reservation->setBookingFrom($model->bookingFrom);
    }

}
