<?php
namespace App\Service;

use App\Entity\User;
use App\Entity\Option;
use App\Entity\OptionUser;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;

/**
 * Class qui va gérer les options du joueur
 *
 * @author Aymeric
 *        
 */
class OptionService
{

    /**
     * Option auto_save
     *
     * @var string
     */
    private $option_auto_save = 'auto_save';

    /**
     * Type oui / non
     *
     * @var integer
     */
    private $type_yes_no = 1;

    /**
     * Options par defaut
     *
     * @var array
     */
    private $defaultOptions = [
        [
            'setName' => 'auto_save',
            'setLabel' => 'Sauvegarde auto',
            'setInfo' => 'Permet de sauvegarder automatiquement la valeur saisie dés que l\'input perd le focus',
            'setType' => 1,
            'setDefaultValue' => 1
        ]
    ];

    private $tmp_defaultOptions = [];

    /**
     *
     * @var Doctrine
     */
    private $doctrine;

    public function __construct(Doctrine $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Permet de générer les options par default et de les ajouter au user
     * Si l'option existe déjà elle n'est pas recréé
     *
     * @param User $user
     * @return \App\Entity\User
     */
    public function createDefaultOption(User $user)
    {
        if (empty($this->tmp_defaultOptions)) {
            foreach ($this->defaultOptions as $op) {
                $option = $this->doctrine->getRepository(Option::class)->findBy(array(
                    'name' => $op['setName']
                ));

                if (! is_object($option)) {
                    $option = new Option();
                    foreach ($op as $key => $value) {
                        $option->{$key}($value);
                    }
                    
                    array_push($this->tmp_defaultOptions, $option);
                }
            }
        }

        foreach ($this->tmp_defaultOptions as $option) {
            $optionUser = new OptionUser();
            $optionUser->setUser($user);
            $optionUser->setOptionData($option);
            $optionUser->setValue($option->getDefaultValue());

            $user->addOptionUser($optionUser);
        }

        return $user;
    }
}