<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\Block;
use App\Service\ValeurService;

class BlockController extends AbstractController
{
    /**
     * @Route("/block", name="block")
     */
    public function index()
    {
        return $this->render('block/index.html.twig', [
            'controller_name' => 'BlockController',
        ]);
    }
    
    /**
     * @Route("/ajax/block/{id}/{timeline}/{numw}/{year}", defaults={"numw" = 0, "year" = null}, name="ajax_block")
     * @ParamConverter("block", options={"id" = "id"})
     */
    public function loadBlock(Block $block, string $timeline, int $numw = 0, int $year = 0, ValeurService $dataService) {
        
        if($block->getPage()->getCategorie()->getUser()->getId() != $this->getUser()->getId())
        {
            throw new \Exception('Bad ID');
        }
        
        if($numw == 0 || $year == 0)
        {
            $numw = date('W');
            $year = date('Y');
        }
        
        $tabValeurs = array();
        foreach($block->getDatas() as $data)
        {
            $tabValeurs[$data->getId()] = $dataService->getValueInWeek($data, $numw, $year);
        }
       
        
        return $this->render('block/ajax_block.html.twig', [
            'block' => $block,
            'timeline' => $timeline,
            'numweek' => $numw,
            'year' => $year,
            'tabValeurs' => $tabValeurs,
        ]);
        
    }
}
