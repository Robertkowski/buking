<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Form\ApartmentType;
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
     */
    public function showList()
    {
        $apartments = $this->getDoctrine()->getRepository(Apartment::class)->findAll();
        return $this->render('apartment/apartment_list.html.twig', [
            'apartments' => $apartments,
        ]);
    }

    /**
     * @Route("/new", name="new_apartment")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $apartment = new Apartment();

        $form = $this->createForm(ApartmentType::class, $apartment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $apartment = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apartment);
            $entityManager->flush();
        }
        return $this->render('apartment/new_apartment.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/{apartment}", name="edit_apartment")
     * @param Apartment|null $apartment
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(?Apartment $apartment, Request $request)
    {
        $form = $this->createForm(ApartmentType::class, $apartment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apartment);
            $entityManager->flush();
//            $this->addFlash('success', 'Apartment Updated!');
//            return $this->redirectToRoute('edit_apartment', [
//                'id' => $article->getId(),
//            ]);
        }
        return $this->render('apartment/edit_apartment.html.twig', [
            'form' => $form->createView()
        ]);
    }

}