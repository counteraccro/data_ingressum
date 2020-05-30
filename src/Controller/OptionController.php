<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @IsGranted("ROLE_USER")
 * @author Aymeric
 *
 */
class OptionController extends AbstractController
{
    /**
     * @Route("/option", name="option")
     */
    public function index()
    {
        return $this->render('option/index.html.twig', [
            'controller_name' => 'OptionController',
        ]);
    }
    
    /**
     * Affiche la modal pour les options
     * 
     * @Route("/ajax/modal_option", name="ajax_modal_option")
     */
    public function modalOption()
    {
        $user = $this->getUser();
        
        /** @var \App\Entity\User $user **/
        $optionUsers = $user->getOptionUsers();
        
        return $this->render('option/modal_option.html.twig', ['optionUsers' => $optionUsers]);
    }
}
