<?php
namespace SPID\Plug;

class PlugSQL extends \SPID\Bridge\Bridge
{
    public function __construct($driver)
    {
        parent::__construct($driver);
    }
    
    
    public function cleanQuery($query)
    {
        return preg_replace('/\s+/', ' ', $query);
        //return md5(trim($query));
    }
    
    public function addQuery($queryStatement , $queryParam = null)
    {
        $this->setQuery($this->cleanQuery($queryStatement) , $queryParam);
    }
    
    public function execute()
    {        
        $this->executeTransaction();
        
        foreach($this->result as $result){
            if($result['status'] === 500){
                return [ 'error' => json_encode($result['data']) ];
            }
        }
        return $this->result;
    }
    
    public function renderJSON($data)
    {
        echo json_encode($data);
    }
    
    // todo : check if param count match placeholder
    public function checkParamPlaceholder()
    {
        
    }
}
