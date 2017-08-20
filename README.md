Introduction:
------------
SPID (Service - Plug - Interface – Driver).
PHP Micro-Library to access data. (Bridge Design Pattern)

Requirement:
------------
  - PHP >= 5.4
  - Any Autoloader

Usage Example:
-------------
##### 1 - Download /lib/SPID folder
##### 2 - Register SPID path in your autoloader 
##### 3 - Add following code to index.php

```php
<?php

require_once './anyAutoloaderThatRegisterSPID.php';

$serviceConfig = array(
    'plug' => '\SPID\Plug\PlugSQL',
    'driver' => '\SPID\Driver\PDODriver',
    'driver.config' => array(
        // required for PDODriver
        'dsn' => 'mysql:dbname=myDB;host=localhost;port=3306;',            
        'db.user' => 'username',
        'db.pass' => 'pass'
    )
);

// init
$spid = new SPID\SPID();
$plug = $spid->getPlugInstance($serviceConfig);

$query_a = "select * from `myDB`.`tab_one` where `myField` = :mark limit 10;";
$param_a = [':mark'=> 'not-found-value'];

$plug->addQuery($statement_a , $param_a);

// sql required to be end with ";"
$plug->addQuery("select * from `myDB`.`tab_two` limit 10;");

$data = $plug->execute();

header('Content-Type: application/json');
$plug->renderJSON($data);

/* output array
    [
       {
            "status":404,
            "data":[]
       },
       {
           "status":200,
           "data":[
                   {"table_field":"value",...}
                ]
       }            
   ]
*/

```
