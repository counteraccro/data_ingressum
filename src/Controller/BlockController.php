<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\Block;

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
     * @Route("/ajax/block/{id}/{timeline}", name="ajax_block")
     * @ParamConverter("block", options={"id" = "id"})
     */
    public function loadBlock(Block $block, string $timeline) {
        
        if($block->getPage()->getCategorie()->getUser()->getId() != $this->getUser()->getId())
        {
            //throw new \Exception('Bad ID');
        }
        
        return $this->render('block/ajax_block.html.twig', [
            'block' => $block,
            'timeline' => $timeline
        ]);
        
    }
}
