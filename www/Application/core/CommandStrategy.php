<?php

abstract class CommandStrategy {
    abstract function execute(Command $cmd);
}

class FreeStrategy extends CommandStrategy{
    function execute(Command $cmd){       
        return $cmd ->execute($cmd);
    }
}

class AccessStrategy extends CommandStrategy{
    function execute(Command $cmd){
        $acm = new AccessCheckModel();        
        if($acm->process()){      
            return $cmd->execute($cmd);   
        }       
        return Command::status('CMD_ERROR') ;
    }
}


