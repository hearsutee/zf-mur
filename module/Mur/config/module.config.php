<?php


return
    [
        'controllers' =>
            [
                'invokables' =>
                    [
                        'Mur\Controller\User' => 'Mur\Controller\UserController',
                        'Mur\Controller\Message' => 'Mur\Controller\MessageController',
                        'Mur\Controller\Authentication' => 'Mur\Controller\AuthenticationController'
                    ],
            ],
        'router' =>
            [
                'routes' =>
                    [
                        'user' =>
                            [
                                'type' => 'Zend\Mvc\Router\Http\Literal',
                                'options' =>
                                    [
                                        'route' => '/user',
                                        'defaults' =>
                                            [
                                                '__NAMESPACE__' => 'Mur\Controller',
                                                'controller' => 'User',
                                                'action' => 'index',
                                            ],

                                    ],
                                'may_terminate' => true,
                                'child_routes' =>
                                    [
                                        'default' =>
                                            [
                                                'type' => 'Segment',
                                                'options' =>
                                                    [
                                                        'route' => '[/:action]',
                                                        'constraints' =>
                                                            [
//                                                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                            ],
                                                        'defaults' =>
                                                            [
                                                            ],
                                                    ],
                                            ],
                                    ],
                            ],
                        'message' =>
                            [
                                'type' => 'Zend\Mvc\Router\Http\Literal',
                                'options' =>
                                    [
                                        'route' => '/message',
                                        'defaults' =>
                                            [
                                                '__NAMESPACE__' => 'Mur\Controller',
                                                'controller' => 'Message',
                                                'action' => 'index',
                                            ],

                                    ],
                                'may_terminate' => true,
                                'child_routes' =>
                                    [
                                        'default' =>
                                            [
                                                'type' => 'Segment',
                                                'options' =>
                                                    [
                                                        'route' => '[/:action]',
                                                        'constraints' =>
                                                            [
//                                                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                            ],
                                                        'defaults' =>
                                                            [
                                                            ],
                                                    ],
                                            ],
                                    ],
                            ],
                        'home' =>
                            [
                                'type' => 'Zend\Mvc\Router\Http\Literal',
                                'options' =>
                                    [
                                        'route' => '/',
                                        'defaults' =>
                                            [
                                                '__NAMESPACE__' => 'Mur\Controller',
                                                'controller' => 'Authentication',
                                                'action' => 'login',
                                            ],

                                    ],
                                'may_terminate' => true,
                                'child_routes' =>
                                    [
                                        'default' =>
                                            [
                                                'type' => 'Segment',
                                                'options' =>
                                                    [
                                                        'route' => '[/:action]',
                                                        'constraints' =>
                                                            [
//                                                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                            ],
                                                        'defaults' =>
                                                            [
                                                            ],
                                                    ],
                                            ],
                                    ],
                            ],
                        'register' =>
                            [
                                'type' => 'Zend\Mvc\Router\Http\Literal',
                                'options' =>
                                    [
                                        'route' => '/register',
                                        'defaults' =>
                                            [
                                                '__NAMESPACE__' => 'Mur\Controller',
                                                'controller' => 'Authentication',
                                                'action' => 'register',
                                            ],

                                    ],
                                'may_terminate' => true,

                            ],



                    ],
            ],
        'service_manager' =>
            [
                'abstract_factories' =>
                    [
                        'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
                        'Zend\Log\LoggerAbstractServiceFactory',
                    ],

                'aliases' =>
                    [
                        'translator' => 'MvcTranslator',
                    ],

            ],
        'translator' =>
            [
                'locale' => 'en_US',
                'translation_file_patterns' =>
                    [
                        [
                            'type' => 'gettext',
                            'base_dir' => __DIR__ . '/../language',
                            'pattern' => '%s.mo',
                        ],
                    ],
            ],

        'view_manager' =>
            [
                'display_not_found_reason' => true,
                'display_exceptions' => true,
                'doctype' => 'HTML5',
                'not_found_template' => 'error/404',
                'exception_template' => 'error/index',
                'template_map' =>
                    [
                        'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
                        'mur/user/index' => __DIR__ . '/../view/mur/user/index.phtml',
                        'error/404' => __DIR__ . '/../view/error/404.phtml',
                        'error/index' => __DIR__ . '/../view/error/index.phtml',
                    ],
                'template_path_stack' =>
                    [
                        __DIR__ . '/../view',
                    ],
            ],
        // Placeholder for console routes
        'console' =>
            [
                'router' =>
                    [
                        'routes' =>
                            [
                            ],
                    ],
            ],
        'doctrine' =>
            [
                'driver' =>
                    [
                        'mur_entities' =>
                            [
                                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                                'cache' => 'array',
                                'paths' => [__DIR__ . '/../src/Mur/Entity']
                            ],
                        'orm_default' =>
                            [
//
                                'drivers' =>
                                    [
                                        'Mur\Entity' => 'mur_entities'
                                    ]
                            ],
                        'authentication' => [
                            'orm_default' => [
                                //should be the key you use to get doctrine's entity manager out of zf2's service locator
                                'objectyManager' => 'Doctrine\ORM\EntityManager',
                                //fully qualified name of your user class
                                'identityClass' => 'Mur\Entity\User',
                                //the identity property of your class
                                'identityProperty' => 'userName',
                                //the password property of your class
                                'credentialProperty' => 'password',
                                //a callable function to hash the password with
                                'credentialCallable' => 'Mur\Entity\User::hashPassword'
                            ],
                        ],
                    ]
            ],

    ];
