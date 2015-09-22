<?php
/**
 *@author karim cheratt
 * 
 */

namespace SPID\Driver\DataSource;

class PDODriver implements \SPID\DriverInterface\DataSourceInterface
{        
    private $pdo;
    
    private $pdo_statement;
    
    //HTTP STATUS CODE 
    private $status_code = 200;
    
    private $http_code = array(
        'OK'           => 200,
        'CREATED'      => 201,
        'DELETED'      => 204,
        'ERROR'        => 500,
        'BAD_REQUEST'  => 400,
        'NOT_FOUND'    => 404,
        'NOT_MODIFIED' => 304,
    );
    
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

            /*
            $DSN = 'mysql:dbname='.$this->setting['db'] .';';
            $DSN .= 'host=' . $this->setting['host'] . ';' ;
            $DSN .= 'port=' . $this->setting['port'] . ';' ;
            */
            
            $DSN = $this->setting["dsn"];
            $DBUser = $this->setting["db.user"];
            $DBPass = $this->setting["db.pass"];    
            
            if($DBUser && $DBPass){
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
    
    public function error()
    {
        return $this->error[0] !== "00000";
    }
    
    public function status()
    {        
        return $this->http_code[$this->status_code];
    }
    
    public function execute_query($query = '' , $param = array())
    {
        // TODO : append ';' to end of query
        $this->query['query'] = $query;
        $this->query['param'] = $param;      
                
        $this->pdo_statement = $this->pdo->prepare($this->query['query']);
        $this->pdo_statement->execute($this->query["param"]);
        $this->error = $this->pdo_statement->errorInfo(); 
    }
    
    public function query_result()
    {        
        if(!$this->error()){        
        
            $tab = explode(';', strtolower($this->query['query']));
            $query = substr($tab[count($tab)-2] , 0 , strlen('select'));

            $data = $this->pdo_statement->fetchAll();

            switch ($query) {
                case 'select' :                
                    $this->status_code = empty($data)  ? 'NOT_FOUND'  : 'OK';         
                    $this->pdo_statement->closeCursor();
                    break;

                case 'update' :
                case 'insert' : 
                        $this->status_code =  $this->pdo_statement->rowCount() ? 'CREATED'  : 'NOT_MODIFIED'; 
                        break;

                case 'delete':
                    $this->status_code =  $this->pdo_statement->rowCount() ? 'DELETED' : 'NOT_MODIFIED';
                    break;

                default: 
                    $this->status_code = 'BAD_REQUEST';
            }

            $this->pdo_statement = null;
            return $data;
        
        }
        
        $this->status_code = 'ERROR';
    }
}


