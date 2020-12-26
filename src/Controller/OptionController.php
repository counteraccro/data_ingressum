<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\OptionUser;
use App\Service\OptionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
    public function index(): Response
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
    public function modalOption(): Response
    {
        $user = $this->getUser();
        
        /** @var User $user **/
        $optionUsers = $user->getOptionUsers();
        
        return $this->render('option/modal_option.html.twig', ['optionUsers' => $optionUsers]);
    }

    /**
     * Permet de mettre à jour une option
     *
     * @Route("/ajax/option/update/{id_optionUser}/{value}", name="ajax_update_option")
     * @ParamConverter("optionUser", options={"id" = "id_optionUser"})
     * @param OptionUser $optionUser
     * @param string $value
     * @param OptionService $optionService
     * @param Request $request
     * @return JsonResponse
     */
    public function updateOption(OptionUser $optionUser, $value = "", OptionService $optionService, Request $request): JsonResponse
    {
        
        if($value == '')
        {
            return new JsonResponse(['response' => false, 'error' => 'Valeur incorrecte']);
        }
        
        $optionUser->setValue($value);
        $this->getDoctrine()->getManager()->persist($optionUser);
        $this->getDoctrine()->getManager()->flush();
         
        $request->getSession()->set($optionUser->getOptionData()->getName(), $optionUser->getValue());
        
        return new JsonResponse(['response' => true]);
    }
}
