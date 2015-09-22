<?php

namespace SPID\DriverInterface;

interface DataSourceInterface
{    
    public function open_connection();    
    
    public function close_connection();
    
    public function start_transaction();
    
    public function commit_transaction();
    
    public function cancel_transaction();
    
    public function execute_query($query , $param);
    
    // return http-status code
    public function status();
    
    //return boolean
    public function error();
    
    /* return data */
    public function query_result();
    
    /* return error message*/
    public function error_message();
    
    
}