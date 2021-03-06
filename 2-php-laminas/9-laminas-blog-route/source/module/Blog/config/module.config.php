<?php
namespace Blog;

use Laminas\Router\Http\Literal;

use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    
    'service_manager' => [
        'aliases' => [
            Model\PostRepositoryInterface::class => Model\LaminasDbSqlRepository::class,
        ],
        'factories' => [
            Model\PostRepository::class => InvokableFactory::class,
            Model\LaminasDbSqlRepository::class => Factory\LaminasDbSqlRepositoryFactory::class,
        ],
    ],
    
    'controllers' => [
        'factories' => [
            Controller\ListController::class => Factory\ListControllerFactory::class,
        ],
    ],
    
    // This lines opens the configuration for the RouteManager
    'router'          => [
        'routes' => [
            'blog' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/blog',
                    'defaults' => [
                        'controller' => Controller\ListController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'detail' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/:id',
                            'defaults' => [
                                'action' => 'detail',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];