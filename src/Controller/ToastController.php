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
        $toastParams = [
            [
                'delay' => '2500',
                'head_txt' => 'Welcome Back',
                'body_txt' => 'Bon retour sur DataIngressum'
            ],
            [
                'delay' => '4000',
                'head_txt' => 'Encore une chose',
                'body_txt' => 'En fait non c\'est bon'
            ]

        ];

        return $this->render('toast/webcomeBack.html.twig', [
            'toastParams' => $toastParams,
        ]);
    }
}
