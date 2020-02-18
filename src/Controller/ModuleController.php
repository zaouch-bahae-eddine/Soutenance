<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    /**
     * @Route("/module", name="module")
     */
    public function index()
    {
        return $this->render('module/showDiplome.html.twig', [
            'controller_name' => 'ModuleController',
        ]);
    }
}
