<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/reservations")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("", name="reservations")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $reservation = new Reservation();

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();
        }
        $apartments = $this->getDoctrine()->getRepository(Apartment::class)->findAll();
        return $this->render('reservation/new_reservation.html.twig', [
            'apartments' => $apartments, 'form' => $form->createView()
        ]);
    }


//    /**
//     * @Route("/reservation", name="save_reservation")
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\Response
//     * @throws \Exception
//     */
//    public function save(Request $request)
//    {
//        $parameters = $request->request->all();
//        $filters = ['from' => $parameters['bookingFrom'], 'to' => $parameters['bookingTo']];
//        /** @var Apartment $apartment */
//        $apartment = $this->getDoctrine()->getRepository(Apartment::class)->findOneBy(['id' => $parameters['id']]);
//        $sumTakenSlots = $this->getDoctrine()->getRepository(Reservation::class)->getSumTakenSlotsForApartment($apartment, $filters);
//        $emptySlots = ($sumTakenSlots + $parameters['takenSlots']) <= $apartment->getSlots();
//        $discount = false;
//        if ($emptySlots) {
//            $reservation = new Reservation();
//            $reservation->setBookingFrom(new \DateTime($parameters['bookingFrom']));
//            $reservation->setBookingTo(new \DateTime($parameters['bookingTo']));
//            $reservation->setTakenSlots($parameters['takenSlots']);
//            $reservation->setApartment($apartment);
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($reservation);
//            $entityManager->flush();
//            $dateDifference = $reservation->getBookingFrom()->diff($reservation->getBookingTo());
//            $discount = $dateDifference->format('%a') >= 7 ? $apartment->getDiscountOverSevenDays() : false;
//        }
//
//        return $this->render('reservation/reservation_completed.html.twig', ['discount' => $discount, 'emptySlots' => $emptySlots]);
//    }

}
