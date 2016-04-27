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
            'Dashboardfront\Controller\Dashboardfront' => 'Dashboardfront\Controller\DashboardfrontController',
      ),
    ),
    'router' => array(
        'routes' => array(
            'dashboardfront' => array(
        		'type' => 'Segment',
        		'options' => array(
        			'route' => '/dashboardfront[/:action][/:id][/:idd][/:iddd]',
        			'constraints' => array(
        				'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        				'id' => '[0-9]+',
						'idd'=>'[0-9]+',
						'iddd'=>'[0-9]+',
        			),
        			'defaults' => array(
                        '__NAMESPACE__' => 'Dashboardfront\Controller',
                        'controller'    => 'Dashboardfront',
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
