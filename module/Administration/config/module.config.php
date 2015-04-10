<?php

return
[
    'controllers' =>
    [
        'invokables' =>
        [
            'Administration\Controller\Index' => 'Administration\Controller\IndexController',
            'Administration\Controller\Posts' => 'Administration\Controller\PostsController',
            'Administration\Controller\Tags'  => 'Administration\Controller\TagsController',

        ],
    ],

    'router' =>
    [
        'routes' =>
        [
            'administration' =>
            [
                'type'      => 'segment',
                'options'   =>
                [
                    'route'      => '/administration',
                    'defaults'   =>
                    [
                        '__NAMESPACE__' => 'Administration\Controller',
                        'controller'    => 'Index',
                    ],
                ],

                'child_routes' =>
                [
                    'login' =>
                    [
                        'type'      => 'literal',
                        'options'   =>
                        [
                            'route'     => '/login',
                            'defaults'  =>
                            [
                                'action'    => 'login'
                            ],
                        ],
                    ],

                    'logout' =>
                    [
                        'type'      => 'literal',
                        'options'   =>
                        [
                            'route'     => '/logout',
                            'defaults'   =>
                            [
                                'action'    => 'logout',
                            ],
                        ],
                    ],

                    'posts' =>
                    [
                        'type'      => 'segment',
                        'options'   =>
                            [
                                'route'     => '/posts[/:action[/:id]]',
                                'defaults'  =>
                                [
                                    'controller'    => 'Posts',
                                    'action'        => 'index',
                                ],
                            ],
                    ],

                    'tags' =>
                    [
                        'type'      => 'segment',
                        'options'   =>
                        [
                            'route'     => '/tags[/:action[/:id]]',
                            'defaults'  =>
                            [
                                'controller'    => 'Tags',
                                'action'        => 'index',
                            ],
                        ],
                    ],

                    'pagination' =>
                    [
                        'type'      => 'segment',
                        'options'   =>
                        [
                            'route'         => '/posts[/page/:page]',
                            'defaults'      =>
                            [
                                'page'          => 1,
                                'controller'    => 'Posts',
                                'action'        => 'index',
                            ],

                        ],
                    ],

                    'tagsPagination' =>
                    [
                        'type'      => 'segment',
                        'options'   =>
                        [
                            'route'         => '/tags[/page/:page]',
                            'defaults'      =>
                            [
                                'page'          => 1,
                                'controller'    => 'Tags',
                                'action'        => 'index',
                            ],

                        ],
                    ],
                ],
            ],
        ],
    ],

    'view_manager' =>
    [
        'template_path_stack' =>
        [
            'administration' => __DIR__ . '/../view',
        ],
    ],

    'service_manager' =>
    [
        'invokables' =>
        [

        ],

        'factories' =>
        [
            'navigation'                                    => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ],

        'shared' =>
        [

        ],
    ],

    'input_filters' =>
    [
        'invokables' =>
        [
            'Administration\InputFilter\PostInputFilter'    => 'Administration\InputFilter\PostInputFilter',
            'Administration\InputFilter\TagInputFilter'     => 'Administration\InputFilter\TagInputFilter',
        ],

        'shared' =>
        [

        ],
    ],

    'form_elements' =>
    [
        'invokables' =>
        [

        ],

        'factories' =>
        [
            'Administration\Form\Login'                     => 'Administration\Form\LoginFactory',
            'Administration\Form\PostForm'                  => 'Administration\Form\PostFormFactory',
            'Administration\Form\TagForm'                   => 'Administration\Form\TagFormFactory',

        ],

        'shared' =>
        [

        ],
    ],

    'navigation' =>
    [
        'default' =>
        [
            [
                'label' => 'Home',
                'route' => 'home',
            ],
            [
                'label' => 'Posts',
                'route' => 'administration/posts',
            ],
            [
                'label' => 'Tags',
                'route' => 'administration/tags',
            ],
        ],
    ],

    'view_helper_config' => array(
        'flashmessenger' => array(
            'message_open_format'      => '<div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul><li>',
            'message_close_string'     => '</li></ul></div>',
            'message_separator_string' => '</li><li>'
        )
    ),

    'doctrine' =>
    [
        'driver' =>
        [
            'administration_entities' =>
                [
                    'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/../src/Administration/Entity'],
                ],

            'orm_default' =>
                [
                    'drivers' =>
                        [
                            'Administration\Entity' => 'administration_entities',
                        ],
                ],
        ],
    ],

];