Introduction:
------------
SPID (Service - Plug - Interface – Driver).
PHP Micro-Library to access data. (Bridge Design Pattern)

Requirement:
------------
  - PHP >= 5.3.0
  - Any Autoloader

Usage Example:
-------------
```php
<?php

require_once './anyAutoloader.php';

$serviceConfig = array(
    'spid' =>array(
        'plug' => '\SPID\Plug\PlugSQL',
        'driver' => '\SPID\Driver\PDODriver',
        'driver.config' => array(
            // required for PDODriver
            'dsn' => 'mysql:dbname=myDB;host=localhost;port=3306;',            
            'db.user' => 'username',
            'db.pass' => 'pass'
        )
    )
);

// init
$spid = new SPID\SPID();
$plug = $spid->getPlugInstance($serviceConfig['spid']);

$statement = "select * from `myDB`.`myTable` where myField = :mark limit 10;";
$param = [':mark'=> '1'];

$plug->addQuery($statement , $param);
$data = $plug->execute();

header('Content-Type: application/json');
$plug->renderJSON($data[0]);
```
