<?php

namespace Application;
use SPID\SPID as SPID;

class Service
{
    protected $dbHandler;

    public function __construct($config)
    {        
        $spid = new SPID();
        $this->dbHandler = $spid->getPlugInstance($config['spid']);
    }
    
    public function serviceAction()
    {
        $statement = "select * from `page`;";
        $param = "";
        $this->dbHandler->addQuery($statement , $param);
        $data = $this->dbHandler->execute();
        echo '<h1>Result</h1>';
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
    
    
}
