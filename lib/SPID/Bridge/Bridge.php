<?php
namespace SPID\Bridge;

abstract class Bridge
{    
    private $driver;
    
    protected $queriesTable = [];
    
    protected $result = [];

    public function __construct(\SPID\Bridge\DriverInterface $driver)
    {
        $this->driver = $driver;
    }
    
    private function openConnection()
    {
        $this->driver->open_connection();
    }
    
    private function startTransation()
    {
        $this->driver->start_transaction();
    }
    
    private function commitTransaction()
    {
        $this->driver->commit_transaction();
    }
    
    private function cancelTransaction()
    {
        $this->driver->cancel_transaction();
    }
        
    public function getStatus()
    {
        return $this->driver->status();
    }
    
    public function errorMessage()
    {
        return $this->driver->error_message();
    }
        
    protected function executeTransaction()
    {
        $this->openConnection();
        $this->startTransation();        
        
        $this->result = null; 
        $commit = true;        
        foreach ($this->queriesTable as $query => $params) {
            
            $this->runQuery($query , $params);
            
            if($this->isError()){                
                $this->cancelTransaction();
                $commit = false;
                break;
            }
        }        
        if($commit){
            $this->commitTransaction();
        }
        
        $this->resetQueries();
    }
    
    public function runQuery($query , array $params)
    {
        if($params){
            foreach($params as $param){                
                $this->driver->execute_query($query , $param);
                $this->result[] = $this->driver->result();

                if($this->isError()){ break;}
            }
        }
        else{            
            $this->driver->execute_query($query);
            $this->result[] = $this->driver->result();
        }
    }
    
    protected function resetQueries()
    {
        $this->queriesTable = [];
    }
    
    protected function setQueries($query , array $params = [])
    {
        if(!isset($this->queriesTable[$query])){
            $this->queriesTable[$query] = [];            
        }
        $this->queriesTable[$query][] = $params;        
    }
    
    public function getQueries()
    {
        return $this->queriesTable;
    }
    
    
    protected function isError()
    {
        return ( 500 === $this->driver->status() );
    }
    
    
}
