<?php
define("APP_PATH" , __DIR__);
define("LIB_PATH" , __DIR__ . "/lib" );

// Class loader
require_once(LIB_PATH . '/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php');
$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();

// register classes with namespaces
$loader->registerNamespaces(array(
    'Application' => APP_PATH,
    'SPID'    => LIB_PATH,
    ));

// activate the autoloader
$loader->register();