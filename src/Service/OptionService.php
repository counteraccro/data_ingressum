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
     * Option select_timeline
     *
     * @var string
     */
    public static $option_select_timeline = 'select_timeline';
    
    /**
     * Option select_template
     * @var string
     */
    public static $option_select_template = 'select_template';

    /**
     * Type radio
     *
     * @var integer
     */
    public static $type_radio = 1;

    /**
     * Type select
     *
     * @var integer
     */
    public static $type_select = 2;

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
            'setDefaultValue' => 1,
            'setChoix' => '{"oui":1,"non":0}'
        ],
        [
            'setName' => 'select_timeline',
            'setLabel' => 'Choix timeline',
            'setInfo' => 'Permet de choisir la timeline par défaut pour la saisie des données',
            'setType' => 1,
            'setDefaultValue' => 2,
            'setChoix' => '{"jour":1,"semaine":2,"mois":3}'
        ],
        [
            'setName' => 'select_template',
            'setLabel' => 'Choix du template',
            'setInfo' => 'Permet de choisir le template du site',
            'setType' => 2,
            'setDefaultValue' => 'blue',
            'setChoix' => '{"default":"Template Data Ingressum","blue":"Template Bleu"}'
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