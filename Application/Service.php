<?php

namespace Application;

class Service extends \SPID\SPID
{
    
    protected $DataSource;


    public function __construct($config)
    {
        parent::__construct();
        
        $this->DataSource = parent::DataSource($config['data.source']);
        
        
    }
    
    public function serviceSingleQuery()
    {
        // sql query without param
        $query = array(
            'query' => 'select * from `table`;'
        );
        
        /* 1 - sql query with param
        $query = array(
            'query' => 'select * from `table` where `field` = :field_value;',
            'param' => array(
                ':field_value' => 'field_value',
            ),
        );
        */
        
        
        $this->DataSource->connect();
        
        $this->DataSource->executeQuery($query);
        
        $data = $this->DataSource->getResult();
        
        var_dump($data);
    }
    
    
}
