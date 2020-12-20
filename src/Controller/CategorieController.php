<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * Permet d'ajouter une Catégorie
     * @Route("/ajax/categorie/add", name="add_categorie")
     * @param Request $request
     * @return Response
     */
    public function addCategorie(Request $request): Response
    {
        $content = $request->getContent();
        $content = json_decode($content);

        //print_r($content);


        $categorie = new Categorie();
        //$form = $this->createForm(CategorieType::class, $categorie);

        return $this->json(['response' => true]);
    }

    /**
     * Permet d'ajouter une Catégorie
     * @Route("/ajax/categorie/modal", name="modal_categorie")
     */
    public function modaleAddCategorie(): Response
    {
        return $this->render('categorie/modal_add_categorie.html.twig', [

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
