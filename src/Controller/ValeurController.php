<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Service\ValeurService;
use Symfony\Component\HttpFoundation\JsonResponse;

class ValeurController extends AbstractController
{
    /**
     * @Route("/valeur", name="valeur")
     */
    public function index()
    {
        return $this->render('valeur/index.html.twig', [
            'controller_name' => 'ValeurController',
        ]);
    }
    
    /**
     *
     * @Route("/ajax/valeur/save", name="ajax_save_valeur", methods={"POST"})
     *
     */
    public function saveData(Request $request, ValeurService $valeurService)
    {
        $data_post = $request->request->get('data');
                
        $response = $valeurService->newValeur($data_post);
        
        return new JsonResponse($response);
    }
}
