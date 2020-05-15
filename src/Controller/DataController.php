<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\Data;

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
     * @Route("/ajax/data/{id}", name="data")
     * @ParamConverter("post", options={"id" = "post_id"})
     * 
     */
    public function loadData(Data $data)
    {
        
    }
}
