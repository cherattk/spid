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
        //*
        $statement = "select * from `myDB`.`myTable` where fieldName = :mark;";
        $param = [':mark'=> 'balsac'];
        $this->dbHandler->addQuery($statement , $param);
        $data = $this->dbHandler->execute();
        header('Content-Type: application/json');
        
        $this->renderJSON($data);
    }
    
    public function renderJSON($data)
    {
        echo json_encode(['result' => $data]);
    }
    
    
}
