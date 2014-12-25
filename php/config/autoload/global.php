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
   'module_layouts' => array(
       'Application' => 'application/layout/layout.phtml',
       'User' => 'user/layout/layour.phtml',
   ),
    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'pgsql:dbname=edudream;host=104.236.104.98',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
        'username' => 'postgres',
        'password' => 'supnet4dmin'
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);
