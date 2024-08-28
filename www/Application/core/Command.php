<?php

require_once 'core/Request.php';

abstract class Command {
    private static $STATUS_STRINGS = array(
        'CMD_DEFAULT'=>0,
        'CMD_OK'=>1,
        'CMD_ERROR'=>2,
        'CMD_INSUFFICIENT_DATA'=>3
    );
    
    private $_status = 'CMD_DEFAULT';    

    function execute(Request $req){      
        print ("<br>Выполнение команды ".get_class($this)."<br>");
        //здесь можно добавить общие действия для всех комманд  
        $this->_status = $this->mainExecute($req);
        $req->setLastCommand($this);  
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
    
    function __construct() {
        Validator::init();
        $this->setValidators();   
    }
    protected function addValidator($field, $validator){       
        $this->_validators[$field][] = $validator;
    }
    function validate(Request $req){
        $result = true;
        foreach ($this->_validators as $key => $fieldValidators) {          
            foreach ($fieldValidators as $validator) {
                $val = $req->get($key);
                $validationResult = $validator($val);               
                if ($validationResult !== true) {
                    Validator::AddMassage($key, $validationResult);
                    $result = false;
                }
            }
        }
        return $result;
    }
    function mainExecute(Request $req) {        
        $validationresult = $this->validate($req);       
        if(!$validationresult){
            print"Валидация провалена";
            return self::status('CMD_INSUFFICIENT_DATA') ;
        }
        return $this->validExecute($req);
    }
    abstract function setValidators();
    abstract function validExecute(Request $req);
}








