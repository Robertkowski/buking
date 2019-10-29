<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index()
    {
        return $this->render('homepage/homepage.html.twig');
    }

}
