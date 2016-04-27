<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */


return array(
   'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=dental_plan;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
            => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    'moduleLayouts' => array(
		'Application' => 'layout/layout.phtml',
		'Dashboardfront' => 'layout/dashboardfront.phtml',
	),
	'smtp_settings' => array(
		'username' => 'reporting@healthrise.com',
		'password' => 'healthrise',
		'host' => 'smtp.gmail.com',
		'port' => 465,
		'ssl' => 'ssl',
		'connection_class' => 'plain',
    ),
    'email_sender' => array(
		'email' => 'reporting@healthrise.com',
		'name' => 'Dentalplan',
	),

);
