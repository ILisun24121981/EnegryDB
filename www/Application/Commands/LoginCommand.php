<?php

require_once 'core/Command.php';
require_once 'core/CommandStrategy.php';
require_once 'core/Request.php';
require_once 'Models/AccessOpenModel.php';
require_once 'core/Validator.php';
require_once 'core/Registry.php';
require_once 'core/Command.php';


class LoginCommand extends ValidateCommand {
    function validExecute(Request $req) {      
        $Am = new AccessOpenModel();
        $res = $Am->process($req);        
        if(!$res){
           return self::status('CMD_ERROR') ;
        }       
        return self::status('CMD_OK');
    }
    function setValidators() {       
        $this->AddValidator('password', Validator::$validSimbols);
        $this->AddValidator('password', Validator::$MoreSimbols->__invoke(3));
        $this->AddValidator('login', Validator::$validSimbols);
        $this->AddValidator('login', Validator::$MoreSimbols->__invoke(4));
    }    
}
