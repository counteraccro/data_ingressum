<?php
namespace App\Service;

/**
 * Class qui contient l'ensemble des données à enregistrer par default à la création d'un nouveau user
 *
 * @author aymer
 *        
 */
class DefaultDataData
{

    protected $default_data = [
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
                            'setDisabled' => false,
                            'addData' => [
                                [
                                    'setLibelle' => 'Donnée input',
                                    'setDescription' => 'Cet exemple vous permet de saisir n\'importe quelle donnée',
                                    'setTips' => 'Y\'a pas plus simple',
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
                                    'setLibelle' => 'Donnée input (encore)',
                                    'setDescription' => 'Cet exemple vous permet de saisir n\'importe quelle donnée',
                                    'setTips' => 'Y\'a pas plus simple',
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
                                ]
                            ]
                        ],
                        [
                            'setName' => 'Bloc n°2',
                            'setDisabled' => false,
                            'addData' => [
                                [
                                    'setLibelle' => 'Donnée liste',
                                    'setDescription' => 'Cet exemple vous permet de compter à partir d\'une liste',
                                    'setTips' => 'Y\'a pas plus simple',
                                    'setDisabled' => false,
                                    'setType' => 2,
                                    'setDefaultValue' => 'Projet1;Projet2;Projet3;Projet4|Projet3',
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