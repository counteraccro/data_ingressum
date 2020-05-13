<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @IsGranted("ROLE_USER")
 * @author Aymeric
 *
 */
class MenuController extends AbstractController
{
    /**
     * @Route("/menu", name="menu")
     */
    public function index()
    {
        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
        ]);
    }
    
    /**
     * Permet de généré le menu de gauche
     * @Route("/ajax/menu", name="ajax_menu")
     */
    public function menu()
    {
        //$user = $this->getUser();
        
        return $this->render('menu/ajax_leftmenu.html.twig');
        
    }
}
