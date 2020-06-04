<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\Data;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DataController extends AbstractController
{
    /**
     * @Route("/data", name="data")
     */
    public function index()
    {
        return $this->render('data/index.html.twig', [
            'controller_name' => 'DataController',
        ]);
    }
    
    /**
     * 
     * @Route("/ajax/data/save", name="ajax_save_data", methods={"POST"})
     * 
     */
    public function saveData(Request $request)
    {
        $data_post = $request->request->get('data');
        print_r($data_post);
        
        return new JsonResponse(['response' => true, 'data' => $data_post]);
    }
}
