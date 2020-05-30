<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\OptionUser;
use App\Service\OptionService;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @Route("/ajax/option/modale", name="ajax_modal_option")
     */
    public function modalOption()
    {
        $user = $this->getUser();
        
        /** @var \App\Entity\User $user **/
        $optionUsers = $user->getOptionUsers();
        
        return $this->render('option/modal_option.html.twig', ['optionUsers' => $optionUsers]);
    }
    
    /**
     * Permet de mettre à jour une option
     * 
     * @Route("/ajax/option/update/{id_optionUser}/{value}", name="ajax_update_option")
     * @ParamConverter("optionUser", options={"id" = "id_optionUser"})
     */
    public function updateOption(OptionUser $optionUser, $value = "", OptionService $optionService)
    {
        $response = new JsonResponse(['data' => 123]);
        
        return $response;
    }
}
