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
        $statement = "select * from `book` where auteur = :auteur;";
        $param = [':auteur'=> 'balsac'];
        $this->dbHandler->addQuery($statement , $param);
        $data = $this->dbHandler->execute();
        header('Content-Type: application/json');

        echo json_encode(['result' => $data]);
        //*/
        //echo "<h1>i'm service</h1>";
    }
    
    
}
