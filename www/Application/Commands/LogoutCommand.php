<?php

class LogoutCommand extends Command{
    function __construct() {
        $ss = new FreeStrategy();
        parent::__construct($ss);
    } 
    function mainExecute(Request $req) { 
        $acm = new AccessCloseModel($req);
        $res = $acm -> process();
        if($res){
           SessionRegistry::clearAll(); 
           return self::status( 'CMD_OK' ); 
        }
        return self::status( 'CMD_ERROR' );
    }
}
