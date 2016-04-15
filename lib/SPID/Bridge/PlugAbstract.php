<?php
/**
 * @author karim cheratt
 */
namespace SPID\Bridge;

abstract class PlugAbstract
{
    private $driver;

    protected $queriesTable = [];

    // $queriesParam = [string $query][mixed $value]
    protected $queriesParam = [];

    // $queriesParam = ['status'=> int Code , 'data' => mixed]
    protected $result = array();

    public function __construct(\SPID\Bridge\DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /******************************************
                    * PRIVATE *
    *******************************************/

    private function queryID($query)
    {
        return md5($query);
    }

    /******************************************
                    * PUBLIC *
    *******************************************/

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
        $this->result = null;
        $this->driver->open_connection();
        $this->driver->start_transaction();

        $commit = true;
        // sort queriesTable asc
        foreach ($this->queriesTable as $query) {

            $this->runQuery($query);

            if($this->isError()){
                $this->driver->cancel_transaction();
                $commit = false;
                break;
            }
        }
        if($commit){
            $this->driver->commit_transaction();
        }

        $this->resetQueries();
    }

    private function runQuery($query)
    {
        if(!empty($this->queriesParam[$query])){

            foreach($this->queriesParam[$query] as $param){

                $this->driver->execute_query($query , $param);
                $this->result[] = $this->driver->result();

                if($this->isError()){ break;}
            }
        }
        else{
            $this->driver->execute_query();
        }
    }

    protected function resetQueries()
    {
        $this->queriesTable = [];
        $this->queriesParam = [];
    }

    protected function setQuery($query , $param = null)
    {
        if(!in_array($query , $this->queriesTable)){
            $this->queriesTable[] = $query;
        }
        if($param){
           $this->queriesParam[$query][] = $param;
        }
    }


    protected function isError()
    {
        return ( 500 === $this->driver->status() );
    }


}
