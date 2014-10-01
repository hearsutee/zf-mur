<?php


return [
    'controllers' =>
        [
            'invokables' =>
                [
                    'Mur\Controller\User' => 'Mur\Controller\UserController'
                ],
        ],
    'router' =>
        [
            'routes' =>
                [
                    'home' =>
                        [
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' =>
                                [
                                    'route' => '/',
                                    'defaults' =>
                                        [
                                            'controller' => 'Mur\Controller\User',
                                            'action' => 'index',
                                        ],
                                ],
                        ],

                    'mur' =>
                        [
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' =>
                                [
                                    'route' => '/mur',
                                    'defaults' =>
                                        [
                                            '__NAMESPACE__' => 'Mur\Controller',
                                            'controller' => 'User',
                                            'action' => 'index',
                                        ],

                                ],
                        ],
                    'may_terminate' => true,
                    'child_routes' => [
                        'default' => [
                            'type'    => 'Segment',
                            'options' => [
                                'route'    => '/[:controller[/:action]]',
                                'constraints' => [
                                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                ],
                                'defaults' => [
                                ],
                            ],
                        ],
                    ],

                ],
        ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
    ],
    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ],
        ],
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'mur/user/index' => __DIR__ . '/../view/mur/user/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    // Placeholder for console routes
    'console' => [
        'router' => [
            'routes' => [
            ],
        ],
    ],
];
