<?php
define("APP_PATH" , __DIR__);
define("LIB_PATH" , __DIR__ . str_replace('/', \DIRECTORY_SEPARATOR, '/lib'));

//loader file
$loderPath = __DIR__ . '/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';
$loaderPath = str_replace('/', \DIRECTORY_SEPARATOR, $loderPath);

// Class loader
require_once($loderPath);

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();

// register classes with namespaces
$loader->registerNamespaces(array(
    'Application' => __DIR__,
    'SPID'    =>  LIB_PATH
    ));

// activate the autoloader

$loader->register();