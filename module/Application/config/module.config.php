<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => [
        'routes' => [

            'home' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],

            'post' =>
            [
                'type'      => 'segment',
                'options'   =>
                [
                    'route'         => '/post/:url',
                    'constraint'    =>
                    [
                        'url'       => '[a-zA-Z0-9_-]+',
                    ],
                    'defaults'      =>
                    [
                        'controller'    => 'Application\Controller\Index',
                        'action'        => 'post',
                    ],
                ],
            ],

            'posts' =>
            [
                'type'      => 'segment',
                'options'   =>
                [
                    'route'         => '/posts[/page/:page]',
                    'constraint'    => ['page' => '[0-9]*'],
                    'defaults'  =>
                    [
                        'page'          => 1,
                        'controller'    => 'Application\Controller\Index',
                        'action'        => 'index'
                    ],
                ],
            ],

            'comment' =>
            [
                'type'      => 'segment',
                'options'   =>
                [
                    'route'         => '/comment/post/:postId',
                    'constraint'    =>
                    [
                        'postId'    => '[0-9]+',
                    ],
                    'defaults'      =>
                    [
                        'controller'    => 'Application\Controller\Index',
                        'action'        => 'comment',
                    ]
                ],
            ],

            'tag' =>
            [
                'type'      => 'segment',
                'options'   =>
                [
                    'route'         => '/tag/:tagName[/page/:page]',
                    'constraint'    =>
                    [
                        'tagName'       => '[a-zA-Z0-9_-]+',
                        'page'          => '[0-9]*',
                    ],
                    'defaults'      =>
                    [
                        'page'          => 1,
                        'controller'    => 'Application\Controller\Index',
                        'action'        => 'tag',
                    ],
                ],
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

        'factories' =>
        [
            'front\navigation' => 'Application\Service\Navigation\FrontNavigationFactory',
            'Zend\Authentication\AuthenticationService'     => function($serviceManager) {
                return $serviceManager->get('doctrine.authenticationservice.orm_default');
            }
        ],

        'aliases' =>
        [
            'translator' => 'MvcTranslator',
        ],
    ],

    'form_elements' =>
    [
        'invokables' =>
        [
        ],

        'factories' =>
        [
            'Application\Form\CommentForm'  => 'Application\Form\CommentFormFactory',
        ]
    ],

    'input_filters' =>
    [
        'invokables' =>
        [
            'Application\InputFilter\CommentFilter' => 'Application\InputFilter\CommentFilter',
        ]
    ],

    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),

    'controllers' =>
    [
        'invokables' =>
        [
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ],
    ],

    'view_manager' =>
    [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' =>
        [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' =>
        [
            __DIR__ . '/../view',
        ],
    ],

    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),

    'doctrine' =>
    [
        'driver' =>
        [
            'application_entities' =>
            [
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Application/Entity'],
            ],

            'orm_default' =>
            [
                'drivers' =>
                [
                    'Application\Entity' => 'application_entities',
                ],
            ],
        ],

        'authentication' =>
        [
            'orm_default' =>
                [
                    'object_manager'      => 'Doctrine\ORM\EntityManager',
                    'identity_class'      => 'Application\Entity\User',
                    'identity_property'   => 'login',
                    'credential_property' => 'password',
                    'credential_callable' => function(Application\Entity\User $user, $passwordGiven) {
                        return $user->getPassword() === md5($passwordGiven);
                    },
                ],
        ],

        'configuration' =>
        [
            'orm_default' =>
                [
                    'generate_proxies' => true,
                    'proxy_dir'         => realpath(__DIR__.'/../../data/DoctrineORMModule/Proxy'),
                    'proxy_namespace'   => 'DoctrineProxies',

                    'metadata_cache'   => 'filesystem',
                    'result_cache'     => 'filesystem',
                    'query_cache'      => 'filesystem',
                ]
        ],
    ],

    'view_helpers' =>
    [
        'invokables' =>
        [
        ],
    ],
);
