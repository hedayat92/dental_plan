<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'controllers' => array(
        'invokables' => array(
            'Dashboard\Controller\Dashboard' => 'Dashboard\Controller\DashboardController',
      ),
    ),
    'router' => array(
        'routes' => array(
            'dashboard' => array(
        		'type' => 'Segment',
        		'options' => array(
        			'route' => '/dashboard[/:action][/:id]',
        			'constraints' => array(
        				'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        				'id' => '[0-9]+',
        			),
        			'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller'    => 'Dashboard',
                        'action'        => 'index',
        			),
        		),
        	),
        ),
    ),
   'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
