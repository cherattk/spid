<?php
/**
 *@author karim cheratt
 * 
 */
/*
*/
require_once './bootstrap.php';

$serviceConfig = array(
    'spid' =>array(
        'plug' => '\SPID\Plug\PlugSQL',
        'driver' => '\SPID\Driver\PDODriver',
        'driver.config' => array(
            // required for PDODriver
            'dsn' => 'mysql:dbname=justread;host=localhost;port=3306;',
            
            //optional for some database
            'db.user' => 'root',
            'db.pass' => 'kalimate_essir'
        )
    )
);

            
$service = new \Application\Service($serviceConfig);


$service->serviceAction();