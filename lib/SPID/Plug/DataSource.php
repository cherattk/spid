<?php
/**
 *@author karim cheratt
 * 
 */
namespace SPID\Plug;

class DataSource
{
    private $query = array(
        'token' => '', 
        'query' => '' , 
        'param' => null
    );
    
    private $driver;
    
    private $result = array();
    
    public function __construct(\SPID\DriverInterface\DataSourceInterface $driver)
    {
        $this->driver = $driver;
    }
    
    public function connect()
    {
        $this->driver->open_connection();
    }
        
    private function queryToken($query)
    {
        return md5($query);
    }
    
    public function errorMessage()
    {
        return $this->driver->error_message();
    }
    
    public function getStatus()
    {
        return $this->driver->status();
    }
    
    public function getResult($query = '')
    {        
        $token = $query ? $this->queryToken($query) : $this->query['token'];
                
        return $this->result[$token];
    }
    
    public function executeQuery($query)
    {        
        // TODO : Check if  query = {select , update , insert , delete}
        // TODO : query['query'] must be a string
        
        // add token to query
        $token = $query['token'] = $this->queryToken($query['query']);
        
        $this->query = array_merge($this->query , $query);
        
        $this->driver->execute_query($this->query['query'],  $this->query['param']);
        
        $this->result[$token] = $this->driver->query_result();
            
    }
    
    public function executeWork($pool = array())
    {        
        $this->driver->start_transaction();
        
        foreach ($pool as $query) {
            
            $this->executeQuery($query);
            
            if($this->driver->error()){
                
                $this->driver->cancel_transaction();
                $err = true;
                break;
            }
        }        
        if(!isset($err)){
            $this->driver->commit_transaction();
        }
    }
    
}
