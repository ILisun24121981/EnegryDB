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
    private $_accessCheckModel;
    
    function _construct(array $roles){
        $this->_accessCheckModel = new AccessCheckModel($roles);
    }
    function execute(Command $cmd){ 
        if($this->_accessCheckModel->process()){      
            $cmd ->commonExecute();
        }          
    }
}


