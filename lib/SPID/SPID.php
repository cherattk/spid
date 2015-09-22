<?php
/**
 *@author karim cheratt
 * 
 */
namespace SPID;

abstract class SPID
{
    
    protected $plugFolder = array(
        'data.source' => '\SPID\Plug\DataSource'
    );
    
    protected $driverFolder = '\SPID\Driver\DataSource';

    protected $plugContainer;

    public function __construct()
    {       
        $this->plugContainer = new \Slim\Helper\Set();
    }
    
    public function DataSource($config = array())
    {
        return $this->plug('data.source' , $config);
    }
    
    /**
     * 
     * @param sring $plug type of plug
     * @param string $driver
     * @param array $config driver configuration
     * @return null or plug instance
     */
    private function plug($plug , $config)
    {
        if(!isset($config['driver']) || !isset($config['config'])){
            return;
        }
        
        $driverConfig = $config['config'];
        $driverClass = $this->driverFolder . '\\'. $config['driver'];

        $plugClass= $this->plugFolder[$plug];
        
        $plugInstanceName = serialize($config) . $plug ;
        
        if($this->plugContainer->has($plugInstanceName)){
            return $this->plugContainer[$plugInstanceName];
        }

        $driverFile = str_replace('\\', DIRECTORY_SEPARATOR, $driverClass) ;
        $driverPath = __DIR__ . substr($driverFile,strlen(__NAMESPACE__) + 1);

        if(is_file($driverPath . '.php')){

            $driverInstance = new $driverClass($driverConfig);
            $instance = new $plugClass($driverInstance);
            

            $this->plugContainer->singleton($plugInstanceName,function()use($instance){                
                return $instance;
            });
            
            return $this->plugContainer[$plugInstanceName];
        }
        
    }
}
