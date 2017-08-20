<?php
namespace SPID\Bridge;

interface DriverInterface
{    
    // return void
    public function open_connection();    
    
    // return void
    public function close_connection();
    
    // return void
    public function init_transaction();
    
    // return void
    public function commit_transaction();
    
    // return void
    public function cancel_transaction();
    
    // return void
    //public function prepare_query($query);
    
    /**
     * 
     * @param string $query
     * @param string $query_param
     * @return void
     */
    public function execute_query($query , $query_param);
    
    /**
     * return status message
     * @return string status message
     */
    public function status_message();
    
    /**
     * Get driver code based on http-status-code
     * @return integer http-status-code
     */
    public function status_code();
    
    
    /**
     * @return mixed query data-result
     */
    public function get_result();
    
    
    
}