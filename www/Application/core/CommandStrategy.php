<?php

abstract class CommandStrategy {
    abstract function execute(Command $cmd);
}

class FreeStrategy extends CommandStrategy{
    function execute(Command $cmd){       
        $cmd ->commonExecute();
    }
}

class AccessStrategy extends CommandStrategy{
    private $_roles;
    function _construct(array $roles = null){
        $this->_roles = $roles;
    }
    function execute(Command $cmd){
        $acm = new AccessCheckModel($this->getRoles());
        if($acm->process()){      
            $cmd ->commonExecute();
        }          
    }
    function getRoles(){
        return $this->_roles;
    }
}


