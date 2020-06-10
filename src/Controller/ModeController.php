<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ModeController extends AbstractController
{
    /**
     * @Route("/mode", name="mode")
     */
    public function index()
    {
        return $this->render('mode/index.html.twig', [
            'controller_name' => 'ModeController',
        ]);
    }
    
    /**
     * Affiche la modal pour les options
     *
     * @Route("/ajax/mode/modale", name="ajax_modal_mode")
     */
    public function modalOption()
    {              
        return $this->render('mode/modal_mode.html.twig', []);
    }
}
