<?php
/**
 *@author karim cheratt
 * 
 */
require_once './bootstrap.php';

$serviceConfig = array(
    'data.source' =>array(
        'driver' => 'PDODriver',
        'config' => array(
            // required for PDODriver
            'dsn' => 'pdo.dsn.change-me',
            
            //optional for some database
            'db.user' => 'user',
            'db.pass' => 'user-password'
        )
    )
);
    
$service = new \Application\Service($serviceConfig);


$service->serviceAction();
