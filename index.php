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
            'dsn' => 'mysql:dbname=c9;host=127.0.0.1;port=3306;',
            
            //optional for some database
            'db.user' => 'cherattk',
            'db.pass' => ''
        )
    )
);

            
$service = new \Application\Service($serviceConfig);


$service->serviceAction();