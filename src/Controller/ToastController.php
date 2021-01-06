<?php
/**
 * Permet de gérer les alertes de type Toast
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToastController extends AbstractController
{
    /**
     * @Route("/ajax/toast/welcomeback", name="toast_welcome_back")
     */
    public function webcomeBack(): Response
    {
        return $this->render('toast/webcomeBack.html.twig', [
            'controller_name' => 'ToastController',
        ]);
    }
}
