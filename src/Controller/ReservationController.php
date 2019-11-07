<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Entity\Reservation;
use App\Exception\ReservationException;
use App\Form\Model\ReservationModel;
use App\Form\ReservationType;
use App\Service\ApartmentService;
use App\Service\ReservationService;
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
     * @param ReservationService $reservationService
     * @param ApartmentService $apartmentService
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function prepareApartmentsForNewReservation(Request $request, ReservationService $reservationService, ApartmentService $apartmentService)
    {
        $form = $this->createForm(ReservationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $reservationModel = $form->getData();
                $message = $reservationService->create($reservationModel);
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
