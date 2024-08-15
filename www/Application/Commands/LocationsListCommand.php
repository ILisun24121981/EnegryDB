<?php

require_once 'core/Command.php';
require_once 'core/CommandStrategy.php';
require_once 'core/Request.php';
require_once 'Models/AccessCheckModel.php';
require_once 'Models/LocationsListModel.php';
require_once 'core/Registry.php';
require_once 'core/Command.php';


class LocationsListCommand extends Command {
    
    function mainExecute() {
        $acm = new AccessCheckModel();
        $res = $acm->process();
        if(!$res){
           return self::status('CMD_ERROR') ;
        }
        $lsm = new LocationsListModel();
        $lsm->process($this->_request);
        SessionRegistry::setDefaultCommandName($this);
        return self::status('CMD_OK');
        
    }   
}
