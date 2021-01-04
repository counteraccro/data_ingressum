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

    public static $type_input = 1;
    
    public static $type_liste = 2;
    
    protected $default_data = [
        [
            'setName' => 'Sport',
            'setDisabled' => false,
            'setIcon' => 'fas fa-running',
            'setPosition' => 0,
            'addPage' => [
                [
                    'setName' => 'A la maison',
                    'setDisabled' => false,
                    'addBlock' => [
                        [
                            'setName' => 'Tapis de course',
                            'setDisabled' => false,
                            'addData' => [
                                [
                                    'setLibelle' => 'Nombre de KM parcourus',
                                    'setDescription' => 'Nombre de Km parcourus par jour',
                                    'setTips' => '',
                                    'setDisabled' => false,
                                    'setType' => 1,
                                    'setDefaultValue' => '',
                                    'setPosition' => 1,
                                    'setUser' => '',
                                    'addValeurs' => [
                                        [
                                            'setDate' => '',
                                            'setValeur' => '10',
                                            'setDisabled' => false
                                        ]
                                    ],
                                    'addRule' => [
                                        [
                                            'setRule' => '/^\d+$/',
                                            'setErreurMessage' => 'Chiffre uniquement'
                                        ]
                                    ]
                                    
                                ],
                                [
                                    'setLibelle' => 'Chaine(s) de télé regardée(s) pendant la course',
                                    'setDescription' => 'Les chaines de télé regardé pendant mon sport',
                                    'setTips' => 'L\'unité est en minutes',
                                    'setDisabled' => false,
                                    'setType' => 2,
                                    'setDefaultValue' => 'ORTF;France2;France3;Arte;Canal42',
                                    'setPosition' => 1,
                                    'setUser' => '',
                                    'addValeurs' => [
                                        [
                                            'setDate' => '',
                                            'setValeur' => '1',
                                            'setDisabled' => false
                                        ]
                                    ],
                                    'addRule' => [
                                        [
                                            'setRule' => '/^\d+$/',
                                            'setErreurMessage' => 'Chiffre uniquement',
                                            'setMin' => 0,
                                            'setMax' => 1
                                        ]
                                    ]
                                ],
                                [
                                    'setLibelle' => 'Nombre de Calories perdu',
                                    'setDescription' => 'Le nombre de Calories perdu par séance',
                                    'setTips' => '',
                                    'setDisabled' => false,
                                    'setType' => 1,
                                    'setDefaultValue' => '',
                                    'setPosition' => 1,
                                    'setUser' => '',
                                    'addValeurs' => [
                                        [
                                            'setDate' => '',
                                            'setValeur' => '100',
                                            'setDisabled' => false
                                        ]
                                    ]
                                ],
                                [
                                    'setLibelle' => 'Motivaton pour faire la séance',
                                    'setDescription' => 'Permet de quantifier la motivation pour faire la séance',
                                    'setTips' => 'Ne sert à rien et alors',
                                    'setDisabled' => false,
                                    'setType' => 2,
                                    'setDefaultValue' => 'Aucune motivation;Petite movation;motivé;Super motivé',
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
                            ],
                            
                        ],
                        [
                            'setName' => 'Toal Body',
                            'setDisabled' => false,
                            'addData' => [
                                [
                                    'setLibelle' => 'Nombre de pompes',
                                    'setDescription' => 'Nombre de pompes par séance',
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
                                ],
                                [
                                    'setLibelle' => 'Nombre de d\'abdo',
                                    'setDescription' => 'Nombre de d\'abdo par séance',
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
                    'setName' => 'Dehors',
                    'setDisabled' => false,
                    'addBlock' => [
                        [
                            'setName' => 'Vélos',
                            'setDisabled' => false
                        ],
                        [
                            'setName' => 'Course à pied',
                            'setDisabled' => false
                        ]
                    ]
                ]
            ]
        ],
        [
            'setName' => 'Divers',
            'setDisabled' => false,
            'setIcon' => 'fas fa-home',
            'setPosition' => 1,
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