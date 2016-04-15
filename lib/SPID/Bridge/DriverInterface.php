<?php
/**
 *@author karim cheratt
 * 
 */

namespace SPID\Bridge;

interface DriverInterface
{    
    // return void
    public function open_connection();    
    
    // return void
    public function close_connection();
    
    // return void
    public function start_transaction();
    
    // return void
    public function commit_transaction();
    
    // return void
    public function cancel_transaction();
    
    // return void
    //public function prepare_query($query);
    
    // return void
    public function execute_query($query , $query_param);
    
    //return boolean
    public function status();
    
    /* return mixed data */
    public function result();
    
    /* return string error message */
    public function error_message();
    
    
}