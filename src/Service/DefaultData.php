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
        if ($user->getCategories()->count() > 1) {
            return $user;
        }

        $tabCat = [
            [
                'setName' => 'Data Ingressum',
                'setDisabled' => false,
                'setIcon' => 'fas fa-landmark',
                'addPage' => [
                    [
                        'setName' => 'Statistiques',
                        'setDisabled' => false,
                        'addBlock' => [
                            [
                                'setName' => 'Mes statistiques ici',
                                'setDisabled' => false
                            ],
                            [
                                'setName' => 'Bloc n°2',
                                'setDisabled' => false
                            ]
                        ]
                    ],
                    [
                        'setName' => 'Divers',
                        'setDisabled' => false,
                        'addBlock' => [
                            [
                                'setName' => 'Transport',
                                'setDisabled' => false
                            ],
                            [
                                'setName' => 'Bloc n°2',
                                'setDisabled' => false
                            ]
                        ]
                    ]
                ]
            ],
            [
                'setName' => 'Catégorie démo',
                'setDisabled' => false,
                'setIcon' => 'fas fa-subway',
                'addPage' => [
                    [
                        'setName' => 'Page démo',
                        'setDisabled' => false,
                        'addBlock' => [
                            [
                                'setName' => 'Bloc n°1',
                                'setDisabled' => false
                            ],
                            [
                                'setName' => 'Bloc n°2',
                                'setDisabled' => false
                            ]
                        ]
                    ]
                ]
            ]
        ];

       $tabCat = $this->createCategorie($tabCat);
        
       foreach($tabCat as $categorie)
       {
           $user->addCategory($categorie);
       }

        return $user;
    }

    /**
     * Permet de créer un nouveau Block
     *
     * @return \App\Entity\Block
     */
    private function createBlock(array $tab)
    {
        $block = new Block();
        foreach ($tab as $key => $val) {
            switch ($key) {
                case 'addBlock':
                    /*foreach ($val as $block) {
                        $page->{$key}($this->createBlock($block));
                    }*/
                    break;

                default:
                    $block->{$key}($val);
                    break;
            }
        }
        return $block;
    }

    /**
     * Permet de créer une nouvelle page
     *
     * @return \App\Entity\Page
     */
    private function createPage(array $tab)
    {
        $page = new Page();
        foreach ($tab as $key => $val) {
            switch ($key) {
                case 'addBlock':
                    foreach ($val as $block) {
                        $page->{$key}($this->createBlock($block));
                    }
                    break;

                default:
                    $page->{$key}($val);
                    break;
            }
        }
        return $page;
    }

    /**
     * Permet de créer une nouvelle catégorie
     *
     * @return array
     */
    private function createCategorie(array $tab)
    {
        $return = [];

        foreach ($tab as $cat) {
            $categorie = new Categorie();
            foreach ($cat as $key => $val) {
                switch ($key) {
                    case 'addPage':
                        foreach ($val as $page) {
                            $categorie->{$key}($this->createPage($page));
                        }
                        break;

                    default:
                        $categorie->{$key}($val);
                        break;
                }
            }
            array_push($return, $categorie);
        }
        return $return;
    }
}