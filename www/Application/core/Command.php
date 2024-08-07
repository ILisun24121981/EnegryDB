<?php

require_once 'core/Request.php';

abstract class Command {
    private static $STATUS_STRINGS = array(
        'CMD_DEFAULT'=>0,
        'CMD_OK'=>1,
        'CMD_ERROR'=>2,
        'CMD_INSUFFICIENT_DATA'=>3
    );
    
    private $_strategy;
    private $_status = 'CMD_DEFAULT';    

    function __construct(CommandStrategy $cs) {
        $this->_strategy = $cs;
    }
    function execute(){
        $this->_strategy->execute($this);
    }
    function commonExecute(Request $req){      
        print ("<br>Выполнение команды ".get_class($this)."<br>");
        //здесь можно добавить общие действия для всех комманд  
        $this->_status = $this->execute($req);
        RequestRegistry::getRequest()->setLastCommand($this);  
    } 
    
    function getStatus(){
        return $this->_status;
    }
    function setStatus($status){
        $this->_status = status;
    }
    
    static function status($str = 'CMD_DEFAULT'){
        if(empty($str)){
           $str = 'CMD_DEFAULT'; 
        }
        return self::$STATUS_STRINGS[$str];
    }
    
    abstract function mainExecute(Request $req); 
}

abstract class ValidateCommand extends Command{    
    protected $_validators = array();
    
    function __construct(SectionStrategy $ss) {
        Validator::init();
        $this->setValidators();
        parent::__construct($ss);
    }
    protected function addValidator($field, $validator){       
        $this->_validators[$field][] = $validator;
    }
    function validate(Request $req){
        $result = true;
        foreach ($this->_validators as $key => $fieldValidators) {          
            foreach ($fieldValidators as $validator) {
                $validationResult = $validator($req->getProperty($key));               
                if ($validationResult !== true) {
                    Validator::AddMassage($key, $validationResult);
                    $result = false;
                }
            }
        }
        return $result;
    }
    abstract function setValidators();
    function mainExecute(Request $req) {        
        $validationresult = $this->validate($req);       
        if(!$validationresult){
            print"Валидация провалена";
            return self::statuses ('CMD_INSUFFICIENT_DATA') ;
        }
        return $this->doValidExecute($req);
    }
    abstract function validExecute(Request $req);
}








