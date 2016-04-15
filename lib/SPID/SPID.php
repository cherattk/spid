<?php
/**
 *@author karim cheratt
 * 
 */
namespace SPID;

class SPID
{ 
    protected $container = array();

    public function __construct()
    {       
        //$this->container = new \Slim\Helper\Set();
    }
    
    public function getPlugInstance($config)
    {        
        //$plugIdentifier = serialize($config);
        $driver = $this->getInstance($config['driver'] , $config['driver.config']);
        
        if(is_a($driver , '\SPID\Bridge\DriverInterface')){
            return $this->getInstance($config['plug'], $driver);
        }
    }
    
    public function getInstance($className , $setting = null)
    {
        $signature = serialize(func_get_args());
        
        if(!array_key_exists($signature , $this->container)){
            
            $this->container[$signature] = null;
            if($this->classPath($className)){            
                $this->container[$signature] = new $className($setting);
            }
        }        
        return $this->container[$signature];
    }
    
    public function classPath($className)
    {
        $dir = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $classFile = __DIR__ . substr($dir,strlen(__NAMESPACE__) + 1);
        return is_file($classFile . '.php');
    }
}
