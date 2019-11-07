<?php

namespace App\Service;

use App\Entity\Reservation;
use App\Exception\ReservationException;
use App\Form\Model\ReservationModel;
use DateTime;

class ReservationService extends AbstractService
{

    /**
     * @param ReservationModel $model
     * @return Reservation
     * @throws ReservationException
     */
    public function create(ReservationModel $model): Reservation
    {
        $this->handleErrors($model);

        $reservation = new Reservation();
        $this->setCommonFields($reservation, $model);
        $this->saveEntity($reservation);

        return $reservation;
    }

    /**
     * @param ReservationModel $reservationModel
     * @throws ReservationException
     */
    private function handleErrors(ReservationModel $reservationModel)
    {
        if ($reservationModel->bookingFrom < new DateTime('now')) {
            throw new ReservationException('You are trying to book an apartment with a past date. Please select a different check-in date.');
        }
        $dateDifference = $reservationModel->bookingFrom->diff($reservationModel->bookingTo);
        if ($dateDifference->invert) {
            throw new ReservationException('Sorry, reservation failed.');
        }
        $filters = ['from' => $reservationModel->bookingFrom, 'to' => $reservationModel->bookingTo];
        $apartment = $reservationModel->apartment;
        $sumTakenSlots = $this->entityManager->getRepository(Reservation::class)->getSumTakenSlotsForApartment($apartment, $filters);
        $emptySlots = ($sumTakenSlots + $reservationModel->takenSlots) <= $apartment->getSlots();
        if (!$emptySlots) {
            throw new ReservationException('Sorry, reservation failed. In this time the apartment is occupied');
        }
    }

    public function prepareSuccessMessage(Reservation $reservation)
    {
        $apartment = $reservation->getApartment();
        $dateDifference = $reservation->getBookingFrom()->diff($reservation->getBookingTo());
        $discount = $dateDifference->format('%a') >= 7 ? $apartment->getDiscountOverSevenDays() : false;
        $message = 'The apartment reservation was successful.';
        if ($discount) {
            $message .= ' Your discount is ' . $discount . '%';
        }
        return $message;
    }

    /**
     * @param Reservation $reservation
     * @param ReservationModel $model
     */
    private function setCommonFields(Reservation $reservation, ReservationModel $model)
    {
        $reservation->setApartment($model->apartment);
        $reservation->setTakenSlots($model->takenSlots);
        $reservation->setBookingTo($model->bookingTo);
        $reservation->setBookingFrom($model->bookingFrom);
    }

}
