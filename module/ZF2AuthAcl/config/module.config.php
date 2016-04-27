<?php
return array(
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/login[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ZF2AuthAcl\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                )
            ),
            
           'logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ZF2AuthAcl\Controller',
                        'controller' => 'Index',
                        'action' => 'logout'
                    )
                )
            ),
            'forgetpass' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/forgetpass',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ZF2AuthAcl\Controller',
                        'controller' => 'Index',
                        'action' => 'forgetpass'
                    )
                )
            ),
             'register' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/register[/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ZF2AuthAcl\Controller',
                        'controller' => 'Index',
                        'action' => 'register'
                    )
                )
            ),
            'doctorccpay' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/doctorccpay[/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dadhboardfornt\Controller',
                        'controller' => 'Dadhboardfornt',
                        'action' => 'doctorccpay'
                    )
                )
            ),
              'adminforgetpass' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/adminforgetpass',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ZF2AuthAcl\Controller',
                        'controller' => 'Index',
                        'action' => 'adminforgetpass'
                    )
                )
            ),
            'changeadminpass' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/adminforgetpass',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ZF2AuthAcl\Controller',
                        'controller' => 'Index',
                        'action' => 'adminforgetpass'
                    )
                )
            ),
            'unlockaccounts' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/unlockaccounts[/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ZF2AuthAcl\Controller',
                        'controller' => 'Index',
                        'action' => 'unlockaccounts'
                    )
                )
            ),
              'ragistrationpassword' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/ragistrationpassword[/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ZF2AuthAcl\Controller',
                        'controller' => 'Index',
                        'action' => 'ragistrationpassword'
                    )
                )
            ),
        )
    ),
   'controllers' => array(
        'invokables' => array(
            'ZF2AuthAcl\Controller\Index' => 'ZF2AuthAcl\Controller\IndexController'
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'zf2-auth-acl/index/index' => __DIR__ . '/../view/zf2-auth-acl/index/index.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    )
);
