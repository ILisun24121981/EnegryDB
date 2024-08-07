<?php

require_once 'core/Command.php';
require_once 'core/Request.php';
require_once 'Models/CompanyAddModel.php';
require_once 'Models/CompanyExistCheckModel.php';
require_once 'core/Validator.php';

class UserAddCommand extends ValidateCommand {
    function validExecute(Request $req) {
        $Cecm = new UserExistCheckModel($req);
        $res = $Cecm->process();
        if(!$res){       
            $Cam = new UserAddModel($req);
            $res = $Cam->process();        
            if(!$res){ 
               return self::statuses ('CMD_ERROR');
            }
            return self::statuses ('CMD_OK');
        }
        return self::statuses ('CMD_ERROR');
    }
    function setValidators() {
        $this->AddValidator('Login', Validator::$validSimbols);
        $this->AddValidator('Login', Validator::$MoreSimbols->__invoke(4));
        $this->AddValidator('Password', Validator::$validSimbols);
        $this->AddValidator('Password', Validator::$MoreSimbols->__invoke(3));     
    }
}
