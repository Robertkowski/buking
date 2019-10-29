<?php

namespace App\Controller;

use App\Entity\Apartment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ApartmentController extends AbstractController
{

    /**
     * @Route("/apartments", name="apartments", methods={"GET"})
     */
    public function showList()
    {
        $apartments = $this->getDoctrine()->getRepository(Apartment::class)->findAll();
        return $this->render('apartment/apartment_list.html.twig',[
            'apartments' => $apartments,
        ]);
    }
    /**
     * @Route("/apartments/{apartment}", name="prepare_apartment")
     * @param Apartment|null $apartment
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prepare(?Apartment $apartment)
    {
        if (!$apartment) {
            $apartment = new Apartment();
            $apartment->setName('Set name')->setSlots(0)->setDiscountOverSevenDays(0);
        }
        return $this->render('apartment/apartment.html.twig', ['apartment' => $apartment]);
    }
    /**
     * @Route("/apartments", name="save_apartment", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function save(Request $request)
    {
        $parameters = $request->request->all();
        if (array_key_exists('id', $parameters)) {
            $apartment = $this->getDoctrine()->getRepository(Apartment::class)->find($parameters['id']);
        } else {
            $apartment = new Apartment();
        }
        $apartment->setName($parameters['name']);
        $apartment->setSlots($parameters['slots']);
        $apartment->setDiscountOverSevenDays($parameters['discountOverSevenDays']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($apartment);
        $entityManager->flush();
        return $this->render('apartment/apartment.html.twig', ['apartment' => $apartment]);
    }

}