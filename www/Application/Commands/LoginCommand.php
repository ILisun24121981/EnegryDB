<?php

require_once 'core/Command.php';
require_once 'core/Request.php';
require_once 'Models/AccessOpenModel.php';
require_once 'core/Validator.php';
require_once 'core/Registry.php';


class LoginCommand extends ValidateCommand {
    function __construct() {
        $ss = new FreeStrategy();
        parent::__construct($ss);
    } 
    function validExecute(Request $req) {        
        $Am = new AccessOpenModel($req);
        $res = $Am->process();        
        if(!$res){
           return self::status('CMD_ERROR') ;
        }
        SessionRegistry::setDefaultCommand($this);
        return self::status('CMD_OK');
    }
    function setValidators() {
        $this->AddValidator('Login', Validator::$validSimbols);
        $this->AddValidator('Login', Validator::$MoreSimbols->__invoke(4));
        $this->AddValidator('Password', Validator::$validSimbols);
        $this->AddValidator('Password', Validator::$MoreSimbols->__invoke(3));       
    }    
}
