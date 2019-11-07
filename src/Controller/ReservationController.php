<?php

namespace App\Controller;

use App\Exception\ReservationException;
use App\Form\ReservationType;
use App\Service\ApartmentService;
use App\Service\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/reservations")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("", name="reservations")
     * @param Request $request
     * @param ReservationService $reservationService
     * @param ApartmentService $apartmentService
     * @return Response
     */
    public function prepareApartmentsForNewReservation(Request $request, ReservationService $reservationService, ApartmentService $apartmentService)
    {
        $form = $this->createForm(ReservationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $reservationModel = $form->getData();
                $reservation = $reservationService->create($reservationModel);
                $message = $reservationService->prepareSuccessMessage($reservation);
                $this->addFlash('success', $message);
            } catch (ReservationException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        $apartments = $apartmentService->getApartmentList();
        return $this->render('reservation/new_reservation.html.twig', [
            'apartments' => $apartments, 'form' => $form->createView()
        ]);
    }

}
