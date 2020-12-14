<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * Permet d'ajouter une Catégorie
     * @Route("/ajax/categorie/add", name="add_categorie")
     */
    public function addCategorie(): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);

        return $this->render('categorie/ajax_add_categorie.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
