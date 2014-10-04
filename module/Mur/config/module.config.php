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
                                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                            ],
                                                        'defaults' =>
                                                            [
                                                            ],
                                                    ],
                                            ],
                                    ],
                            ],
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
                'invokables' =>
                    [
                        //acl
                        'mur.acl' => 'Mur\MurAcl',
                        //form elements
                        'mur.auth.service' => 'Mur\Service\AuthManager',
                        'mur.message.manager' => 'Mur\Service\MessageManager',
                        //Entity
                        'mur.entity.user'     => 'Mur\Entity\User',
                    ],
                'factories' =>
                    [
                        'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                            // If you are using DoctrineORMModule:
                            return $serviceManager->get('doctrine.authenticationservice.orm_default');
                        }
                    ]

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
                        'authentication' => [
                            'orm_default' => [

                                'object_manager'        => 'Doctrine\ORM\EntityManager',
                                'identityClass'        => 'Mur\Entity\User',
                                'identityProperty'     => 'userName',
                                'credentialProperty'   => 'password',

                                'credential_callable'   => function($user, $passwordGiven) {
                                    return ($user->getPassword() === crypt($passwordGiven));
                                },
                            ],
                        ],
                        'mur_entities' =>
                            [
                                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                                'cache' => 'array',
                                'paths' => [__DIR__ . '/../src/Mur/Entity']
                            ],
                        'orm_default' =>
                            [

                                'drivers' =>
                                    [
                                        'Mur\Entity' => 'mur_entities'
                                    ]
                            ],

                    ]
            ],

    ];
