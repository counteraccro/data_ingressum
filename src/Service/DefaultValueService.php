<?php
namespace App\Service;

/**
 * Class qui contient l'ensemble des données à enregistrer par default à la création d'un nouveau user
 *
 * @author aymer
 *        
 */
class DefaultValueService
{

    protected $default_data = [
        [
            'setName' => 'Au travail',
            'setDisabled' => false,
            'setIcon' => 'fas fa-landmark',
            'addPage' => [
                [
                    'setName' => 'Important',
                    'setDisabled' => false,
                    'addBlock' => [
                        [
                            'setName' => 'Statistiques Société X',
                            'setDisabled' => false,
                            'addData' => [
                                [
                                    'setLibelle' => 'Nombre de mails',
                                    'setDescription' => 'Mails reçus par jour',
                                    'setTips' => '',
                                    'setDisabled' => false,
                                    'setType' => 1,
                                    'setDefaultValue' => '',
                                    'setPosition' => 1,
                                    'setUser' => '',
                                    'addValeurs' => [
                                        [
                                            'setDate' => '',
                                            'setValeur' => '1',
                                            'setDisabled' => false
                                        ]
                                    ]
                                ],
                                [
                                    'setLibelle' => 'Projets',
                                    'setDescription' => 'Projets auquels j\'ai participé',
                                    'setTips' => 'L\'unité est la journée de travail',
                                    'setDisabled' => false,
                                    'setType' => 2,
                                    'setDefaultValue' => 'Projet1;Projet2;Projet3;Projet4|Projet3',
                                    'setPosition' => 1,
                                    'setUser' => '',
                                    'addValeurs' => [
                                        [
                                            'setDate' => '',
                                            'setValeur' => '1',
                                            'setDisabled' => false
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            'setName' => 'Réunions',
                            'setDisabled' => false,
                            'addData' => [
                                [
                                    'setLibelle' => 'Nombre de réunions',
                                    'setDescription' => 'Réunions faite par jour',
                                    'setTips' => '',
                                    'setDisabled' => false,
                                    'setType' => 1,
                                    'setDefaultValue' => '',
                                    'setPosition' => 2,
                                    'setUser' => '',
                                    'addValeurs' => [
                                        [
                                            'setDate' => '',
                                            'setValeur' => '1',
                                            'setDisabled' => false
                                        ]
                                    ]
                                ]
                            ]
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
}