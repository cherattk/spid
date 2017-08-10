<?php
namespace SPID\Driver;

class PDODriver implements \SPID\Bridge\DriverInterface
{        
    private $pdo;
    
    private $error;
    
    private $pdo_statement;
    
    //HTTP TEXT STATUS 
    private $status_text = '';
    
    private $query_type = '';
    
    private $status_code = array(
        'OK' => 200, 
        'CREATED' => 201,
        'DELETED' => 204,
        'ERROR' => 500,
        'BAD_REQUEST' => 400,
        'NOT_FOUND' => 404,
        'NOT_MODIFIED' => 304);
    
    
    private $setting = array(
        "open"=>false,        
        "dsn"=>"",
        "db.user"=> null,
        "db.pass"=>null);
    
    private $query = array('query'=>null , 'param'=>null);
    
    public function __construct($setting)
    {
        $this->setting = array_merge($this->setting , $setting);
    }
    
    public function open_connection()
    {    
        // Connection
        if(!$this->setting["open"]){
            
            $DSN = $this->setting["dsn"];
            $DBUser = $this->setting["db.user"];
            $DBPass = $this->setting["db.pass"];
            
            if($DBUser){
                $this->pdo = new \PDO($DSN, $DBUser, $DBPass);
            }else{
                $this->pdo = new \PDO($DSN); 
            }
            
            $this->setting["open"] = true;

            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE , \PDO::FETCH_ASSOC);

        }
    }
    
    public function close_connection()
    {
        $this->pdo = null;
        $this->setting["open"] = false;
        //$this->pdo_statement->closeCursor();
        //$this->pdo_statement = null;
    }
    
    public function start_transaction()
    {
        $this->pdo->beginTransaction();
    }
    
    public function commit_transaction()
    {
        $this->pdo->commit();
    }
    
    public function cancel_transaction()
    {
        $this->pdo->rollBack();
    }
    
    public function error_message()
    {        
        return $this->error;        
    }
    
    public function status()
    {
        return $this->status_code[$this->status_text];
    }
    
//    public function prepare_query($query)
//    {                 
//        $tab = explode(';', strtolower($query));
//        
//        // 6 length of major query
//        $this->query_type = substr($tab[count($tab)-2] , 0 , 6);
//            
//        if(in_array($this->query_type ,array('select' ,'insert' , 'update' , 'delete'))){
//            $this->pdo_statement = $this->pdo->prepare($query);
//            $this->status_text = 'OK';
//            
//        }else{
//            $this->status_text = 'BAD_REQUEST';
//        }
//    }
    
    public function execute_query($query , $param_value = array())
    {
        $tab = explode(';', strtolower($query));
        
        // 6 length of major query
        $this->query_type = substr($tab[count($tab)-2] , 0 , 6);
            
        // TODO check if query is already prepared
        $this->pdo_statement = $this->pdo->prepare($query);
        $this->pdo_statement->execute($param_value);
        
        $this->error = $this->pdo_statement->errorInfo();
        
    }
    
    public function result()
    {
        //$this->status_text = ($this->error[0] !== "00000") ? 'ERROR' : 'OK';
        $result = ['status' => 500 , 'data' => null];
        
        if($this->error[0] !== "00000"){
            $this->status_text = 'ERROR';
            $result['data'] = $this->error;
            return $result;
        }
        
        $query = $this->query_type;
        
        if($query == 'select'){
            $result['data'] = $this->pdo_statement->fetchAll();
            $this->status_text = $result['data'] ? 'OK' :  'NOT_FOUND';
            
        }else{
            $result['data'] = $this->pdo_statement->rowCount();        
            if( $query == 'update' || $query == 'insert'){
                $this->status_text = $result['data'] ? 'CREATED' :  'NOT_MODIFIED';
                
            }elseif( $query == 'delete'){
                $this->status_text = $result['data'] ? 'DELETED' :  'NOT_MODIFIED';
            }
        }
                
        $result['status'] = $this->status();
        
        $this->pdo_statement->closeCursor();
        $this->pdo_statement = null;
        
        return $result;
    }
}


