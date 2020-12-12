<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\Block;
use App\Service\ValeurService;

class BlockController extends AbstractController
{
    /**
     * @Route("/block", name="block")
     */
    public function index(): Response
    {
        return $this->render('block/index.html.twig', [
            'controller_name' => 'BlockController',
        ]);
    }

    /**
     * @Route("/ajax/block/{id}/{timeline}/{numw}/{year}/{day}", defaults={"numw" = 0, "year" = 0, "day" = 0}, name="ajax_block")
     * @ParamConverter("block", options={"id" = "id"})
     * @param Block $block
     * @param string $timeline
     * @param int $numw
     * @param int $year
     * @param int $day
     * @param ValeurService $dataService
     * @return Response
     * @throws \Exception
     */
    public function loadBlock(Block $block, string $timeline, int $numw = 0, int $year = 0, int $day = 0, ValeurService $dataService): Response
    {
        
        if($block->getPage()->getCategorie()->getUser()->getId() != $this->getUser()->getId())
        {
            throw new \Exception('Bad ID');
        }
        
        if($numw == 0 || $year == 0 )
        {
            $numw = date('W');
            $year = date('Y');
        }
        
        if($day == 0)
        {
            $day = strtotime(date('d-m-Y', time()));
        }
        
        $tabValue = array();
        foreach($block->getDatas() as $data)
        {
            $tabValue[$data->getId()] = $dataService->getValueInWeek($data, $numw, $year);
        }
       
        
        return $this->render('block/ajax_block.html.twig', [
            'block' => $block,
            'timeline' => $timeline,
            'numweek' => $numw,
            'year' => $year,
            'day' => $day,
            'tabValeurs' => $tabValue,
        ]);
        
    }
}
