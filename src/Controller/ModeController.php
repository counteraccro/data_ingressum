<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\ModeService;

class ModeController extends AbstractController
{
    /**
     * @Route("/mode", name="mode")
     */
    public function index(): Response
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
    public function modalOption(): Response
    {              
        return $this->render('mode/modal_mode.html.twig', []);
    }

    /**
     * @Route("/ajax/mode/change/{mode}", name="ajax_change_mode")
     * @param string|null $mode
     * @param ModeService $modeService
     * @return JsonResponse
     */
    public function changeMode(ModeService $modeService, string $mode = null): JsonResponse
    {
        $modeService->changeMode($this->getUser(), $mode);
        
        return new JsonResponse(['response' => true]);
    }
}
