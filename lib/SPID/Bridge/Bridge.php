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
        $this->driver->init_transaction();
    }
    
    private function commitTransaction()
    {
        $this->driver->commit_transaction();
    }
    
    private function cancelTransaction()
    {
        $this->driver->cancel_transaction();
    }
        
    public function getStatusMessage()
    {
        return $this->driver->status_message();
    }
    
    public function getStatusCode()
    {
        return $this->driver->status_code();
    }
    
    protected function isError()
    {
        return (500 === $this->driver->status_code());
    }
        
    public function getQueries()
    {
        return $this->queriesTable;
    }
    
    public function executeQuery($query , $param)
    {        
        $this->driver->execute_query($query , $param);
    }    
    
    public function getResult()
    {
        return $this->driver->get_result();
    }    
    
    
    protected function executeTransaction()
    {
        $this->openConnection();
        $this->startTransation();        
        
        $this->result = null; 
        $commit = true;        
        foreach ($this->queriesTable as $query => $params) {
            
            $commit = $this->runQuery($query , $params);
            if(!$commit){
                $this->cancelTransaction();
                break;
            }
        }
        
        if($commit){ $this->commitTransaction(); }
        
        $this->resetQueries();
    }
    
    public function runQuery($query , array $params)
    {        
        
        if(!empty($params)){
            
            $commit = true;            
            foreach($params as $param)
            {
                $this->executeQuery($query , $param);
                $this->result[] = $this->getResult();

                $error = $this->isError();
                if($error){
                    $commit = false;
                    break;
                }
            }
        }
        else{            
            $this->executeQuery($query);
            $this->result[] = $this->getResult();
            $commit = !$this->isError();
        }
        
        return $commit;
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
    
}
