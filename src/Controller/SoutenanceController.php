<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SoutenanceController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index()
    {
        return $this->render('soutenance/index.html.twig', [
        ]);
    }
}
