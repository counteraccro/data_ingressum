<?php
namespace App\Service;

use App\Entity\User;
use App\Entity\Block;
use App\Entity\Page;
use App\Entity\Categorie;
use App\Entity\Data;
use App\Entity\Valeur;
use App\Entity\Option;
use App\Entity\Rule;

/**
 * Class qui va créer les données par défaut pour un nouveau user
 *
 * @author Aymeric
 *        
 */
class DefaultDataService extends DefaultValueService
{

    /**
     *
     * @var User
     */
    private $user;

    /**
     *
     * @var OptionService
     */
    private $optionService;

    public function __construct(OptionService $optionService)
    {
        $this->optionService = $optionService;
    }

    /**
     * Génère les données par défaut à la création d'un nouvel user
     *
     * @param User|null $user
     * @return User $user
     */
    public function newData(?User $user): ?User
    {
        // Déjà une catégorie qui existe, on ne fait rien
        if ($user->getCategories()->count() > 1) {
            return $user;
        }

        $this->user = $user;

        $tabCat = $this->createCategorie($this->default_data);

        foreach ($tabCat as $categorie) {
            $this->user->addCategory($categorie);
        }

        $this->user = $this->optionService->createDefaultOption($this->user);

        return $this->user;
    }

    /**
     * Créer un objet de type Value
     *
     * @param array $tab
     * @return Valeur
     */
    private function createValue(array $tab): Valeur
    {
        $value = new Valeur();
        foreach ($tab as $key => $val) {

            if ($key == 'setDate') {
                $val = new \DateTime(date('d-m-Y', time()));
            }

            $value->{$key}($val);
        }

        return $value;
    }

    /**
     * Créer un objet de type Data
     *
     * @param array $tab
     * @return Data
     */
    private function createData(array $tab): Data
    {
        $data = new Data();
        foreach ($tab as $key => $val) {
            switch ($key) {
                case 'addValeurs':
                    foreach ($val as $value) {
                        $data->{$key}($this->createValue($value));
                    }
                    break;
                case 'addRule':
                    foreach ($val as $value) {
                        $data->{$key}($this->createRule($value));
                    }
                    break;
                case 'setUser':
                    $data->{$key}($this->user);
                    break;
                default:
                    $data->{$key}($val);
                    break;
            }
        }

        return $data;
    }

    /**
     * Permet de créer un nouveau Block
     *
     * @param array $tab
     * @return Block
     */
    private function createBlock(array $tab): Block
    {
        $block = new Block();
        foreach ($tab as $key => $val) {
            switch ($key) {
                case 'addData':
                    foreach ($val as $data) {
                        $block->{$key}($this->createData($data));
                    }
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
     * @param array $tab
     * @return Page
     */
    private function createPage(array $tab): Page
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
     * @param array $tab
     * @return array
     */
    private function createCategorie(array $tab): array
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

    /**
     * Permet de créer une nouvelle option
     *
     * @param array $options
     * @return User
     */
    private function createOption(array $options)
    {
        foreach ($options as $op) {
            $option = new Option();
            foreach ($op as $key => $value) {
                $option->{$key}($value);
            }
            $this->user->addOption($option);
        }
    }

    /**
     * Permet de créer une nouvelle règle
     * @param array $tab
     * @return Rule
     */
    private function createRule(array $tab): Rule
    {
        $rule = new Rule();
        foreach ($tab as $key => $val) {
            $rule->{$key}($val);
        }
        return $rule;
    }
}