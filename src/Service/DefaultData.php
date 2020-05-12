<?php
namespace App\Service;

use App\Entity\User;
use App\Entity\Block;
use App\Entity\Page;
use App\Entity\Categorie;

/**
 * Class qui va créer les données par défaut pour un nouveau user
 *
 * @author Aymeric
 *        
 */
class DefaultData
{
    /**
     * Génère les données par défaut à la création d'un nouvel user
     *
     * @param User $user
     * @return User $user
     */
    public function newData(?User $user)
    {
        // Déjà une catégorie qui existe, on ne fait rien
        if($user->getCategories()->count() > 1)
        {
            return $user;
        }
        $user->addCategory($this->createCategorie());
        
        return $user;
    }
    
    /**
     * Permet de créer un nouveau Block
     * @return \App\Entity\Block
     */
    private function createBlock()
    {
        $block = new Block();
        $block->setDisabled(false);
        $block->setName('Mes statistiques ici');
        
        return $block;
    }
    
    /**
     * Permet de créer une nouvelle page
     * @return \App\Entity\Page
     */
    private function createPage()
    {
        $page = new Page();
        $page->setDisabled(false);
        $page->setName('Statistiques');
        $page->addBlock($this->createBlock());
        
        return $page;
    }
    
    /**
     * Permet de créer une nouvelle catégorie
     * @return \App\Entity\Categorie
     */
    private function createCategorie()
    {
        $categorie = new Categorie();
        $categorie->setDisabled(false);
        $categorie->setName('Data Ingressum');
        $categorie->setIcon('fas fa-landmark');
        $categorie->addPage($this->createPage());
        
        return $categorie;
    }
}