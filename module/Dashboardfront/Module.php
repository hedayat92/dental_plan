<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Dashboardfront;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Dashboardfront\Model\Dashboardfront;
use Dashboardfront\Model\DashboardfrontTable;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class Module
{
   
   public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
  
   public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Dashboardfront\Model\DashboardfrontTable' => function($sm) {
                   $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table        = new DashboardfrontTable($dbAdapter);
                    return $table;
                },
                
            ),
        );    
    }
}


 
