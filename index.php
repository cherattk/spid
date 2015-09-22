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
            'db' => 'data-base-name',
            'db.user' => 'user',
            'db.pass' => 'user-password'
        )
    )
);
    
$service = new \Application\Service($serviceConfig);


$service->serviceSingleQuery();
