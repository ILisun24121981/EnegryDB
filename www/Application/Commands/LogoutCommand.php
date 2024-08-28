<?php
require_once 'core/CommandStrategy.php';
require_once 'Models/AccessCloseModel.php';

class LogoutCommand extends Command{
    function mainExecute(Request $req) { 
        $acm = new AccessCloseModel();
        $acm -> process();        
        SessionRegistry::clearAll(); 
        return self::status();        
    }
}
