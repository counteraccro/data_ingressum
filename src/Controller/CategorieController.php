<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\User;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * Permet d'ajouter une Catégorie
     * @Route("/ajax/categorie/manage", name="manage_categorie")
     * @param Request $request
     * @return Response
     */
    public function manageCategorie(Request $request): Response
    {
        $content = $request->getContent();
        $content = json_decode($content);

        $entityManager = $this->getDoctrine()->getManager();

        $categorie = new Categorie();
        $categorie->setName($content->name);
        $categorie->setDisabled(0);
        $categorie->setIcon('fas ' . $content->icon);

        foreach ($content->order as $order) {
            if ($order->id == 'new') {
                $categorie->setPosition($order->order);
                break;
            }
        }

        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->find($this->getUser()->getId());
        $user->addCategory($categorie);

        foreach ($user->getCategories() as &$cat) {
            /** @var Categorie $cat */
            foreach ($content->order as $order) {

                if ($order->id == $cat->getId()) {
                    $cat->setPosition($order->order);
                }
            }
        }
        $entityManager->flush();

        return $this->json(['response' => true]);
    }

    /**
     * Permet d'ajouter une Catégorie
     * @Route("/ajax/categorie/modal", name="modal_categorie")
     */
    public function modaleAddCategorie(): Response
    {
        return $this->render('categorie/modal_manage_categorie.html.twig', [

        ]);
    }

    /**
     * Liste les icones de type fa-
     * @Route("/ajax/categorie/iconfa", name="iconfa_categorie")
     * @return Response
     */
    public function listIconFa(): Response
    {
        return $this->render('categorie/ajax_list_icon_fa.html.twig', [

        ]);
    }
}
