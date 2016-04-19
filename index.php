<?php
/**
 *@author karim cheratt
 * 
 */
require_once './bootstrap.php';

$serviceConfig = array(
    'spid' =>array(
        'plug' => '\SPID\Plug\PlugSQL',
        'driver' => '\SPID\Driver\PDODriver',
        'driver.config' => array(
            // required for PDODriver
            'dsn' => 'mysql:dbname=dbname;host=hostname;port=port;',
            
            //optional for some database
            'db.user' => '',
            'db.pass' => ''
        )
    )
);

            
$service = new \Application\Service($serviceConfig);


$service->serviceAction();