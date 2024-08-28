<?php

require_once 'core/Command.php';
require_once 'core/CommandStrategy.php';
require_once 'core/Request.php';
require_once 'Models/AccessCheckModel.php';
require_once 'Models/LocationStructureModel.php';
require_once 'core/Registry.php';
require_once 'core/Command.php';


class LocationStructureCommand extends Command {   
    function mainExecute(Request $req) {
        $acm = new AccessCheckModel();
        $res = $acm->process();
        if(!$res){
           return self::status('CMD_ERROR') ;
        }
        $lsm = new LocationStructureModel();
        $user = ApplicationRegistry::getUser();
        $user->setLocations($lsm->process($req));       
        SessionRegistry::setDefaultCommand($this,$req);
        return self::status('CMD_OK');       
    }   
}
