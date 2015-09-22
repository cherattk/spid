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
    
    public function serviceAction()
    {
        /* Example with MySQL Database */
        
        /*************************************
         1 - SQL Statement without parameters
         ************************************
        $query = array(
            'query' => 'select * from `table`;'
        );
        *************************************/
        
        /*************************************
          2 - SQL Statement with parameters
          ************************************
        $query = array(
            'query' => 'select * from `table` where `field` = :field_value;',
            'param' => array(
                ':field_value' => 'field_value',
            ),
        );
        *************************************/
        
        
        $this->DataSource->connect();
        
        $this->DataSource->executeQuery($query);
        
        $data = $this->DataSource->getResult();
        
    }
    
    
}
