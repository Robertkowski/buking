<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Form\ApartmentType;
use App\Form\Model\ApartmentModel;
use App\Service\ApartmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/apartments")
 */
class ApartmentController extends AbstractController
{

    /**
     * @Route("", name="apartments")
     * @param ApartmentService $apartmentService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showList(ApartmentService $apartmentService)
    {
        $apartments = $apartmentService->getApartmentList();
        return $this->render('apartment/apartment_list.html.twig', [
            'apartments' => $apartments,
        ]);
    }

    /**
     * @Route("/new", name="new_apartment")
     * @param Request $request
     * @param ApartmentService $apartmentService
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function new(Request $request, ApartmentService $apartmentService)
    {
        $form = $this->createForm(ApartmentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apartmentModel = $form->getData();
            $apartmentService->create($apartmentModel);
            $this->addFlash('success', 'Apartment added!');
        }

        return $this->render('apartment/new_apartment.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/{apartment}", name="edit_apartment")
     * @param Apartment $apartment
     * @param Request $request
     * @param ApartmentService $apartmentService
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function edit(Apartment $apartment, Request $request, ApartmentService $apartmentService)
    {
        $apartmentModel = ApartmentModel::fromApartment($apartment);
        $form = $this->createForm(ApartmentType::class, $apartmentModel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $apartmentModel = $form->getData();
            $apartmentService->update($apartment, $apartmentModel);
            $this->addFlash('success', 'Apartment Updated!');
            return $this->redirectToRoute('edit_apartment', [
                'apartment' => $apartment->getId(),
            ]);
        }
        return $this->render('apartment/edit_apartment.html.twig', [
            'form' => $form->createView()
        ]);
    }

}