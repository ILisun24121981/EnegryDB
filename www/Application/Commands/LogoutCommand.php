<?php
require_once 'core/CommandStrategy.php';
require_once 'Models/AccessCloseModel.php';

class LogoutCommand extends Command{
    function __construct(Request $req) {
        $ss = new FreeStrategy();
        parent::__construct($ss,$req);
    } 
    function mainExecute() { 
        $acm = new AccessCloseModel();
        $res = $acm -> process();
        if($res){
           SessionRegistry::clearAll(); 
           return self::status(); 
        }
        return self::status( 'CMD_ERROR' );
    }
}
