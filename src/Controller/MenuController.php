<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\ModeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
    public function index(): Response
    {
        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
        ]);
    }
    
    /**
     * Permet de générer le menu de gauche
     * @Route("/ajax/menu", name="ajax_menu")
     */
    public function menu(): Response
    {
        /** @var User $user  */
        $user = $this->getUser();

        switch ($user->getMode())
        {
            case ModeService::$mode_edit:
                return $this->render('menu/ajax_leftmenu_edit.html.twig');
            default:
                return $this->render('menu/ajax_leftmenu.html.twig');
        }

        
    }
}
